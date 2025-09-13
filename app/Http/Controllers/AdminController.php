<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private $firebaseAuth;

    public function __construct()
    {
        try {
            $serviceAccountPath = Storage::path(env('FIREBASE_CREDENTIALS'));

            if (!file_exists($serviceAccountPath)) {
                throw new \Exception('Firebase service account file not found at: ' . $serviceAccountPath);
            }

            $factory = (new Factory)
                ->withServiceAccount($serviceAccountPath)
                ->withDatabaseUri('https://' . env('FIREBASE_PROJECT_ID') . '.firebaseio.com');

            $this->firebaseAuth = $factory->createAuth();
        } catch (\Exception $e) {
            Log::error('Firebase initialization failed: ' . $e->getMessage());
            throw new \Exception('Firebase initialization failed. Please check your configuration.');
        }
    }

    public function dashboard()
    {
        $totalAdmins = Admin::count();
        $dokterCount = Admin::where('hak_akses', 'Dokter')->count();
        $perawatCount = Admin::where('hak_akses', 'Perawat')->count();

        return view('layouts.Dashboard.dashboard', compact('totalAdmins', 'dokterCount', 'perawatCount'));
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $currentAdminId = Auth::id();
        
        $admins = Admin::when($search, function ($query, $search) {
                return $query->where('nama_lengkap', 'like', '%' . $search . '%');
            })
            ->where('id_admin', '!=', $currentAdminId) // Filter admin yang sedang login
            ->paginate(10);

        return view('layouts.Data-admin.data_admin', compact('admins'));
    }

    public function create()
    {
        return view('layouts.Data-admin.tambah_admin');
    }

    // Store a newly created admin in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:8|confirmed',
            'jenis_kelamin' => 'required|string',
            'hak_akses' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:15|regex:/^[0-9]+$/',
        ], [
            'nomor_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'nomor_telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
        ]);

        try {
            $userProperties = [
                'email' => $validatedData['email'],
                'emailVerified' => false,
                'password' => $validatedData['password'],
                'displayName' => $validatedData['nama_lengkap'],
                'disabled' => false,
            ];

            $this->firebaseAuth->createUser($userProperties);
            Admin::create([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'hak_akses' => $validatedData['hak_akses'],
                'nomor_telepon' => $validatedData['nomor_telepon'],
            ]);

            return redirect()->route('admin.index')->with('success', 'Admin created successfully');

        } catch (FirebaseException $e) {
            Log::error('Firebase create user error: ' . $e->getMessage());
            
            $errorMessage = 'Gagal membuat admin. Terjadi kesalahan pada sistem authentication.';
            
            if (strpos($e->getMessage(), 'EMAIL_EXISTS') !== false) {
                $errorMessage = 'Email sudah terdaftar di sistem authentication.';
            }

            return back()->withErrors(['email' => $errorMessage])->withInput();
        } catch (\Exception $e) {
            Log::error('Create admin error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('layouts.Data-admin.tambah_admin', compact('admin'));
    }

    public function update(Request $request, $id_admin)
    {
        $admin = Admin::findOrFail($id_admin);

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $id_admin . ',id_admin',
            'password' => 'nullable|string|min:8|confirmed',
            'jenis_kelamin' => 'required|string',
            'hak_akses' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:15|regex:/^[0-9]+$/',
        ], [
            'nomor_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'nomor_telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
        ]);

        try {
            $firebaseUser = $this->firebaseAuth->getUserByEmail($admin->email);

            $updateProperties = [];

            if ($admin->email !== $validatedData['email']) {
                $updateProperties['email'] = $validatedData['email'];
            }

            if ($request->password) {
                $updateProperties['password'] = $validatedData['password'];
            }

            $updateProperties['displayName'] = $validatedData['nama_lengkap'];

            if (!empty($updateProperties)) {
                $this->firebaseAuth->updateUser($firebaseUser->uid, $updateProperties);
            }

            if ($request->password) {
                $admin->password = Hash::make($validatedData['password']);
            }
            
            $admin->nama_lengkap = $validatedData['nama_lengkap'];
            $admin->email = $validatedData['email'];
            $admin->jenis_kelamin = $validatedData['jenis_kelamin'];
            $admin->hak_akses = $validatedData['hak_akses'];
            $admin->nomor_telepon = $validatedData['nomor_telepon'];
            $admin->save();

            return redirect()->route('admin.index')->with('success', 'Admin updated successfully');

        } catch (UserNotFound $e) {
            Log::warning('Firebase user not found for email: ' . $admin->email);
            
            if ($request->password) {
                $admin->password = Hash::make($validatedData['password']);
            }
            
            $admin->nama_lengkap = $validatedData['nama_lengkap'];
            $admin->email = $validatedData['email'];
            $admin->jenis_kelamin = $validatedData['jenis_kelamin'];
            $admin->hak_akses = $validatedData['hak_akses'];
            $admin->nomor_telepon = $validatedData['nomor_telepon'];
            $admin->save();

            return redirect()->route('admin.index')->with('warning', 'Admin updated locally but not found in authentication system.');

        } catch (FirebaseException $e) {
            Log::error('Firebase update user error: ' . $e->getMessage());
            
            $errorMessage = 'Gagal mengupdate admin. Terjadi kesalahan pada sistem authentication.';
            
            if (strpos($e->getMessage(), 'EMAIL_EXISTS') !== false) {
                $errorMessage = 'Email sudah terdaftar di sistem authentication.';
            }

            return back()->withErrors(['email' => $errorMessage])->withInput();
        } catch (\Exception $e) {
            Log::error('Update admin error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        
        try {
            $firebaseUser = $this->firebaseAuth->getUserByEmail($admin->email);
            $this->firebaseAuth->deleteUser($firebaseUser->uid);
            
        } catch (UserNotFound $e) {
            Log::warning('Firebase user not found for deletion, email: ' . $admin->email);
        } catch (FirebaseException $e) {
            Log::error('Firebase delete user error: ' . $e->getMessage());
        }
        
        $admin->delete();
        
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully');
    }

    private function getFirebaseUserByEmail($email)
    {
        try {
            return $this->firebaseAuth->getUserByEmail($email);
        } catch (UserNotFound $e) {
            return null;
        }
    }
}
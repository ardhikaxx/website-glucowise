<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlucoCare;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class GlucoCareController extends Controller
{
    public function addCare(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|exists:pengguna,nik',
            'tanggal' => 'required|date',
            'nama_obat' => 'required|string',
            'dosis' => 'required|string|max:50',
            'jam_minum' => 'required|date_format:H:i:s', // Format HH:MM:SS
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $care = GlucoCare::create([
            'nik' => $request->nik,
            'tanggal' => $request->tanggal,
            'nama_obat' => $request->nama_obat,
            'dosis' => $request->dosis,
            'jam_minum' => $request->jam_minum,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alarm berhasil ditambahkan.',
            'data' => $care
        ], 201);
    }

    // Edit alarm pengingat
    public function editCare(Request $request, $id_care)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|exists:pengguna,nik',
            'tanggal' => 'required|date',
            'nama_obat' => 'required|string',
            'dosis' => 'required|string|max:50',
            'jam_minum' => 'required|date_format:H:i:s', // Format HH:MM:SS
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $care = GlucoCare::find($id_care);
        if (!$care) {
            return response()->json(['status' => false, 'message' => 'Alarm tidak ditemukan.'], 404);
        }

        $care->update([
            'tanggal' => $request->tanggal,
            'nama_obat' => $request->nama_obat,
            'dosis' => $request->dosis,
            'jam_minum' => $request->jam_minum,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alarm berhasil diupdate.',
            'data' => $care
        ]);
    }

    public function getActiveCare($nik)
    {
        $nowDate = Carbon::now()->toDateString(); // Format: YYYY-MM-DD
        $nowTime = Carbon::now()->format('H:i:s'); // Format: HH:MM:SS

        $active = GlucoCare::where('nik', $nik)
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('tanggal', '>', $nowDate) // Tanggal lebih besar dari sekarang
                    ->orWhere(function ($q) use ($nowDate, $nowTime) {
                        $q->where('tanggal', $nowDate) // Tanggal sama dengan sekarang
                            ->where('jam_minum', '>', $nowTime); // Jam lebih besar dari sekarang
                    });
            })
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_minum', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $active
        ]);
    }

    public function getHistoryCare($nik)
    {
        $nowDate = Carbon::now()->toDateString(); // Format: YYYY-MM-DD
        $nowTime = Carbon::now()->format('H:i:s'); // Format: HH:MM:SS

        $history = GlucoCare::where('nik', $nik)
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('tanggal', '<', $nowDate) // Tanggal lebih kecil dari sekarang
                    ->orWhere(function ($q) use ($nowDate, $nowTime) {
                        $q->where('tanggal', $nowDate) // Tanggal sama dengan sekarang
                            ->where('jam_minum', '<=', $nowTime); // Jam kurang dari atau sama dengan sekarang
                    });
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_minum', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $history
        ]);
    }

    // Hapus alarm pengingat
    public function deleteCare($id_care)
    {
        $care = GlucoCare::find($id_care);
        if (!$care) {
            return response()->json(['status' => false, 'message' => 'Alarm tidak ditemukan.'], 404);
        }

        $care->delete();

        return response()->json([
            'status' => true,
            'message' => 'Alarm berhasil dihapus.'
        ]);
    }
}
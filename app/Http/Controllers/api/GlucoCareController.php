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
            'jam_minum' => 'required|date_format:H:i',
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
            'tanggal' => 'required|date',
            'nama_obat' => 'required|string',
            'dosis' => 'required|string|max:50',
            'jam_minum' => 'required|date_format:H:i',
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

    // Ambil semua alarm yang masih aktif
    public function getActiveCare($nik)
    {
        $nowDate = Carbon::now()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        $active = GlucoCare::where('nik', $nik)
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('tanggal', '>', $nowDate)
                    ->orWhere(function ($q) use ($nowDate, $nowTime) {
                        $q->where('tanggal', $nowDate)
                            ->where('jam_minum', '>', $nowTime);
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

    // Ambil semua alarm yang sudah lewat (riwayat)
    public function getHistoryCare($nik)
    {
        $nowDate = Carbon::now()->toDateString();
        $nowTime = Carbon::now()->format('H:i:s');

        $history = GlucoCare::where('nik', $nik)
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('tanggal', '<', $nowDate)
                    ->orWhere(function ($q) use ($nowDate, $nowTime) {
                        $q->where('tanggal', $nowDate)
                            ->where('jam_minum', '<=', $nowTime);
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
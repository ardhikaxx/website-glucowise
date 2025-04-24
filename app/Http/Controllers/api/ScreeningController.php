<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanScreening;
use App\Models\JawabanScreening;
use App\Models\TesScreening;
use App\Models\HasilScreening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScreeningController extends Controller
{
    // 1. Mengambil semua pertanyaan dan jawaban
    public function getQuestionsWithAnswers()
    {
        $questions = PertanyaanScreening::with('jawabanScreening')->get();
        
        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    // 2. Menyimpan hasil screening
    public function storeScreeningResults(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|exists:pengguna,nik',
            'answers' => 'required|array',
            'answers.*.id_pertanyaan' => 'required|exists:pertanyaan_screening,id_pertanyaan',
            'answers.*.id_jawaban' => 'required|exists:jawaban_screening,id_jawaban',
            'skor_risiko' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat record screening
        $screening = TesScreening::create([
            'nik' => $request->nik,
            'tanggal_screening' => now(),
            'skor_risiko' => $request->skor_risiko
        ]);

        // Simpan jawaban
        foreach ($request->answers as $answer) {
            HasilScreening::create([
                'id_screening' => $screening->id_screening,
                'id_pertanyaan' => $answer['id_pertanyaan'],
                'id_jawaban' => $answer['id_jawaban']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Screening results saved successfully',
            'screening_id' => $screening->id_screening
        ]);
    }

    // 3. Mendapatkan hasil screening berdasarkan ID
    public function getScreeningResult($id)
    {
        $screening = TesScreening::with(['hasilScreening.pertanyaanScreening', 'hasilScreening.jawabanScreening'])
            ->find($id);

        if (!$screening) {
            return response()->json([
                'success' => false,
                'message' => 'Screening result not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $screening
        ]);
    }

    // 4. Mendapatkan riwayat screening berdasarkan NIK
    public function getScreeningHistory($nik)
    {
        $history = TesScreening::where('nik', $nik)
            ->orderBy('tanggal_screening', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}
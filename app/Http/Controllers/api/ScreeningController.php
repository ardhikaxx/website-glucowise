<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanScreening;
use App\Models\JawabanScreening;
use App\Models\TesScreening;
use App\Models\HasilScreening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            'answers' => 'required|array|min:1',
            'answers.*.id_pertanyaan' => 'required|exists:pertanyaan_screening,id_pertanyaan',
            'answers.*.id_jawaban' => 'required|exists:jawaban_screening,id_jawaban',
            'skor_risiko' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Gunakan transaction untuk memastikan data konsisten
        DB::beginTransaction();

        try {
            // Buat record screening
            $screening = TesScreening::create([
                'nik' => $request->nik,
                'tanggal_screening' => now(),
                'skor_risiko' => $request->skor_risiko
            ]);

            // Persiapkan data untuk insert banyak sekaligus
            $hasilScreeningData = [];
            foreach ($request->answers as $answer) {
                // Validasi relasi pertanyaan-jawaban
                $jawabanValid = JawabanScreening::where('id_jawaban', $answer['id_jawaban'])
                    ->where('id_pertanyaan', $answer['id_pertanyaan'])
                    ->exists();

                if (!$jawabanValid) {
                    throw new \Exception("Jawaban tidak valid untuk pertanyaan yang dipilih");
                }

                $hasilScreeningData[] = [
                    'id_screening' => $screening->id_screening,
                    'id_pertanyaan' => $answer['id_pertanyaan'],
                    'id_jawaban' => $answer['id_jawaban'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Insert semua jawaban sekaligus
            HasilScreening::insert($hasilScreeningData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hasil screening berhasil disimpan',
                'screening_id' => $screening->id_screening,
                'skor_risiko' => $screening->skor_risiko,
                'tanggal_screening' => $screening->tanggal_screening
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan hasil screening',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 3. Mendapatkan hasil screening berdasarkan ID
    public function getScreeningResult($id)
    {
        $screening = TesScreening::with([
                'hasilScreening.pertanyaanScreening', 
                'hasilScreening.jawabanScreening',
                'pengguna'
            ])
            ->find($id);

        if (!$screening) {
            return response()->json([
                'success' => false,
                'message' => 'Hasil screening tidak ditemukan'
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
            ->get(['id_screening', 'tanggal_screening', 'skor_risiko']);

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}
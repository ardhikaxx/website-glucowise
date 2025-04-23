<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanScreening;
use App\Models\JawabanScreening;
use App\Models\TesScreening;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function index(Request $request)
    {
        // Fetch PertanyaanScreening with JawabanScreening and HasilScreening
        $dataScreening = PertanyaanScreening::with(['jawabanScreening', 'hasilScreening'])
            ->paginate(10); // For pagination of the first table
    
        // Fetch TesScreening data
        $tesScreeningData = TesScreening::with('pengguna') // Assuming you want to show related 'Pengguna'
            ->paginate(10); // For pagination of the second table
    
        // Return the view with both datasets
        return view('layouts.data-screening.data', compact('dataScreening', 'tesScreeningData'));
    }
    

    
    public function create()
{
    // Mengambil ID terakhir yang di-generate oleh database dan menambah 1 untuk ID berikutnya
    $id_pertanyaan = PertanyaanScreening::max('id_pertanyaan') + 1;

    return view('layouts.data-screening.tambahpertanyaan', compact('id_pertanyaan'));
}
public function show($id)
{
    // Fetch the TesScreening data, including related PertanyaanScreening and JawabanScreening through HasilScreening
    $tesScreening = TesScreening::with(['hasilScreening.pertanyaanScreening', 'hasilScreening.jawabanScreening'])
        ->where('id_screening', $id) // Assuming you want to filter by 'nik'
        ->firstOrFail();

    // Prepare answers and scores (split them into separate columns)
    $totalSkor = 0;
    foreach ($tesScreening->hasilScreening as $hasil) {
        // Split Jawaban and Skor (number inside parentheses)
        if (preg_match('/(.*)\((\d+)\)/', $hasil->jawabanScreening->jawaban, $matches)) {
            $hasil->jawaban = $matches[1]; // Answer without the score
            $hasil->skor = (int)$matches[2]; // The score as a separate column
            $totalSkor += $hasil->skor; // Accumulate the score
        } else {
            $hasil->jawaban = $hasil->jawabanScreening->jawaban; // If no score exists, just return the answer
            $hasil->skor = null;  // No score available
        }
    }

    // Pass the total score to the view
    return view('layouts.data-screening.detailscreening', compact('tesScreening', 'totalSkor'));
}
public function updateSkorRisiko($id)
{
    // Fetch TesScreening data, including related PertanyaanScreening and JawabanScreening through HasilScreening
    $tesScreening = TesScreening::with(['hasilScreening.pertanyaanScreening', 'hasilScreening.jawabanScreening'])
        ->where('id_screening', $id)
        ->firstOrFail();

    // Calculate total score
    $totalSkor = 0;
    foreach ($tesScreening->hasilScreening as $hasil) {
        // Split Jawaban and Skor (number inside parentheses)
        if (preg_match('/(.*)\((\d+)\)/', $hasil->jawabanScreening->jawaban, $matches)) {
            $hasil->jawaban = $matches[1]; // Answer without the score
            $hasil->skor = (int)$matches[2]; // The score as a separate column
            $totalSkor += $hasil->skor; // Accumulate the score
        } else {
            $hasil->jawaban = $hasil->jawabanScreening->jawaban; // If no score exists, just return the answer
            $hasil->skor = null;  // No score available
        }
    }

    // Update the Skor Risiko and save to the database
    $tesScreening->skor_risiko = $totalSkor;
    $tesScreening->save();

    // Redirect back to the index page (or any other page as needed)
    return redirect()->route('screening.index');
}






public function store(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'required|array|min:1',
        'jawaban.*' => 'required|string|max:255',
        'skoring' => 'required|array|min:1',
        'skoring.*' => 'required|integer',
    ]);

    // Menyimpan data pertanyaan dan mengambil id_pertanyaan yang baru saja disimpan
    $pertanyaan = PertanyaanScreening::create([
        'pertanyaan' => $request->pertanyaan,
    ]);

    // Menyimpan jawaban yang terkait dengan pertanyaan yang baru saja disimpan
    foreach ($request->jawaban as $index => $jawaban) {
        // Gabungkan jawaban dengan skoring dalam format Jawaban(Skoring)
        $jawabanDenganSkoring = $jawaban . '(' . $request->skoring[$index] . ')';

        // Menyimpan jawaban ke dalam database dengan id_pertanyaan yang valid
        JawabanScreening::create([
            'id_pertanyaan' => $pertanyaan->id_pertanyaan, // Menyimpan id_pertanyaan yang baru saja disimpan
            'jawaban' => $jawabanDenganSkoring, // Menyimpan jawaban dalam format "Jawaban(Skoring)"
        ]);
    }

    // Redirect ke halaman screening index dengan pesan sukses
    return redirect()->route('screening.index')->with('success', 'Data screening berhasil disimpan.');
}



public function edit($id)
{
    $pertanyaan = PertanyaanScreening::with('jawabanScreening')->findOrFail($id);
    return view('layouts.data-screening.tambahpertanyaan', compact('pertanyaan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'required|array|min:1',
        'jawaban.*' => 'required|string|max:255',
        'skoring' => 'required|array|min:1',
        'skoring.*' => 'required|integer',
    ]);

    $pertanyaan = PertanyaanScreening::findOrFail($id);
    $pertanyaan->update([
        'pertanyaan' => $request->pertanyaan,
    ]);

    // Hapus jawaban lama dan simpan jawaban baru
    $pertanyaan->jawabanScreening()->delete();

    foreach ($request->jawaban as $index => $jawaban) {
        $jawabanDenganSkoring = $jawaban . '(' . $request->skoring[$index] . ')';

        JawabanScreening::create([
            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
            'jawaban' => $jawabanDenganSkoring,
        ]);
    }

    return redirect()->route('screening.index')->with('success', 'Data screening berhasil diupdate.');
}

public function destroy($id)
{
    // Cari pertanyaan berdasarkan ID
    $pertanyaan = PertanyaanScreening::findOrFail($id);

    // Hapus jawaban terkait dengan pertanyaan
    $pertanyaan->jawabanScreening()->delete();

    // Hapus pertanyaan itu sendiri
    $pertanyaan->delete();

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('screening.index')->with('success', 'Data screening berhasil dihapus.');
}
}
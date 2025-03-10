<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanScreening;
use App\Models\JawabanScreening;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function index(Request $request)
    {
        $dataScreening = PertanyaanScreening::with(['jawabanScreening', 'hasilScreening'])
            ->paginate(10); // Ambil data dengan pagination

        return view('layouts.data-screening.data', compact('dataScreening'));
    }

    
    public function create()
{
    // Mengambil ID terakhir yang di-generate oleh database dan menambah 1 untuk ID berikutnya
    $id_pertanyaan = PertanyaanScreening::max('id_pertanyaan') + 1;

    return view('layouts.data-screening.tambahpertanyaan', compact('id_pertanyaan'));
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
        'id_pertanyaan' => 'required|integer', // Validasi id_pertanyaan
    ]);

    // Menyimpan data pertanyaan
    $pertanyaan = PertanyaanScreening::create([
        'pertanyaan' => $request->pertanyaan,
    ]);

    // Menyimpan jawaban yang terkait dengan pertanyaan yang baru saja disimpan
    foreach ($request->jawaban as $index => $jawaban) {
        // Gabungkan jawaban dengan skoring dalam format Jawaban(Skoring)
        $jawabanDenganSkoring = $jawaban . '(' . $request->skoring[$index] . ')';

        // Menyimpan jawaban ke dalam database dengan id_pertanyaan
        JawabanScreening::create([
            'id_pertanyaan' => $request->id_pertanyaan, // Menyimpan id_pertanyaan yang dikirimkan
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
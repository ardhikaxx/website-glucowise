<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanScreening;
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
        return view('screening.create');
    }

    public function store(Request $request)
    {
        PertanyaanScreening::create($request->all());
        return redirect()->route('screening.index')->with('success', 'Data screening berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = PertanyaanScreening::findOrFail($id);
        return view('screening.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = PertanyaanScreening::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('screening.index')->with('success', 'Data screening berhasil diperbarui');
    }

    public function destroy($id)
    {
        PertanyaanScreening::findOrFail($id)->delete();
        return redirect()->route('screening.index')->with('success', 'Data screening berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TitikAntar;
use Illuminate\Http\Request;

class TitikAntarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->nama == 'admin') {
            $data = [
                'titikantars' => TitikAntar::all(),
            ];
            return view('dashboard.admin.titikantar.titikantar', $data);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role->nama == 'admin') {
            $data = $this->validate($request, [
                'kota' => 'required',
                'kode_pos' => 'required',
                'alamat_lengkap' => 'required',
                'kontak_nama' => 'required',
                'kontak_nomor' => 'required'
            ]);

            TitikAntar::create($data);

            return redirect()->back()->with(['successTitikAntar' => 'Berhasil menambah Titik Antar (Check Point)']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role->nama == 'admin') {
            $data = $this->validate($request, [
                'kota' => 'required',
                'kode_pos' => 'required',
                'alamat_lengkap' => 'required',
                'kontak_nama' => 'required',
                'kontak_nomor' => 'required'
            ]);

            TitikAntar::where('id', $id)->update($data);

            return redirect()->route('titikantar.index')->with(['success' => 'Berhasil merubah Titik Antar (Check Point)']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role->nama == 'admin') {
            $titikantar = TitikAntar::where('id', $id)->firstOrFail();
            foreach ($titikantar->barang as $barang) {
                $barang->delete();
            }
            $titikantar->delete();
            return redirect()->route('titikantar.index')->with(['success' => 'Berhasil menghapus Titik Antar (Check Point)']);
        }
        return redirect()->route('dashboard');
    }
}

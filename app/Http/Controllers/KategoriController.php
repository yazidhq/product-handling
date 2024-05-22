<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $data = [
                'kategoris' => Kategori::all(),
            ];
            return view('dashboard.karyawan.kategori.kategori', $data);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $data = $this->validate($request, [
                'nama_kategori' => 'required',
                'deskripsi' => 'required'
            ]);

            Kategori::create($data);
            $request->flash();

            return redirect()->back()->with(['successKategori' => 'Berhasil menambah katagori Barang']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $data = $this->validate($request, [
                'nama_kategori' => 'required',
                'deskripsi' => 'required'
            ]);

            Kategori::where('id', $id)->update($data);

            return redirect()->route('kategori.index')->with(['success' => 'Berhasil mengubah katagori Barang']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $kategori = Kategori::where('id', $id)->firstOrFail();
            foreach ($kategori->barang as $barang) {
                $barang->delete();
            }
            $kategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Berhasil menghapus katagori Barang']);
        }
        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->nama == 'admin') {
            $data = [
                'armadas' => Armada::all(),
            ];
            return view('dashboard.admin.armada.armada', $data);
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
                'nama_kendaraan' => 'required',
                'plat_nomor' => 'required',
                'container_nomor' => 'required'
            ]);
            Armada::create($data);
            return redirect()->back()->with(['successArmada' => 'Berhasil menambah Armada Kendaraan']);
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
                'nama_kendaraan' => 'required',
                'plat_nomor' => 'required',
                'container_nomor' => 'required'
            ]);
            Armada::where('id', $id)->update($data);
            return redirect()->route('armada.index')->with(['success' => 'Berhasil merubah Armada Kendaraan']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role->nama == 'admin') {
            $armada = Armada::where('id', $id)->firstOrFail();
            foreach ($armada->barang as $barang) {
                $barang->delete();
            }
            $armada->delete();
            return redirect()->route('armada.index')->with(['success' => 'Berhasil menghapus Armada Kendaraan']);
        }
        return redirect()->route('dashboard');
    }
}

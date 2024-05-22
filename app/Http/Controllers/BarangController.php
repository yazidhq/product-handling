<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\LogBarang;
use App\Models\TitikAntar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'barangs' => Barang::all(),
            'kategoris' => Kategori::all(),
            'armadas' => Armada::all(),
            'titikantars' => TitikAntar::all(),
            'logbarang' => LogBarang::orderBy('id', 'DESC')->get()
        ];
        return view('dashboard.karyawan.barang.barang', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $data = [
                'kategoris' => Kategori::all(),
                'armadas' => Armada::all(),
                'titikantars' => TitikAntar::all(),
            ];
            return view('dashboard.karyawan.barang.tambah', $data);
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
                'nomor_resi' => 'required',
                'nama_unit' => 'required',
                'nama_barang' => 'required',
                'deskripsi' => 'required',
                'kategori_id' => 'required',
                'tanggal_pengiriman' => 'required',
                'armada_id' => 'required',
                'nama_pengirim' => 'required',
                'nama_penerima' => 'required',
                'nomor_penerima' => 'required',
                'kota_penerima' => 'required',
                'lokasi_penerima' => 'required',
                'status_pengiriman' => 'required',
            ]);

            $barang = Barang::create($data);
            $status_perjalanan = $request->status_pengiriman;
            $datetime = \Carbon\Carbon::now()->format('Y-m-d\TH:i');

            $barang->log_barang()->create([
                'status_pengiriman' => $status_perjalanan,
                'datetime' => $datetime,
            ]);

            return redirect()->route('barang.index')->with(['success' => 'Berhasil memasukkan Barang']);
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
                'nomor_resi' => 'required',
                'nama_unit' => 'required',
                'nama_barang' => 'required',
                'deskripsi' => 'required',
                'kategori_id' => 'required',
                'tanggal_pengiriman' => 'required',
                'armada_id' => 'required',
                'nama_pengirim' => 'required',
                'nama_penerima' => 'required',
                'nomor_penerima' => 'required',
                'kota_penerima' => 'required',
                'lokasi_penerima' => 'required',
                'titikantar_id' => 'required',
                'status_pengiriman' => 'required',
            ]);

            $barang = Barang::findOrFail($id);
            $barang->update($data);
            $status_perjalanan = $request->status_pengiriman;

            $lastLog = $barang->log_barang()->where('status_pengiriman', $status_perjalanan)->latest()->first();
            if (!$lastLog) {
                $barang->log_barang()->create([
                    'status_pengiriman' => $status_perjalanan
                ]);
            }

            return redirect()->route('barang.index')->with(['success' => 'Berhasil merubah data Barang']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $barang = Barang::where('id', $id)->firstOrFail();
            $barang->delete();
            LogBarang::where('barang_id', $id)->delete();
            return redirect()->route('barang.index')->with(['success' => 'Berhasil menghapus Barang']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Update status_pengiriman barang
     */
    public function updateStatusPengiriman(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $status = $request->input('status');
        $datetime = $request->input('datetime');

        if ($status == "manual_ubah_status") {
            $manual = $request->input('status_pengiriman');
            $barang->status_pengiriman = $manual;
            $status_perjalanan = $request->status_pengiriman;
            $barang->log_barang()->create([
                'status_pengiriman' => $status_perjalanan,
                'datetime' => $datetime
            ]);
        } elseif ($status == "di_titik_antar") {
            $titikantarId = $request->input('titikantar_id');
            $titikantar = TitikAntar::findOrFail($titikantarId);
            $barang->titikantar_id = $titikantarId;
            $kota = $titikantar->kota;
            $barang->status_pengiriman = "Di " . Str::ucfirst($kota);
            $status_perjalanan = "Di " . Str::ucfirst($kota);
            $barang->log_barang()->create([
                'status_pengiriman' => $status_perjalanan,
                'datetime' => $datetime
            ]);
        } else {
            $barang->status_pengiriman = $status;
            $status_perjalanan = $request->input('status');
            $barang->log_barang()->create([
                'status_pengiriman' => $status_perjalanan,
                'datetime' => $datetime
            ]);
        }
        
        $barang->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui');
    }

    /**
     * Creating pdf surat jalan barang
     */
    public function generateSuratJalan($id)
    {
        if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin') {
            $barang = Barang::findOrFail($id);

            $pdf = App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
            $pdf->getDomPDF()->set_option("isPhpEnabled", true);
            $pdf->loadView('surat-jalan', compact('barang'));
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('surat-jalan-' . $barang->id . '.pdf');
        }
        return redirect()->route('dashboard');
    }

    /**
     * delete single log barang
     */
    public function hapusSingleLog($id)
    {
        LogBarang::where('id', $id)->delete();
        return redirect()->route('barang.index')->with('success', 'Berhasil menghapus log perubahan');
    }

    /**
     * delete all of log barang
     */
    public function hapusAllLog($id)
    {
        LogBarang::where('barang_id', $id)->delete();
        return redirect()->route('barang.index')->with('success', 'Berhasil menghapus seluruh log perubahan');
    }

    /**
     * update datetime data single log
     */
    public function updateDatetimeLog(Request $request, $id)
    {
        $data = $this->validate($request, [
            'datetime' => 'required'
        ]);
        $log = LogBarang::findOrFail($id);
        $log->update($data);
        return redirect()->route('barang.index')->with('success', 'Berhasil mengubah waktu log barang');
    }
}

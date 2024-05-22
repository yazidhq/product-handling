@extends('dashboard.layout.templates')

@section('konten')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang</h1>
        <a href="{{ route('barang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i>
            Tambah Barang
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Input data pada form berikut</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nomor_resi" class="form-label">Nomor Resi</label>
                                    <input type="text" class="form-control @error('nomor_resi') is-invalid @enderror"
                                        id="nomor_resi" name="nomor_resi" value="{{ old('nomor_resi') }}">
                                    @error('nomor_resi')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_unit" class="form-label">Nama Unit</label>
                                    <input type="text" class="form-control @error('nama_unit') is-invalid @enderror"
                                        id="nama_unit" name="nama_unit" value="{{ old('nama_unit') }}">
                                    @error('nama_unit')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                        id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}">
                                    @error('nama_barang')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                                    <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}">
                                    @error('deskripsi')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-sm btn-link mb-1" data-toggle="modal"
                                        data-target="#tambahJenisBarang">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                    <label for="kategori_id" class="form-label">Jenis/ Kategori Barang</label>
                                    @if(session('successKategori'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('successKategori') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <select name="kategori_id"
                                        class="form-control @error('kategori_id') is-invalid @enderror">
                                        <option value="">Pilih Jenis Barang</option>
                                        @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id')==$kategori->id ?
                                            'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pengiriman') is-invalid @enderror"
                                        id="tanggal_pengiriman" name="tanggal_pengiriman"
                                        value="{{ old('tanggal_pengiriman') }}">
                                    @error('tanggal_pengiriman')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-sm btn-link mb-1" data-toggle="modal"
                                        data-target="#tambahArmada">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                    <label for="armada_id" class="form-label">Armada Pengiriman</label>
                                    @if(session('successArmada'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('successArmada') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <select name="armada_id"
                                        class="form-control @error('armada_id') is-invalid @enderror">
                                        <option value="">Pilih Armada</option>
                                        @foreach ($armadas as $armada)
                                        <option value="{{ $armada->id }}" {{ old('armada_id')==$armada->id ? 'selected'
                                            : '' }}>
                                            {{ $armada->nama_kendaraan }}: {{ $armada->plat_nomor }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('armada_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                                    <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror"
                                        id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}">
                                    @error('nama_pengirim')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror"
                                        id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima') }}">
                                    @error('nama_penerima')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_penerima" class="form-label">Nomor Penerima</label>
                                    <input type="text"
                                        class="form-control @error('nomor_penerima') is-invalid @enderror"
                                        id="nomor_penerima" name="nomor_penerima" value="{{ old('nomor_penerima') }}">
                                    @error('nomor_penerima')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="kota_penerima" class="form-label">Kota Penerima</label>
                                    <input type="text" class="form-control @error('kota_penerima') is-invalid @enderror"
                                        id="kota_penerima" name="kota_penerima" value="{{ old('kota_penerima') }}">
                                    @error('kota_penerima')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="lokasi_penerima" class="form-label">Lokasi Lengkap Penerima</label>
                                    <input type="text"
                                        class="form-control @error('lokasi_penerima') is-invalid @enderror"
                                        id="lokasi_penerima" name="lokasi_penerima"
                                        value="{{ old('lokasi_penerima') }}">
                                    @error('lokasi_penerima')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status_pengiriman" class="form-label">Status Pengiriman</label>
                                    <input type="text"
                                        class="form-control @error('status_pengiriman') is-invalid @enderror"
                                        id="status_pengiriman" name="status_pengiriman"
                                        value="Barang baru masuk">
                                    @error('status_pengiriman')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="tambahJenisBarang" tabindex="-1" role="dialog"
                        aria-labelledby="lihatModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lihatModalLabel"><strong>Tambah Jenis
                                            Barang</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('kategori.store') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Nama Kategori"
                                                name="nama_kategori" required>
                                            <input type="text" class="form-control" placeholder="Deskripsi"
                                                name="deskripsi" required>
                                            <button type="submit"
                                                class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                                                <i class="fas fa-download fa-sm text-white-50"></i>
                                                Tambah Kategori
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="tambahArmada" tabindex="-1" role="dialog"
                        aria-labelledby="lihatModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lihatModalLabel"><strong>Tambah Armada</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('armada.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" class="form-control mb-3" placeholder="Jenis Kendaraan"
                                                name="nama_kendaraan">
                                            <input type="text" class="form-control mb-3" placeholder="Nomor Polisi"
                                                name="plat_nomor">
                                            <input type="text" class="form-control mb-3" placeholder="Nomor Container"
                                                name="container_nomor">
                                            <button type="submit"
                                                class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                                                <i class="fas fa-download fa-sm text-white-50"></i>
                                                Tambah Armada
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="tambahTitikAntar" tabindex="-1" role="dialog"
                        aria-labelledby="lihatModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lihatModalLabel"><strong>Tambah Titik Antar</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('titikantar.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kota">Kota</label>
                                                    <input type="text" class="form-control" id="kota" name="kota">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kode_pos">Kode Pos</label>
                                                    <input type="number" class="form-control" id="kode_pos"
                                                        name="kode_pos">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat_lengkap">Alamat Lengkap</label>
                                            <input type="text" class="form-control" id="alamat_lengkap"
                                                name="alamat_lengkap">
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kontak_nama">Nama Kontak</label>
                                                    <input type="text" class="form-control" id="kontak_nama"
                                                        name="kontak_nama">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kontak_nomor">Nomor Kontak</label>
                                                    <input type="number" class="form-control" id="kontak_nomor"
                                                        name="kontak_nomor">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
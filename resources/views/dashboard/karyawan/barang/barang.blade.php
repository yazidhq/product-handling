@extends('dashboard.layout.templates')

@section('konten')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
            @if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin')
                <div class="align-items-end">
                    <a href="{{ route('barang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-pencil-alt fa-sm text-white-50"></i>
                        Tambah Barang
                    </a>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Terdapat field edit kosong..
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Barang Masuk</h6>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nomor Resi</th>
                                    <th>Barang</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Posisi Barang</th>
                                    <th>Ubah Status Perjalanan</th>
                                    @if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->nomor_resi }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->tanggal_pengiriman->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $barang->status_pengiriman }}
                                        </td>
                                        <td>
                                            <form action="{{ route('update-status-pengiriman', ['id' => $barang->id]) }}"
                                                method="POST" id="combinedForm_{{ $barang->id }}">
                                                @csrf
                                                @method('PUT')

                                                <select name="status" class="form-control"
                                                    onchange="updateForm('{{ $barang->id }}')">
                                                    <option value="" hidden>Pilih Opsi</option>
                                                    <option value="manual_ubah_status">Manual Ubah Status</option>
                                                    <option value="di_titik_antar">Pilih Titik Antar</option>
                                                    <option value="Sedang dalam perjalanan">Dalam Perjalanan</option>
                                                    <option value="Unit telah sampai">Telah Sampai</option>
                                                </select>

                                                <input type="datetime-local" class="form-control mt-1" name="datetime"
                                                    required>

                                                <div id="combinedForm_{{ $barang->id }}_manualUbahStatusOptions"
                                                    class="mt-3" style="display: none;">
                                                    <label for="status_pengiriman" class="form-label">Manual Status</label>
                                                    <input type="text" name="status_pengiriman" class="form-control">
                                                </div>

                                                <div id="combinedForm_{{ $barang->id }}_titikAntarOptions" class="mt-3"
                                                    style="display: none;">
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-sm btn-link mb-1"
                                                            data-toggle="modal"
                                                            data-target="#tambahTitikAntar_{{ $barang->id }}">
                                                            <i class="bi bi-plus-circle-fill"></i>
                                                        </button>
                                                        <label for="kategori_id" class="form-label">Pilih kota</label>
                                                    </div>
                                                    <select name="titikantar_id" class="form-control">
                                                        <option hidden value="">Pilih Kota</option>
                                                        @foreach ($titikantars as $titikantar)
                                                            <option value="{{ $titikantar->id }}">{{ $titikantar->kota }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
                                            </form>
                                            <script>
                                                function updateForm(formId) {
                                                    var selectedOption = document.getElementById('combinedForm_' + formId).elements["status"].value;

                                                    // Hide all options initially
                                                    document.getElementById('combinedForm_' + formId + '_manualUbahStatusOptions').style.display = "none";
                                                    document.getElementById('combinedForm_' + formId + '_titikAntarOptions').style.display = "none";

                                                    // Show the relevant option based on the selected value
                                                    if (selectedOption === "manual_ubah_status") {
                                                        document.getElementById('combinedForm_' + formId + '_manualUbahStatusOptions').style.display = "block";
                                                    } else if (selectedOption === "di_titik_antar") {
                                                        document.getElementById('combinedForm_' + formId + '_titikAntarOptions').style.display = "block";
                                                    }
                                                }
                                            </script>
                                            <!-- Modal -->
                                            <div class="modal fade" id="tambahTitikAntar" tabindex="-1" role="dialog"
                                                aria-labelledby="lihatModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="lihatModalLabel"><strong>Tambah
                                                                    Titik
                                                                    Antar</strong>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                                            <input type="text" class="form-control"
                                                                                id="kota" name="kota">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="kode_pos">Kode Pos</label>
                                                                            <input type="number" class="form-control"
                                                                                id="kode_pos" name="kode_pos">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat_lengkap">Alamat Lengkap</label>
                                                                    <input type="text" class="form-control"
                                                                        id="alamat_lengkap" name="alamat_lengkap">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="kontak_nama">Nama Kontak</label>
                                                                            <input type="text" class="form-control"
                                                                                id="kontak_nama" name="kontak_nama">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="kontak_nomor">Nomor Kontak</label>
                                                                            <input type="number" class="form-control"
                                                                                id="kontak_nomor" name="kontak_nomor">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if (auth()->user()->role->nama == 'pegawai' || auth()->user()->role->nama == 'admin')
                                            <td>
                                                <div class="input-group mb-3">
                                                    <form action="{{ route('barang.destroy', $barang->id) }}"
                                                        method="POST" class="deleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger rounded-2 mx-1 my-1">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-sm btn-warning mx-1 my-1 rounded-2"
                                                        data-toggle="modal" data-target="#editModal{{ $barang->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal{{ $barang->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Edit
                                                                        Barang
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('barang.update', $barang->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="titikantar_id"
                                                                            value="{{ $barang->titikantar_id }}">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label for="nomor_resi"
                                                                                        class="form-label">Nomor
                                                                                        Resi</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('nomor_resi') is-invalid @enderror"
                                                                                        id="nomor_resi" name="nomor_resi"
                                                                                        value="{{ $barang->nomor_resi }}">
                                                                                    @error('nomor_resi')
                                                                                        <p class="text-danger">
                                                                                            {{ $message }}</p>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nama_unit"
                                                                                        class="form-label">Nama
                                                                                        Unit</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama_unit" name="nama_unit"
                                                                                        value="{{ $barang->nama_unit }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nama_barang"
                                                                                        class="form-label">Nama
                                                                                        Barang</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama_barang"
                                                                                        name="nama_barang"
                                                                                        value="{{ $barang->nama_barang }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="deskripsi"
                                                                                        class="form-label">Deskripsi
                                                                                        Barang</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="deskripsi" name="deskripsi"
                                                                                        value="{{ $barang->deskripsi }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="kategori_id"
                                                                                        class="form-label">Jenis/ Kategori
                                                                                        Barang</label>
                                                                                    <select name="kategori_id"
                                                                                        class="form-control">
                                                                                        <option hidden
                                                                                            value="{{ $barang->kategori_id }}">
                                                                                            {{ $barang->kategori->nama_kategori }}
                                                                                        </option>
                                                                                        @foreach ($kategoris as $kategori)
                                                                                            <option
                                                                                                value="{{ $kategori->id }}"
                                                                                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                                                                {{ $kategori->nama_kategori }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="tanggal_pengiriman"
                                                                                        class="form-label">Tanggal
                                                                                        Pengiriman</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        id="tanggal_pengiriman"
                                                                                        name="tanggal_pengiriman"
                                                                                        value="{{ old('tanggal_pengiriman', $barang->tanggal_pengiriman ? \Carbon\Carbon::parse($barang->tanggal_pengiriman)->toDateString() : '') }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="armada_id"
                                                                                        class="form-label">Armada
                                                                                        Pengiriman</label>
                                                                                    <select name="armada_id"
                                                                                        class="form-control">
                                                                                        <option hidden
                                                                                            value="{{ $barang->armada_id }}">
                                                                                            {{ $barang->armada->nama_kendaraan }}:
                                                                                            {{ $barang->armada->plat_nomor }}
                                                                                        </option>
                                                                                        @foreach ($armadas as $armada)
                                                                                            <option
                                                                                                value="{{ $armada->id }}"
                                                                                                {{ old('armada_id') == $armada->id ? 'selected' : '' }}>
                                                                                                {{ $armada->nama_kendaraan }}:
                                                                                                {{ $armada->plat_nomor }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label for="nama_pengirim"
                                                                                        class="form-label">Nama
                                                                                        Pengirim</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama_pengirim"
                                                                                        name="nama_pengirim"
                                                                                        value="{{ $barang->nama_pengirim }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nama_penerima"
                                                                                        class="form-label">Nama
                                                                                        Penerima</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama_penerima"
                                                                                        name="nama_penerima"
                                                                                        value="{{ $barang->nama_penerima }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nomor_penerima"
                                                                                        class="form-label">Nomor
                                                                                        Penerima</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nomor_penerima"
                                                                                        name="nomor_penerima"
                                                                                        value="{{ $barang->nomor_penerima }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="kota_penerima"
                                                                                        class="form-label">Kota
                                                                                        Penerima</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="kota_penerima"
                                                                                        name="kota_penerima"
                                                                                        value="{{ $barang->kota_penerima }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="lokasi_penerima"
                                                                                        class="form-label">Lokasi Lengkap
                                                                                        Penerima</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="lokasi_penerima"
                                                                                        name="lokasi_penerima"
                                                                                        value="{{ $barang->lokasi_penerima }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="titikantar_id"
                                                                                        class="form-label">Status
                                                                                        Pengiriman</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="status_pengiriman"
                                                                                        name="status_pengiriman"
                                                                                        value="{{ $barang->status_pengiriman }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary rounded-2 mx-1 my-1"
                                                        data-toggle="modal" data-target="#lihatModal{{ $barang->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="lihatModal{{ $barang->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="lihatModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="lihatModalLabel">Detail
                                                                        Barang</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item"><strong>Nomor Resi :
                                                                            </strong>{{ $barang->nomor_resi }}</li>
                                                                        <li class="list-group-item"><strong>Nama Unit :
                                                                            </strong>{{ $barang->nama_unit }}</li>
                                                                        <li class="list-group-item"><strong>Nama Barang :
                                                                            </strong>{{ $barang->nama_barang }}</li>
                                                                        <li class="list-group-item"><strong>Deskripsi :
                                                                            </strong>{{ $barang->deskripsi }}</li>
                                                                        <li class="list-group-item"><strong>Tanggal Kirim :
                                                                            </strong>{{ $barang->tanggal_pengiriman }}</li>
                                                                        <li class="list-group-item"><strong>Jenis Barang :
                                                                            </strong>{{ $barang->kategori->nama_kategori }}
                                                                        </li>
                                                                        <li class="list-group-item"><strong>Armada
                                                                                Pengiriman :
                                                                            </strong>{{ $barang->armada->nama_kendaraan }}
                                                                            - {{ $barang->armada->plat_nomor }} -
                                                                            {{ $barang->armada->container_nomor }}
                                                                        </li>
                                                                        <li class="list-group-item"><strong>Kota Tujuan :
                                                                            </strong>{{ $barang->kota_penerima }}</li>
                                                                        <li class="list-group-item"><strong>Alamat Tujuan:
                                                                            </strong>{{ $barang->lokasi_penerima }}</li>
                                                                        <li class="list-group-item"><strong>Nama Pengirim :
                                                                            </strong>{{ $barang->nama_pengirim }}</li>
                                                                        <li class="list-group-item"><strong>Nama Penerima :
                                                                            </strong>{{ $barang->nama_penerima }}</li>
                                                                        <li class="list-group-item"><strong>Nomor Penerima
                                                                                : </strong>{{ $barang->nomor_penerima }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('surat-jalan', ['id' => $barang->id]) }}"
                                                        class="btn btn-sm btn-success rounded-2 mx-1 my-1"
                                                        target="_blank">
                                                        <i class="bi bi-printer"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-info rounded-2 mx-1 my-1"
                                                        data-toggle="modal" data-target="#logBarang{{ $barang->id }}">
                                                        <i class="bi bi-substack"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="logBarang{{ $barang->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="lihatModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="lihatModalLabel">
                                                                        <strong>Log
                                                                            Aktifitas Barang:
                                                                            {{ Str::upper($barang->nama_barang) }}</strong>
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <style>
                                                                    .timeline {
                                                                        border-left: 1px solid hsl(0, 0%, 90%);
                                                                        position: relative;
                                                                        list-style: none;
                                                                    }

                                                                    .timeline .timeline-item {
                                                                        position: relative;
                                                                    }

                                                                    .timeline .timeline-item:after {
                                                                        position: absolute;
                                                                        display: block;
                                                                        top: 0;
                                                                    }

                                                                    .timeline .timeline-item:after {
                                                                        background-color: hsl(0, 0%, 90%);
                                                                        left: -38px;
                                                                        border-radius: 50%;
                                                                        height: 11px;
                                                                        width: 11px;
                                                                        content: "";
                                                                    }
                                                                </style>
                                                                <div class="modal-body">
                                                                    <section>
                                                                        <ul class="timeline">
                                                                            @foreach ($logbarang as $log)
                                                                                @if ($log->barang_id == $barang->id)
                                                                                    <li class="timeline-item mb-5">
                                                                                        <h6 class="fw-bold">
                                                                                            {{ $log->status_pengiriman }}

                                                                                        </h6>
                                                                                        <p class="text-muted d-inline">
                                                                                            {{ \Carbon\Carbon::parse($log->datetime)->format('d-m-Y
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    H:i') }}
                                                                                        </p>
                                                                                        <form
                                                                                            action="{{ route('singleLog.destroy', $log->id) }}"
                                                                                            method="POST"
                                                                                            class="d-inline">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit"
                                                                                                class="btn btn-sm btn-link mb-1">
                                                                                                <i class="bi bi-trash3-fill"
                                                                                                    style="color: black"></i>
                                                                                            </button>
                                                                                        </form>
                                                                                        <button type="submit"
                                                                                            class="btn btn-sm btn-link mb-1"
                                                                                            style="margin-left: -15px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#editLog{{ $log->id }}">
                                                                                            <i class="bi bi-pencil-square"
                                                                                                style="color: black"></i>
                                                                                        </button>
                                                                                        {{-- modal --}}
                                                                                        <div class="modal fade"
                                                                                            id="editLog{{ $log->id }}"
                                                                                            tabindex="-1" role="dialog"
                                                                                            aria-labelledby="lihatModalLabel"
                                                                                            aria-hidden="true">
                                                                                            <div class="modal-dialog modal-sm"
                                                                                                role="document"
                                                                                                style="margin-top: 100px;">
                                                                                                <div class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-body">
                                                                                                        <form
                                                                                                            action="{{ route('update-datetime-log', $log->id) }}"
                                                                                                            method="POST">
                                                                                                            @csrf
                                                                                                            @method('PUT')
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                <div
                                                                                                                    class="col-md-10">
                                                                                                                    <input
                                                                                                                        type="datetime-local"
                                                                                                                        class="form-control mt-1"
                                                                                                                        name="datetime"
                                                                                                                        required
                                                                                                                        value="{{ \Carbon\Carbon::parse($log->datetime)->format('Y-m-d\TH:i') }}">
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-md-2">
                                                                                                                    <button
                                                                                                                        type="submit"
                                                                                                                        class="btn btn-sm btn-success mt-2"
                                                                                                                        style="margin-left: -6px">
                                                                                                                        <i
                                                                                                                            class="bi bi-check2-square"></i>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                        <hr>
                                                                        <form
                                                                            action="{{ route('allLog.destroy', $barang->id) }}"
                                                                            method="POST" class="d-inline deleteForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-sm btn-danger">
                                                                                Hapus seluruh log
                                                                            </button>
                                                                        </form>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@extends('dashboard.layout.templates')

@section('konten')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Titik Antar (Checkpoint)</h1>
        <div class="align-item-end">
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahModal">
                <i class="fas fa-download fa-sm text-white-50"></i>
                Tambah Titik Antar
            </button>
            <!-- Modal -->
            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Titik Antar</h5>
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
                                            <input type="number" class="form-control" id="kode_pos" name="kode_pos">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_lengkap">Alamat Lengkap</label>
                                    <input type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="kontak_nama">Nama Kontak</label>
                                            <input type="text" class="form-control" id="kontak_nama" name="kontak_nama">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="kontak_nomor">Nomor Kontak</label>
                                            <input type="number" class="form-control" id="kontak_nomor" name="kontak_nomor">
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
    
    @if(session('successTitikAntar'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('successTitikAntar') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Terdapat field yang belum diisi..
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Titik Antar</h6>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kota</th>
                                <th>Kode Pos</th>
                                <th>Alamat</th>
                                <th>Nama Kontak</th>
                                <th>Nomor Kontak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titikantars as $key => $titikantar)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $titikantar->kota }}</td>
                                <td>{{ $titikantar->kode_pos }}</td>
                                <td>{{ $titikantar->alamat_lengkap }}</td>
                                <td>{{ $titikantar->kontak_nama }}</td>
                                <td>{{ $titikantar->kontak_nomor }}</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <form action="{{ route('titikantar.destroy', $titikantar->id) }}" method="POST" class="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-2">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-warning mx-1 rounded-2" data-toggle="modal" data-target="#editModal{{ $titikantar->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $titikantar->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Ubah Titik Antar</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('titikantar.update', $titikantar->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="kota">Kota</label>
                                                                        <input type="text" class="form-control" id="kota" name="kota"  value="{{ $titikantar->kota }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="kode_pos">Kode Pos</label>
                                                                        <input type="number" class="form-control" id="kode_pos" name="kode_pos" value="{{ $titikantar->kode_pos }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="alamat_lengkap">Alamat Lengkap</label>
                                                                <input type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap" value="{{ $titikantar->alamat_lengkap }}">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="kontak_nama">Nama Kontak</label>
                                                                        <input type="text" class="form-control" id="kontak_nama" name="kontak_nama" value="{{ $titikantar->kontak_nama }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="kontak_nomor">Nomor Kontak</label>
                                                                        <input type="number" class="form-control" id="kontak_nomor" name="kontak_nomor" value="{{ $titikantar->kontak_nomor }}">
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
                                </td>
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
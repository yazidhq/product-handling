@extends('dashboard.layout.templates')

@section('konten')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jenis/ Kategori Barang</h1>
        <div class="align-item-end">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nama Kategori" name="nama_kategori">
                    <input type="text" class="form-control" placeholder="Deskripsi" name="deskripsi">
                    <button type="submit" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i>
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @if(session('successKategori'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('successKategori') }}
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
                    <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoris as $key => $kategori)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->deskripsi }}</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-2">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-warning mx-1 rounded-2" data-toggle="modal" data-target="#editModal{{ $kategori->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $kategori->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="nama_kategori">Nama Kategori</label>
                                                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deskripsi">Deskripsi</label>
                                                                <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $kategori->deskripsi }}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update</button>
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
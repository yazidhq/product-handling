@extends('dashboard.layout.templates')

@section('konten')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Armada/ Kendaraan Pengiriman</h1>
        <div class="align-item-end">
            <div class="row">
                <div class="col-9 ml-auto">
                    <form action="{{ route('armada.store') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nama Armada" name="nama_kendaraan">
                            <input type="text" class="form-control" placeholder="Nomor Polisi" name="plat_nomor">
                            <input type="text" class="form-control" placeholder="Nomor Container"
                                name="container_nomor">
                            <button type="submit" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                                Tambah Armada
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('successArmada'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('successArmada') }}
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
                    <h6 class="m-0 font-weight-bold text-primary">Armada</h6>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Armada</th>
                                <th>Nomor Polisi</th>
                                <th>Nomor Container</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($armadas as $key => $armada)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $armada->nama_kendaraan }}</td>
                                <td>{{ $armada->plat_nomor }}</td>
                                <td>{{ $armada->container_nomor }}</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <form action="{{ route('armada.destroy', $armada->id) }}" method="POST"
                                            class="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-2">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-warning mx-1 rounded-2" data-toggle="modal"
                                            data-target="#editModal{{ $armada->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $armada->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Kendaraan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('armada.update', $armada->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="nama_kendaraan">Jenis Kendaraan</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_kendaraan" name="nama_kendaraan"
                                                                    value="{{ $armada->nama_kendaraan }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="plat_nomor">Nomor Polisi</label>
                                                                <input type="text" class="form-control" id="plat_nomor"
                                                                    name="plat_nomor" value="{{ $armada->plat_nomor }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="container_nomor">Nomor Container</label>
                                                                <input type="text" class="form-control"
                                                                    id="container_nomor" name="container_nomor"
                                                                    value="{{ $armada->container_nomor }}">
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
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
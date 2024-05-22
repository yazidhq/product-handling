@extends('dashboard.layout.templates')

@section('konten')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i>
                Refresh Report
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Barang Masuk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $barangs->where('status_pengiriman', 'Barang baru masuk')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Barang Dalam Perjalanan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $barangs->where('status_pengiriman', 'Sedang dalam perjalanan')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-car fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Barang
                                    Selesai
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $barangs->where('status_pengiriman', 'Unit telah sampai')->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Status Lainnya</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        $filteredBarangs = $barangs->whereNotIn('status_pengiriman', [
                                            'Barang baru masuk',
                                            'Sedang dalam perjalanan',
                                            'Unit telah sampai',
                                        ]);
                                    @endphp
                                    {{ $filteredBarangs->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                    <th>Nomor Surat Jalan</th>
                                    <th>Barang</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Armada</th>
                                    <th>Status Pengiriman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->nomor_resi }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->lokasi_penerima }}</td>
                                        <td>{{ $barang->tanggal_pengiriman->format('d-m-Y') }}</td>
                                        <td>{{ $barang->armada->nama_kendaraan }}: {{ $barang->armada->plat_nomor }}</td>
                                        <td>{{ $barang->status_pengiriman }}</td>
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

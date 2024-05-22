<!DOCTYPE html>
<html lang="en">

<head>
    <title>Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }

        .surat-jalan {
            width: 7.1in;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            padding: 15px;
            background-color: #f5f5f5;
            text-align: center;
        }

        .header img {
            width: 120px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .header h2 {
            font-size: 20px;
            margin: 0;
            color: #555;
        }

        .body {
            padding-top: 15px;
        }

        .body table {
            width: 100%;
            border-collapse: collapse;
        }

        .body table th,
        .body table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        .body table th {
            background-color: #f5f5f5;
        }

        .footer {

            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        .body-footer {
            padding: 0px;
        }

        .body-footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .body-footer table th,
        .body-footer table td {
            border: 0px solid #ccc;
            padding: 0px;
            text-align: left;
        }

        .body-footer table th {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>

    <div class="surat-jalan">
        <div class="header">
            <h1>SURAT JALAN</h1>
        </div>

        <div class="body">
            <table>
                <tr>
                    <th>Nomor Resi</th>
                    <td>{{ $barang->nomor_resi }}</td>
                </tr>
                <tr>
                    <th>Nama Unit</th>
                    <td>{{ $barang->nama_unit }}</td>
                </tr>
                <tr>
                    <th>Pengirim</th>
                    <td>{{ $barang->nama_pengirim }}</td>

                </tr>
                <tr>
                    <th>Penerima</th>
                    <td>{{ $barang->nama_penerima }}</td>

                </tr>
                <tr>
                    <th>Kota Penerima</th>
                    <td>{{ $barang->kota_penerima }}</td>
                </tr>
                <tr>
                    <th>Barang</th>
                    <td>{{ Str::ucfirst($barang->nama_barang) }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Barang</th>
                    <td>{{ $barang->deskripsi }}</td>
                </tr>
                <tr>
                    <th style="width: 150px;">Tanggal Pengiriman</th>
                    <td>{{ $barang->tanggal_pengiriman->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Alamat Penerima</th>
                    <td>{{ $barang->lokasi_penerima }}</td>
                </tr>
                <tr>
                    <th>Nomor Penerima</th>
                    <td>{{ $barang->nomor_penerima }}</td>
                </tr>
            </table>

            <br><br>

            <table>
                <tr>
                    <th style="width: 70px;">No. </th>
                    <th style="width: 70px;">Qty</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td rowspan="20"></td>
                    <td rowspan="20"></td>
                    <td rowspan="20"></td>
                </tr>
            </table>
            <hr style="margin-top: -1px">
            <p>Unit/ Barang diterima dalam keadaan baik.</p>
        </div>

        <br><br><br>

        <div class="body-footer">
            <table>
                <tr>
                    <td>
                        <div class="footer">
                            <div>
                                <p style="font-weight: bold">PENERIMA, <br> {{ Str::ucfirst($barang->nama_penerima) }}
                                </p><br><br><br><br><br><br>
                                <p>(______________________________)</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="footer">
                            <div>
                                <p style="font-weight: bold">Jakarta, ....................................... <br>
                                    Hormat Kami, </p><br><br><br><br><br><br>
                                <p>(______________________________)</p>
                            </div>
                        </div>
                    </td>

                </tr>
            </table>
        </div>

    </div>

</body>

</html>

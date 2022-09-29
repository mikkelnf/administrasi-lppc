<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <title>Rapor {{ $nama_peserta }} Semester {{ $i_s }} {{ $spa ? '('.$spa.')' : ''}}</title>
    <style type="text/css" media="all">
        @font-face {
            font-family: 'Roboto-Regular';
            font-style: normal;
            font-weight: normal;
            src: local("Roboto-Regular"), url('fonts\Roboto-Regular.ttf') format('truetype');
        }
        @page {
            size: A4;
            margin: 20px 35px;
        }
        @media print {
            #print {
                display: none;
            }
        }
        .check{
            font-family:"DeJaVu Sans Mono",monospace;
        }
        body{
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            width: 210mm;
            margin: auto;
        }
        .rapor {
            background: white;
            margin: auto;
            margin-top: 20px;
        }
        .header{
            display: flex;
            padding: 0 0 30px 0;
            text-align: center;
            margin: auto;
        }
        .header .logo{
            padding: 0 8px;
            width: 15%;
        }
        .header .judul{
            width: 85%;
        }
        .judul{
            width: 85%;
            font-size: 22px;
            font-weight: 600;
            margin: auto;
            opacity: 0.9;
            padding: 0 50px;
        }
        .tabel-rapor{
            margin-bottom: 30px;
        }
        .tabel-rapor th{
            width: 25%;
            text-align: left;
            padding: 5px 10px;
            border: 1px solid black !important;
        }
        .tabel-rapor td{
            text-align: left;
            padding: 5px 10px;
            border: 1px solid black !important;
        }
        .tabel-pert .hidden {
            visibility: hidden;
            opacity: 0;
        }
        .tabel-pert .hidden td {
            padding: 0;
            line-height: 0;
        }
        .tabel-pert{
            table-layout: fixed;
            width: 100%;
            margin-bottom: 30px;
        }
        .tabel-pert th{
            padding: 5px 10px;
            border: 1px solid black !important;
        }
        .tabel-pert td{
            text-align: left;
            padding: 5px 10px;
            border: 1px solid black !important;
            word-wrap: break-word;
        }
        .content2 .table tbody td {
            text-align: center;
            align-items: center;
            vertical-align: middle;
        }
        .cetak {
            display: flex;
            justify-content: end;
        }
        table { page-break-inside:avoid; page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        .table-pert:last-child {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="rapor">
        <div class="cetak">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
        </div>
        <div class="header">
            <div class="logo">
                <img src="{{ asset('img') }}/logo_gundar.png" style="width:90px; height:90px;">
            </div>
            <div class="judul">Rapor Peserta Kursus Animasi Berbasis Kompetensi Universitas Gunadarma</div>
        </div>
        <div class="content">
            <div class="content1">
                <table class="table tabel-rapor" style="width:100%">
                    <tr>
                        <th style="font-weight: 600;">Nama</th>
                        <td>{{ $rapor->peserta->nama_peserta }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">NPM</th>
                        <td>{{ $rapor->peserta->npm_peserta }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Telp</th>
                        <td>{{ $rapor->peserta->notelp_peserta ? $rapor->peserta->notelp_peserta :'-' }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Jurusan</th>
                        <td>{{ $rapor->peserta->jurusan->nama_jurusan ? $rapor->peserta->jurusan->nama_jurusan :'-' }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Skema</th>
                        <td>{{ $rapor->peserta->skema->nama_skema }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Semester</th>
                        <td>{{ $i_s }} {{ $spa ? '('.$spa.')' : ''}}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Kehadiran</th>
                        <td>{{ $counter_hadir }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Kelengkapan Tugas</th>
                        <td>{{ $counter_selesai }}</td>
                    </tr>
                    <tr>
                        <th style="font-weight: 600;">Status Kelulusan</th>
                        <td>{{ $status_kelulusan }}</td>
                    </tr>
                </table>
            </div>
            @foreach ($raporsem as $data)
                <div class="content2">
                    <table class="table tabel-pert">
                        <thead>
                            <tr class="hidden">
                                <td style="width: 15%;"></td>
                                <td style="width: 9%"></td>
                                <td style="width: 9%"></td>
                                <td style="width: 12%;"></td>
                                <td style="width: 12%;"></td>
                                <td style="width: 13%;"></td>
                                <td style="width: 12%;"></td>
                                <td style="width: 18%;"></td>
                            </tr>
                            <tr>
                                <th class="align-middle pert" style="font-weight: 600; background: rgba(0, 0, 0, 0.1); text-align: left;">Pertemuan {{ $loop->iteration }}</th>
                                <th class="align-middle npert" style="font-weight: 600; background: rgba(0, 0, 0, 0.1); text-align: left;" colspan="7">{{ $data->nama_pertemuan ? $data->nama_pertemuan : '-' }}</th>
                            </tr>
                            <tr>
                                <th class="align-middle ip" style="background: rgba(0, 0, 0, 0.08); text-align: left" rowspan="2">Item Penilaian</th>
                                <th class="align-middle ab" style="background: rgba(0, 0, 0, 0.08); text-align: center" colspan="2">Absensi</th>
                                <th class="align-middle nt" style="background: rgba(0, 0, 0, 0.08); text-align: center" colspan="2">{{ $data->nama_tugas ? $data->nama_tugas : 'Tugas' }}</th>
                                <th class="align-middle ap" style="background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">Asisten Penilai</th>
                                <th class="align-middle tp" style="background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">Diperiksa pada tanggal</th>
                                <th class="align-middle ct" style="background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">catatan</th>
                            </tr>
                            <tr>
                                <th class="align-middle had" style="background: rgba(0, 0, 0, 0.08); text-align: center">Hadir</th>
                                <th class="align-middle thad" style="background: rgba(0, 0, 0, 0.08); text-align: center">Tidak Hadir</th>
                                <th class="align-middle ya" style="background: rgba(0, 0, 0, 0.08); text-align: center">Ya</th>
                                <th class="align-middle tdk" style="background: rgba(0, 0, 0, 0.08); text-align: center">Tidak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td class="align-middle" style="text-align: left">Hasil Penilaian</td>
                                <td style="text-align: center;" class="align-middle check">
                                    {!! $kehadiran->{'pertemuan_'.$loop->iteration} == "Hadir" ? '&#x2713;' : '' !!}
                                </td>
                                <td style="text-align: center;" class="align-middle check">
                                    {!! $kehadiran->{'pertemuan_'.$loop->iteration} == "Absen" ? '&#x2713;' : '' !!}
                                </td>
                                <td style="text-align: center;" class="align-middle check">
                                    {!! $tugas->{'tugas_'.$loop->iteration} == "Selesai" ? '&#x2713;' : '' !!}
                                </td>
                                <td style="text-align: center;" class="align-middle check">
                                    {!! $tugas->{'tugas_'.$loop->iteration} == "Belum Selesai" ? '&#x2713;' : '' !!}
                                </td>
                                <td>
                                    {{ $apr->{'pert'.$loop->iteration} ? $apr->{'pert'.$loop->iteration}->nama_user : '' }}
                                </td>
                                <td>
                                    {{ $tpr->{'pertemuan_'.$loop->iteration} }}
                                </td>
                                <td>
                                    {{ $cr->{'pertemuan_'.$loop->iteration} }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>


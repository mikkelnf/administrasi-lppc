<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Jadwal Kursus</title>
<style type="text/css" media="all">
    @font-face {
        font-family: 'Roboto-Regular';
        font-style: normal;
        font-weight: normal;
        src: local("Roboto-Regular"), url('fonts\Roboto-Regular.ttf') format('truetype');
    }
    @page {
        size: A4;
        margin: 50px 70px;
    }
    body{
        font-size: 12px;
        font-family: 'Roboto-Regular' !important;
    }
    h3 { 
        font-family: 'Roboto-Regular' !important;
        text-align: center;
    }
    hr {
        border-width:1px;
        margin-bottom: 10px;
    }
    table { page-break-inside:auto; page-break-after:{{$jadwal->count() == 1 ? 'auto' : 'always'}} }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    #jadwal-jadwal:last-child {
        page-break-after: auto;
    }
    .info {
        font-family: 'Roboto-Regular' !important;
        padding: 10px 0;
        color: rgba(0, 0, 0, 0.9);
        margin-bottom: 10px;
        margin-top: 5px;
    }
    .table {
        font-family: 'Roboto-Regular' !important;
        width: 95%;
        margin:auto;
        margin-bottom: 20px;
        table-layout: fixed;
        margin-top: 0px;
    }
    .table th {
        font-size: 13px !important;
        font-weight: 600;
        line-height: 25px;
        vertical-align: middle !important;
        align-items: center !important;
        margin-top: -10px;
        padding: 0px 0px 5px 0px !important;
        background-color: rgb(220, 220, 220);
        color: rgba(0, 0, 0, 0.85);
    }
    .table tr th, .table tr td{
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.45);
    }
    .table td {
        font-size: 11px !important;
        vertical-align: middle;
        /* line-height: 15px; */
        padding: 1px 0 !important;
        color: rgba(0, 0, 0, 0.85);
        padding-left: 5px;
        text-transform:uppercase;
    }
    .table-ta {
        font-size: 13px !important;
        font-family: 'Roboto-Regular' !important;
        letter-spacing: 0px;
        color: rgba(0, 0, 0, 0.9);
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgb(204, 204, 204);
        border-bottom: 1px solid rgb(204, 204, 204);
        margin-top: 30px;
        margin-bottom: -22px;
        margin-left: auto;
        margin-right: auto;
        width: 95%;
    }
    .table-ta>div {
        padding: 10px 25px 5px 0;
    }
    .table-ta>div>a {
        padding: 0 25px 0 0;
        font-family: 'Roboto-Regular' !important;
    }
</style>
</head>
<body>
    <div id="jadwal-jadwal">
        @foreach($jadwal as $jdwl)
            <div>
                <h3>
                    JADWAL KURSUS KOMPETENSI ANIMASI 3D ANGKATAN {{ $t_a }} SEMESTER {{ $i_s }} <br>
                    UNIVERSITAS GUNADARMA
                </h3>
                <hr>
                <div class="info">
                    <a><strong>PERHATIAN :</strong></a> <br>
                    <a>1. Pertemuan dilakukan secara daring selama 180 menit dengan mengakses link Google Meet yang tertera.</a> <br>
                    <a>2. Pertemuan bersifat <strong>WAJIB SETIAP PEKAN</strong>. Tidak ada sesi pengulangan.</a> <br>
                    <a>3. Tidak diperbolehkan mengganti jadwal tanpa sepengetahuan pihak lab.</a> <br>
                </div>
                <div class="table-ta" style="width: 80%;">
                    <div>
                        <a>Hari : {{ $jdwl->hari }}</a>
                        <a>Jam : {{ $jdwl->jam }}</a>
                        <a>Link : {{ $jdwl->link }}</a>
                    </div>
                </div>
                <table class="table" cellspacing="0" style="width: 80%; page-break-after:{{$loop->last ? 'auto' : 'always'}};">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 16%;">NPM</th>
                            <th style="width: 47%;">Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesertadijadwal->where('id_jadwalkursus', $jdwl->id) as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->peserta->npm_peserta }}</td>
                                <td style="text-align: left;">{{ $data->peserta->nama_peserta }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="font-weight: 800;"></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-weight: 800;">
                                    Belum ada peserta di jadwal ini
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-weight: 800;"></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</body>
</html>


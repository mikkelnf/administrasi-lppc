<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kehadiran Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <style type="text/css" media="all">
    body{
        padding: 50px;
    }
    .head-content { 
        width: 95%;
        margin: auto;
        padding-bottom: 10px;
        border-bottom: 1px solid rgb(204, 204, 204);
    }
    .head-detail { 
        width: 10%;
        margin: auto;
        margin-top: 35px;
        text-align: center;
        padding-bottom: 10px;
        border-bottom: 1px solid rgb(204, 204, 204);
    }
    .info-total {
        margin: auto;
        margin-top: 25px;
        width: 95%;
        font-size: 14px;
        color: rgb(88, 88, 88);
    }
    .table {
        font-size: 14px;
        color: rgb(88, 88, 88);
        width: 95%;
        margin:auto;
        margin-top: 10px;
        margin-bottom: 20px;
        table-layout: fixed;
        border-bottom: none;
    }
    tbody tr {
        background-color: transparent;
    }
    .table th{
        padding: 5px;
    }
    .table tr th, .table tr td {
        border-color: rgb(209, 209, 209);
        text-align: center;
    }
    .table td {
        line-height: 8px;
        color: rgba(0, 0, 0, 0.5);
        vertical-align: middle;
    }
    .table td.action div{
        display: flex;
        justify-content: center;
        padding: 0 5px;
    }
    .table td.hadir{
        color: #44AB72;
        background-color: #44ab7242;
    }
    .table td.absen{
        color: #DF2063;
        background-color: #df206348;
    }
    #print {
        margin-left: auto;
    }

    @media (max-width: 1000px){
        body{
            padding: 10px;
        }
        .head-detail { 
            width: 25%;
        }
        #detail-tugas .row>div{
            width: 30%;
            height: 80px;
            padding: 0 10px 0px 10px;
        }
        .table td {
            line-height: 15px;
        }
    }

    @media print {
        #print {
            display: none;
        }
        .table th{
            padding: 10px 0px;
        }
    }
    </style>
</head>
<body>
    <div class="head-content d-flex">
        <a style="font-size: 18px"><strong>Data Kelulusan Peserta Angkatan {{ $t_a }}</strong></a> 
        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
    </div>
    <div class="info-total">
        <div >Total Lulus : {{ $kelulusan->where('status_kelulusan', "Lulus")->count() }} Peserta</div>
        <div >Total Tidak Lulus : {{ $kelulusan->where('status_kelulusan', "Tidak Lulus")->count() }} Peserta</div>
    </div>
    <table class="table table-bordered" cellspacing="0" id="kelulusan">
        <thead>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">NPM</th>
                    <th style="width: 31%;">Nama</th>
                    <th style="width: 11%;">Angkatan</th>
                    <th style="width: 15%;">Kehadiran</th>
                    <th style="width: 15%;">Kelengkapan Tugas</th>
                    <th style="width: 13%;">Status Kelulusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse( $kelulusan as $data )
                    <tr> 
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->peserta->npm_peserta }}</td>
                        <td>{{ $data->peserta->nama_peserta }}</td>
                        <td>{{ $data->peserta->angkatan->tahun_angkatan }}</td>
                        <td>{{ $data->kehadiran == null ? "0%" : $data->kehadiran."%" }}
                        </td>
                        <td>{{ $data->kelengkapan_tugas == null ? "0%" : $data->kelengkapan_tugas."%" }}
                        </td>
                        <td style="{{ $data->status_kelulusan == "Tidak Lulus" ? 'color:rgba(255, 0, 0, 0.6)' : ($data->status_kelulusan == "Lulus" ? 'color:rgba(0, 128, 0, 0.6)' : '') }}">{{ $data->status_kelulusan == null ? '' : $data->status_kelulusan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="font-weight: 800;"></td>
                    </tr>
                    <tr>
                        <td colspan="7" style="font-weight: 800;">
                            Tidak Ada Peserta
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" style="font-weight: 800;"></td>
                    </tr>
                @endforelse
            </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript">
        $(window).resize(function () {
            var widthWindow = $(window).width();
            if (widthWindow <= '1000') {
                $('table').addClass('table-responsive');
            }
            else
            {
                $('table').removeClass('table-responsive');
            }
        });
        $(window).trigger('resize');
    </script>
</body>
</html>
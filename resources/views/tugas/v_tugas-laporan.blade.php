<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tugas Pertemuan Peserta</title>
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
        .table {
            font-size: 14px;
            color: rgb(88, 88, 88);
            width: 95%;
            margin:auto;
            margin-top: 15px;
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
        .table td.selesai{
            color: #44AB72;
            font-size: 15px;
            font-weight: 800;
            background-color: #44ab7242;
        }
        .table td.b-s{
            color: #DF2063;
            font-size: 11px;
            background-color: #df206348;
        }
        /* detail-tugas */
        #detail-tugas{
            font-size: 14px;
            display: flex;
            justify-content: center;
            margin-top: 10px;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }
        #detail-tugas>div{
            margin: auto;
            width: 100%;
        }
        #detail-tugas .panel-heading{
            align-items: center;
            text-align: center;
            margin: auto;
            padding: 10px;
        }
        #detail-tugas .panel-heading>div{
            margin-left: auto;
            margin-right: auto;
            user-select: none;
        }
        #detail-tugas .panel-heading a{
            padding: 0 10px 0 5px;
        }
        #detail-tugas .nomor-tugas{
            padding-bottom: 5px;
            border-bottom: 1px solid rgb(204, 204, 204);
        }
        #detail-tugas .nama-tugas{
            padding-top: 5px;
            padding-bottom: 10px;
            font-size: 13px;
            color: rgb(31, 132, 192);
        }
        #detail-tugas .isi{
            padding: 20px 20px 0 20px;
        }
        #detail-tugas .isi .a{
            text-align: center;
            justify-content: center;
            width: 260px;
            margin-bottom: 15px;
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
            #detail-tugas .row>div{
                width: 20%;
                height: 80px;
                padding: 0 10px 0px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="head-content d-flex">
        <a style="font-size: 18px"><strong>Daftar Tugas Pertemuan Peserta Angkatan {{ $t_a }} Semester {{ $i_s }}</strong></a> 
        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
    </div>

    <table class="table table-bordered" cellspacing="0" id="peserta">
        <thead>
            <tr>
                <th class="align-middle no" style="width: 4%;" rowspan="2">No</th>
                <th class="align-middle npm" style="width: 9%;" rowspan="2">NPM</th>
                <th class="align-middle nama" style="width: 25%;" rowspan="2">Nama</th>
                <th class="tugas-pertemuan" colspan="10">
                    Tugas ke-
                </th>
            </tr>
            <tr>
                @for ($i = 1; $i < 11; $i++)
                    <th style="width: 6%;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse( $tugas as $data )
            <tr> 
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->peserta->npm_peserta }}</td>
                <td>{{ $data->peserta->nama_peserta }}</td>
                @for ($i = 1; $i < 11; $i++)
                    <td class="{{ $data->{'tugas_'.$i} == "Selesai" ? 'selesai' : ($data->{'tugas_'.$i} == "Belum Selesai" ? 'b-s' : '') }}">{!! $data->{'tugas_'.$i} == "Selesai" ? '&#x2713;' : ($data->{'tugas_'.$i} == "Belum Selesai"  ? '&#9866;' : '') !!}</td>
                @endfor
            </tr>
            @empty
            <tr>
                <td colspan="9" style="font-weight: 800;"></td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: 800;">
                    Tidak Ada Peserta
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: 800;"></td>
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
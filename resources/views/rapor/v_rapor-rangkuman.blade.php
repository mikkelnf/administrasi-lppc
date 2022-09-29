<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rangkuman Kelulusan Rapor Peserta</title>
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
        margin-top: 30px;
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
    }
    </style>
</head>
<body>
    <div class="head-content d-flex">
        <a style="font-size: 18px"><strong>Rangkuman Kelulusan Rapor Peserta Angkatan {{ $t_a }}</strong></a> 
        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
    </div>

    <table class="table table-bordered" cellspacing="0" id="peserta">
        <thead>
            <tr>
                <th class="align-middle no" style="width: 4%;" rowspan="2">No</th>
                <th class="align-middle npm" style="width: 9%;" rowspan="2">NPM</th>
                <th class="align-middle nama" style="width: 28%;" rowspan="2">Nama</th>
                <th class="align-middle nama" style="width: 21%;" rowspan="2">Skema</th>
                <th class="align-middle nama" style="width: 11%;" rowspan="2">Total Kelulusan</th>
                <th class="align-middle nama" style="width: 17%;" rowspan="2">Status Kelulusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $peserta as $data)
            <tr> 
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->npm_peserta }}</td>
                <td>{{ $data->nama_peserta }}</td>
                <td>{{ $data->skema->nama_skema }}</td>
                <td>{{ $array_totalkelulusan[$loop->index] }}</td>
                <td>
                    @if($data->skema->nama_skema == '3D Illustration Artist')
                        @if($array_totalkelulusan[$loop->index]<6)
                        Tidak Lulus
                        @else
                        Lulus
                    @endif
                    @else
                        @if($array_totalkelulusan[$loop->index]<7)
                        Tidak Lulus
                        @else
                        Lulus
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
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
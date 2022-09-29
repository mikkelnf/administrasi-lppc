<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluasi Tugas Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <style type="text/css" media="all">
        body{
            padding: 50px;
        }
        .head-content { 
            width: 100%;
            margin: auto;
            padding-bottom: 10px;
            border-bottom: 1px solid rgb(204, 204, 204);
        }
        .table {
            font-size: 14px;
            color: rgb(88, 88, 88);
            width: 100%;
            margin:auto;
            margin-top: 15px;
            margin-bottom: 20px;
            border-bottom: none;
        }

        tbody tr {
            background-color: transparent;
        }
        .table th{
            vertical-align: middle;
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
            @page {
                size: landscape
            }
            #print {
                display: none;
            }
            body{
                padding: 0px;
            }
        }
    </style>
</head>
<body>
    <div class="head-content d-flex">
        <a style="font-size: 18px"><strong>Daftar Evaluasi Tugas Peserta Angkatan {{ $t_a }} Modul {{ $i_s }}</strong></a> 
        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
    </div>

    <table class="table table-bordered" cellspacing="0" id="peserta">
        <thead class=result_table_header>
            <tr>
                @if( $skema->nama_skema == '3D Illustration Artist' )
                    @if( $i_s == 1 )
                        <th colspan="3"></th>
                        <th colspan="2">Folder Modul 1.1 (UK-01)</th>
                        <th colspan="2">Folder Modul 1.2 (UK-03)</th>
                        <th colspan="2">Folder Modul 1.3 (UK-06)</th>
                        <th colspan="2">Folder Modul 1.4 (UK-19)</th>
                    @endif
                    @if( $i_s == 2 )
                        <th colspan="3"></th>
                        <th>Folder Modul 2.1 (UK-36)</th>
                        <th>Folder Modul 2.2 (UK-40)</th>
                        <th>Folder Modul 2.3 (UK-34)</th>
                        <th>Folder Modul 2.4 (UK-38)</th>
                        <th>Folder Modul 2.5 (UK-35)</th>
                        <th>Folder Modul 2.6 (UK-39)</th>
                    @endif
                    @if( $i_s == 3 )
                        <th colspan="3"></th>
                        <th>Folder Modul 3.1 (UK-04)</th>
                        <th>Folder Modul 3.2 (UK-08)</th>
                        <th>Folder Modul 3.3 (UK-09)</th>
                    @endif
                    @if( $i_s == 4 )
                        <th colspan="3"></th>
                        <th>Folder Modul 4.1 (UK-07)</th>
                        <th>Folder Modul 4.2 (UK-11)</th>
                        <th>Folder Modul 4.3 (UK-12)</th>
                        <th>Folder Modul 4.4 (UK-13)</th>
                        <th>Folder Modul 4.5 (UK-20)</th>
                        <th>Folder Modul 4.6 (UK-31)</th>
                    @endif
                    @if( $i_s == 5 )
                        <th colspan="3"></th>
                        <th>Folder Modul 5.1 (UK-15)</th>
                        <th>Folder Modul 5.2 (UK-14)</th>
                        <th>Folder Modul 5.3 (UK-21)</th>
                        <th>Folder Modul 5.4 (UK-23)</th>
                    @endif
                    @if( $i_s == 6 )
                        <th colspan="3"></th>
                        <th>Folder Modul 6.1 (UK-43)</th>
                    @endif
                @else
                    @if( $i_s == 1 )
                        <th colspan="3"></th>
                        <th colspan="2">Folder Modul 1.1 (UK-32)</th>
                        <th colspan="2">Folder Modul 1.2 (UK-33)</th>
                        <th colspan="2">Folder Modul 1.5 (UK-30)</th>
                        <th colspan="2">Folder Modul 1.3 (UK-01)</th>
                        <th colspan="2">Folder Modul 1.4 (UK-19)</th>
                        <th colspan="2">Folder Modul 1.6 (UK-03)</th>
                        <th colspan="2">Folder Modul 1.7 (UK-06)</th>
                    @endif
                    @if( $i_s == 2 )
                        <th colspan="3"></th>
                        <th>Folder Modul 2.1 (UK-36)</th>
                        <th>Folder Modul 2.2 (UK-40)</th>
                        <th>Folder Modul 2.3 (UK-34)</th>
                        <th>Folder Modul 2.4 (UK-38)</th>
                        <th>Folder Modul 2.5 (UK-35)</th>
                        <th>Folder Modul 2.6 (UK-39)</th>
                    @endif
                    @if( $i_s == 3 )
                        <th colspan="3"></th>
                        <th>Folder Modul 3.1 (UK-05)</th>
                        <th>Folder Modul 3.2 (UK-16)</th>
                        <th>Folder Modul 3.3 (UK-18)</th>
                    @endif
                    @if( $i_s == 4 )
                        <th colspan="3"></th>
                        <th>Folder Modul 4.1 (UK-08)</th>
                        <th>Folder Modul 4.2 (UK-09)</th>
                        <th>Folder Modul 4.3 (UK-17)</th>
                        <th>Folder Modul 4.4 (UK-04)</th>
                    @endif
                    @if( $i_s == 5 )
                        <th colspan="3"></th>
                        <th>Folder Modul 5.1 (UK-07)</th>
                        <th>Folder Modul 5.2 (UK-11)</th>
                        <th>Folder Modul 5.3 (UK-12)</th>
                        <th>Folder Modul 5.4 (UK-13)</th>
                        <th>Folder Modul 5.5 (UK-20)</th>
                        <th>Folder Modul 5.6 (UK-31)</th>
                    @endif
                    @if( $i_s == 6 )
                        <th colspan="3"></th>
                        <th>Folder Modul 6.1 (UK-15)</th>
                        <th>Folder Modul 6.2 (UK-14)</th>
                    @endif
                    @if( $i_s == 7 )
                        <th colspan="3"></th>
                        <th>Folder Modul 7.1 (UK-24)</th>
                        <th>Folder Modul 7.2 (UK-26)</th>
                    @endif
                    @if( $i_s == 8 )
                        <th colspan="3"></th>
                        <th>Folder Modul 8.1 (UK-43)</th>
                        <th>Folder Modul 8.2 (UK-44)</th>
                        <th>Folder Modul 8.3 (UK-45)</th>
                    @endif
                @endif
            </tr>
            <tr>
                <th style="width: 10px !important">No</th>
                <th style="width: 20px !important">NPM</th>
                <th style="width: 400px !important">Nama</th>
                @foreach($detail as $data)
                    <th>{{ $data->nama_tugas ? $data->nama_tugas : 'Tugas-'.$loop->iteration }}</th>
                @endforeach
            </tr>
        </thead>
        @foreach( $pesertaskema as $data )
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->npm_peserta }}</td>
                <td>{{ $data->nama_peserta }}</td>
                @for ($i = 1; $i < $detail->count() + 1; $i++)
                    @if( $skema->nama_skema == '3D Illustration Artist' )
                        @if( $i_s == 1 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 2 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+8)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+8)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 3 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+14)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+14)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 4 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+17)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+17)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 5 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+23)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+23)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 6 )
                            <td class="{{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+27)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $i+27)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                    @else
                        @if( $i_s == 1 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 2 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+14)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+14)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 3 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+20)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+20)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 4 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+23)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+23)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 5 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+27)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+27)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 6 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+33)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+33)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 7 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+35)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+35)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                        @if( $i_s == 8 )
                            <td class="{{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+37)->first() ? 'selesai' : 'b-s' }}">{!! $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $i+37)->first() ? '&#x2713;' : '&#9866;' !!}</td>
                        @endif
                    @endif
                @endfor
            </tr>
        @endforeach
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
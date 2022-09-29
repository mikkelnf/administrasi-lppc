<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Asisten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <style type="text/css" media="all">
        body{
            font-family: 'Roboto', sans-serif;
            padding: 50px;
        }
        a {
            text-decoration: none;
        }
        .judul { 
            font-family: 'Roboto-Regular' !important;
            text-align: center;
        }
        #jadwal-asisten{
            padding: 20px 50px;
        }
        .jadwal{
            font-size: 15px;
        }
        #print{
            float: right;
            margin-top: -30px; 
        }
        @page {
            size: A4;
            margin: 50px 70px;
        }

        @media (max-width: 1000px){
            body{
                padding: 10px;
            }
            .head-detail { 
                width: 25%;
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
    <div id="jadwal-asisten">
        <a style="font-size: 19px; display: flex; justify-content: center; text-align: center; font-weight:700;">
            Jadwal Asisten Semester {{ $n_s }} <br>
            Pertemuan {{ $i_p }}
        </a>
        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" id="print">Cetak</button>
        <hr>
        <a style="font-size: 17px; display: flex; justify-content: center; text-align: center; "><strong>Periode : {{ $periode->periode ? $periode->periode : '-' }}</strong></a> 
        <br>
        @foreach($jadwal_asisten as $data)
            <div class="col-sm-4">
                <div class="jadwal">
                    <div class="body">
                        <div class="d-flex title">
                            <a>
                                <strong>
                                    {{ $data->jadwalkursus ? $data->jadwalkursus->hari : '-' }} ({{ $data->jadwalkursus ? $data->jadwalkursus->jam : '-' }})
                                </strong>
                            </a>
                        </div>
                        <a >Angkatan : {{ $data->jadwalkursus ? $data->jadwalkursus->angkatan->tahun_angkatan : '-' }}</a> 
                        <br>
                        <a >Jumlah Peserta : {{ $data->jadwalkursus ? $pesertadijadwal->where('id_jadwalkursus', $data->jadwalkursus->id)->count() : '-' }}</a> 
                        <br>
                        <a >Link : {{ $data->jadwalkursus ? $data->jadwalkursus->link : '-' }}</a> 
                        <br>
                        <a >Instruktur : {{ $data->instrukturs ? $data->instrukturs->nama_user : '-' }}</a> 
                        <br>
                        <a >Host : {{ $data->hosts ? $data->hosts->nama_user : '-' }}</a> 
                        <br>
                        <div class="text bbb">
                            <a >Asisten : </a>
                            @if($b->where('id_jadwalasisten', $data->id)->count() > 0)
                                <div class="aa">
                                    @foreach($b->where('id_jadwalasisten', $data->id) as $d)
                                        <a>
                                            - {{ $d->user->nama_user }}
                                        </a> <br>
                                    @endforeach
                                </div>
                            @else
                                <div>
                                    -
                                </div>
                            @endif
                        </div>

                        <hr>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
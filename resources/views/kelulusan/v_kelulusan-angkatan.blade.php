@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelulusan.css') }}">
@endsection 

@section('title-window','Kelulusan Peserta')
@section('title','Kelulusan Peserta')

@section('content')
@if($checker)
<div class="page-content">
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
            @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-peserta{{$data->tahun_angkatan}}-tab" href="/kelulusan-peserta/angkatan/{{$data->tahun_angkatan}}" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
                    Angkatan {{$data->tahun_angkatan}}
                </a>
            @endforeach
        </div>
    </nav>

    @if(session('pesan'))
        <div class="alert alert-success" role="alert">
            <span class="delete-success">{{ session('pesan')}}</span>
        </div>
    @endif
    <div class="alert alert-success collapse" role="alert" id="edit-alert">
        <span class="edit-success"></span>
    </div> 

    <div class="card">
        <div class="tab-content" id="nav-tabContent">
            @if($peserta->count() > 0)
                <div class="card-control d-flex" id="card-control">
                    <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" id="refresh-btn">
                        <span class="material-icons refresh">
                            refresh
                        </span>
                        Refresh
                    </button>
                </div>
                <div id="tabel-kelulusan">
                    <table class="table" cellspacing="0" id="kelulusan">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 11%;">NPM</th>
                                <th style="width: 31%;">Nama</th>
                                <th style="width: 11%;">Angkatan</th>
                                <th style="width: 15%;">Kehadiran</th>
                                <th style="width: 15%;">Kelengkapan Tugas</th>
                                <th style="width: 12%;">Status Kelulusan</th>
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
                                        <div class="bar">
                                            <div class="progress">
                                                <div class="progress-bar {{ $data->kehadiran >= 50 ? 'bg-success' : ($data->kehadiran >= 45 ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width:{{ $data->kehadiran }}%" aria-valuenow="{{ $data->kehadiran }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $data->kelengkapan_tugas == null ? "0%" : $data->kelengkapan_tugas."%" }}
                                        <div class="bar">
                                            <div class="progress">
                                                <div class="progress-bar {{ $data->kelengkapan_tugas >= 56 ? 'bg-success' : ($data->kelengkapan_tugas >= 51 ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width:{{ $data->kelengkapan_tugas }}%" aria-valuenow="{{ $data->kelengkapan_tugas }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
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
                    <div class="info">
                        <hr>
                        <canvas id="chart-line" width="700" height="200" class="chartjs-render-monitor"></canvas>
                        <div class="info-total">Total Lulus : {{ $kelulusan->where('status_kelulusan', "Lulus")->count() }} Peserta</div>
                        <div class="info-total">Total Tidak Lulus : {{ $kelulusan->where('status_kelulusan', "Tidak Lulus")->count() }} Peserta</div>
                        <hr>
                        <div class="alert d-flex">
                            <span class="material-icons-outlined info-icon">info</span>
                            <div class="info-text">
                                Refresh halaman agar data paling terupdate yang ditampilkan <br>
                                <hr>
                                Klik lihat Laporan untuk melihat data kelulusan peserta {{ $t_a }}
                            </div>
                        </div>
                        <a href="/kelulusan-peserta/angkatan/{{ $t_a }}/laporan" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
                    </div>
                </div>
            @else
                <div class="status">
                    <a>Tidak ada peserta pada angkatan ini</a>
                </div>
            @endif
        </div>
    </div>
</div>
@else
    <div class="page-content">
        <div class="card">
            <div class="status">
                <a>Angkatan {{ $t_a }} tidak dapat diolah karena berstatus Tidak Aktif</a>
            </div>
        </div>
    </div>
@endif
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/kelulusan.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    table = $('#kelulusan').DataTable({
        "order": [[ 0, "asc" ]],
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 20,
        "info":     false,
        language: {
            search: '<i class="fas fa-search" aria-hidden="true"></i>',
            searchPlaceholder: "cari",
            "zeroRecords": "Record yang dicari tidak ditemukan",
        },
        columnDefs: [
        { "targets": 0, "sortable":true },
        { "targets": 1, "sortable":false },
        { "targets": 2, "sortable":true },
        { "targets": 3, "sortable":false },
        { "targets": 4, "sortable":true },
        { "targets": 5, "sortable":true },
        { "targets": 6, "sortable":true },
        ]
    });

    var x = $("#kelulusan_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    
    var target = $("#kelulusan_wrapper .row").first();
    var a = "<div class='col-sm-12 col-md-6 tambah'></div>";
    target.append(a);
    target.addClass('table-control');
    $("#kelulusan_wrapper .col-sm-12.col-md-6").first().addClass('cari');

    var target2 = $("#kelulusan_wrapper .tambah").first();
    var cardcontrol = $('#card-control');
    target2.append(cardcontrol);
    
    $('#kelulusan_wrapper .col-sm-12.col-md-5').remove();

    function RefreshTable() {
        location.reload();
    }

    $("#refresh-btn").on("click", RefreshTable);

    var data = [{
        data: [{{ $kelulusan->where('status_kelulusan', "Lulus")->count() }}, {{ $kelulusan->where('status_kelulusan', "Tidak Lulus")->count() }}],
        backgroundColor: ["#08B000", "#CA0000",],
        borderColor: "#fff"
    }];
    var options = {
        tooltips: {
            enabled: true
        },
        title: {
            display: true,
            text: 'Diagram status kelulusan peserta {{ $t_a }}',

        },
        plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                    let sum = ctx.dataset._meta[0].total;
                    let percentage = (value * 100 / sum).toFixed(2) + "%";
                    return percentage;
                },
                color: '#fff',
            },
            title: {
                display: true,
                text: 'Diagram status kelulusan peserta {{ $t_a }}',
            },
        },
    };
    var ctx = document.getElementById("chart-line").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Lulus", "Tidak Lulus"],
            datasets: data
        },
        options: options
    });
});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection 

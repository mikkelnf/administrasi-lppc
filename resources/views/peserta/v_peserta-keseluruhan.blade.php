@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/peserta.css') }}">
@endsection 

@section('title-window','Semua Peserta')
@section('title','Peserta Kursus Keseluruhan')
       
@section('content')
@if($angkatan_aktif_all->count() > 0)
    <div class="page-content">
        <div class="content-header">Daftar Seluruh Peserta Kursus Animasi</div>
        <div class="container-angkatan row">
            @foreach($angkatan_aktif_id->sortBy('tahun_angkatan') as $data)
                <div class="flex-fill">
                    Angkatan {{ $data->tahun_angkatan }}
                </div>
            @endforeach
        </div>
        <div class="container-jumlah jumlah row">
            @foreach($angkatan_aktif_all->sortBy('tahun_angkatan') as $data)
                <div class="flex-fill">
                    {{ $semua_peserta->where('id_angkatan', $data->id)->count() }}
                </div>
            @endforeach
        </div>
        <div class="total">
            Total : &nbsp;<a class="jumlah">{{ $jml_peserta_aktif }}</a>&nbsp; Peserta aktif
        </div>
        <div class="card">
            <table class="table" cellspacing="0" id="example">
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 8%;">NPM</th>
                        <th style="width: 25%;">Nama</th>
                        <th style="width: 12%;">No. Telp</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 9%;">Kelas</th>
                        <th style="width: 9%;">Angkatan</th>
                        <th style="width: 14%;">Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta_aktif as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->npm_peserta }}</td>
                        <td>{{ $data->nama_peserta }}</td>
                        <td>{{ $data->notelp_peserta == null ?  '-' : $data->notelp_peserta }}</td>
                        <td>{{ $data->email_peserta == null ?  '-' : $data->email_peserta }}</td>
                        <td>{{ $data->kelas_peserta == null ?  '-' :  $data->kelas_peserta }}</td>
                        <td>{{ $data->angkatan->tahun_angkatan }}</td>
                        <td>{{ $data->jurusan->nama_jurusan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="page-content">
        <div class="card">
            <div class="status">
                <a>Tidak ada peserta yang aktif</a>
            </div>
        </div>
    </div>
@endif
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    table = $('#example').DataTable({
        "order": [[ 0, "asc" ]],
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 5,
        "info":     false,
        language: {
            search: '<i class="fas fa-search" aria-hidden="true"></i>',
            searchPlaceholder: "cari",
        },
        columnDefs: [
        { "targets": 0, "sortable":true },
        { "targets": 1, "sortable":false },
        { "targets": 2, "sortable":true },
        { "targets": 3, "sortable":false },
        { "targets": 4, "sortable":false },
        { "targets": 5, "sortable":false },
        { "targets": 6, "sortable":true },
        { "targets": 7, "sortable":false }
        ]
    });

    var x = $("#example_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    $('#example_wrapper .col-sm-12.col-md-5').remove();
});
</script>
    
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection 
@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kehadiran.css') }}">
@endsection 

@section('title-window','Kehadiran Peserta')
@section('title','Kehadiran Peserta')

@section('content')
@if($checker)
<div class="page-content">
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
            @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-kehadiran{{$data->tahun_angkatan}}-tab" href="/kehadiran/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
                    Angkatan {{$data->tahun_angkatan}}
                </a>
            @endforeach
        </div>
    </nav>

    @if(session('pesan'))
        <div class="alert alert-success" role="alert" id="edit-alert">
            <span class="edit-success">{{ session('pesan')}}</span>
        </div> 
    @endif

    <div class="semester-aktif">
        Semester Aktif : {{ $angkatan->semester_aktif ? $angkatan->semester_aktif : '-' }}
    </div>
    <div class="border row">
        <div class="menu-semester">
            <div class="list-group list-group-flush">
                <a class="list-group-head">Semester</a>
                @if( $skema->nama_skema == 'Pembuat Ide Gerak & Cerita (Generalist)' )
                    @foreach($semester_all as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/kehadiran/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach
                @endif
                @if( $skema->nama_skema == '3D Illustration Artist' )   
                    @foreach(range(1, 6) as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data) ? 'active' : '' }} {{ $data == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data }}-tab" href="/kehadiran/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data }}" aria-controls="tugas-semeseter{{ $data }}" aria-selected="true">{{ $data }}</a>
                    @endforeach
                @endif       
            </div>
        </div>
    
        <div class="cards">
            <ul class="nav nav-tabs menu-skema" role="tablist" id="mytab">
                @if( $i_s < 7 )
                    @foreach( $skema_all as $data )
                        <li class="nav-item">
                            <a class="nav-link {{ request()->segment(5) == 's-0'.$data->id ? 'active' : '' }}" href="/kehadiran/angkatan/{{ $t_a }}/skema/s-0{{ $data->id }}/semester/{{ $i_s }}">{{ $data->nama_skema }}</a>
                        </li>
                    @endforeach
                @endif
                @if( $i_s > 6 )
                    <li class="nav-item">
                        <a class="nav-link active" href="/kehadiran/angkatan/{{ $t_a }}/skema/s-0{{ $skemas1->id }}/semester/{{ $i_s }}">{{ $skemas1->nama_skema }}</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="nav-tabContent">
                <div id="tabel-peserta">
                    <table class="table" cellspacing="0" id="peserta">
                        <thead>
                            <tr>
                                <th class="align-middle no" style="width: 4%;" rowspan="2">No</th>
                                <th class="align-middle npm" style="width: 9%;" rowspan="2">NPM</th>
                                <th class="align-middle nama" style="width: 28%;" rowspan="2">Nama</th>
                                <th class="kehadiran-pertemuan" colspan="10">Kehadiran Pertemuan ke-</th>
                                <th class="align-middle aksi" style="width: 9%;" rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th style="width: 5%;">1</th>
                                <th style="width: 5%;">2</th>
                                <th style="width: 5%;">3</th>
                                <th style="width: 5%;">4</th>
                                <th style="width: 5%;">5</th>
                                <th style="width: 5%;">6</th>
                                <th style="width: 5%;">7</th>
                                <th style="width: 5%;">8</th>
                                <th style="width: 5%;">9</th>
                                <th style="width: 5%;">10</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $kehadiran as $data )
                                <tr> 
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->peserta->npm_peserta }}</td>
                                    <td>{{ $data->peserta->nama_peserta }}</td>
                                    <td class="{{ $data->pertemuan_1 == "Hadir" ? 'hadir' : ($data->pertemuan_1 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_1 == "Hadir" ? 'H' : ($data->pertemuan_1 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_2 == "Hadir" ? 'hadir' : ($data->pertemuan_2 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_2 == "Hadir" ? 'H' : ($data->pertemuan_2 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_3 == "Hadir" ? 'hadir' : ($data->pertemuan_3 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_3 == "Hadir" ? 'H' : ($data->pertemuan_3 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_4 == "Hadir" ? 'hadir' : ($data->pertemuan_4 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_4 == "Hadir" ? 'H' : ($data->pertemuan_4 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_5 == "Hadir" ? 'hadir' : ($data->pertemuan_5 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_5 == "Hadir" ? 'H' : ($data->pertemuan_5 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_6 == "Hadir" ? 'hadir' : ($data->pertemuan_6 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_6 == "Hadir" ? 'H' : ($data->pertemuan_6 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_7 == "Hadir" ? 'hadir' : ($data->pertemuan_7 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_7 == "Hadir" ? 'H' : ($data->pertemuan_7 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_8 == "Hadir" ? 'hadir' : ($data->pertemuan_8 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_8 == "Hadir" ? 'H' : ($data->pertemuan_8 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_9 == "Hadir" ? 'hadir' : ($data->pertemuan_9 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_9 == "Hadir" ? 'H' : ($data->pertemuan_9 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="{{ $data->pertemuan_10 == "Hadir" ? 'hadir' : ($data->pertemuan_10 == "Absen" ? 'absen' : '') }}">{{ $data->pertemuan_10 == "Hadir" ? 'H' : ($data->pertemuan_10 == "Absen"  ? 'A' : '') }}</td>
                                    <td class="action">                          
                                        <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#edit-{{ $data->id_peserta }}">
                                            <span class="material-icons-outlined ip2">
                                                edit
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @foreach( $kehadiran as $data )
                    <div class="modal fade edit-peserta" id="edit-{{ $data->id_peserta }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kehadiran Peserta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/kehadiran/angkatan/{{ $t_a }}/semester/{{ $i_s }}/edit/{{ $data->id_peserta }}" method="POST" id="formeditkehadiran-{{ $data->id }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="semester">Semester : {{ $i_s }}</div>
                                        <div class="nama-peserta">{{ $data->peserta->nama_peserta }}</div>
                                        <hr>
                                        <div class="row d-flex justify-content-center text-center">
                                            <div class="row-1">
                                                @for($i=1; $i<6; $i++)
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-form-label">Pertemuan {{ $i }}</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-select {{ $data->{'pertemuan_'.$i} == "Absen" ? 'merah' : ($data->{'pertemuan_'.$i} == "Hadir" ? 'hijau' : '') }}" name={{ "pertemuan_".$i }} id="status-kehadiran{{ $i }}">
                                                                @foreach(["Hadir" => "Hadir", "Absen" => "Absen"] as $status)
                                                                    <option class="{{ $status == "Absen" ? 'merah' : 'hijau' }}" value="{{ $status }}" {{ $data->{'pertemuan_'.$i} == "Absen" ? 'selected' : '' }}>{{ $status }}</option>
                                                                @endforeach
                                                                <option value="" {{ $data->{'pertemuan_'.$i} == "" ? 'selected' : '' }}>-</option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                @endfor
                                            </div>
                                            <div class="row-2">
                                                @for($i=6; $i<11; $i++)
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-form-label">Pertemuan {{ $i }}</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-select {{ $data->{'pertemuan_'.$i} == "Absen" ? 'merah' : ($data->{'pertemuan_'.$i} == "Hadir" ? 'hijau' : '') }}" name={{ "pertemuan_".$i }} id="status-kehadiran{{ $i }}">
                                                                @foreach(["Hadir" => "Hadir", "Absen" => "Absen"] as $status)
                                                                    <option class="{{ $status == "Absen" ? 'merah' : 'hijau' }}" value="{{ $status }}" {{ $data->{'pertemuan_'.$i} == "Absen" ? 'selected' : '' }}>{{ $status }}</option>
                                                                @endforeach
                                                                <option value="" {{ $data->{'pertemuan_'.$i} == "" ? 'selected' : '' }}>-</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="info">
                <hr>
                <div class="alert d-flex">
                    <span class="material-icons-outlined info-icon">info</span>
                    <div class="info-text">
                        Klik lihat Laporan untuk melihat semua data kehadiran peserta {{ $t_a }} pada semester ini
                    </div>
                </div>
                <a href="/kehadiran/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $i_s }}/laporan" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
            </div>
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
<script type="text/javascript" src="{{ asset('js') }}/peserta.js"></script>
<script type="text/javascript">
    var sel = document.querySelectorAll('#status-kehadiran1, #status-kehadiran2, #status-kehadiran3, #status-kehadiran4, #status-kehadiran5, #status-kehadiran6, #status-kehadiran7, #status-kehadiran8, #status-kehadiran9, #status-kehadiran10');
    sel.forEach(function(el){
        el.addEventListener('change', function(){
            el.classList.remove("hijau");
            el.classList.remove("merah");
            el.classList.add(el.options[el.selectedIndex].className);
        });
    });
</script>
<script type="text/javascript">
$(document).ready( function () {
    table = $('#peserta').DataTable({
        "order": [[ 2, "asc" ]],
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
        { "targets": 0, "sortable":false },
        { "targets": 1, "sortable":false },
        { "targets": 2, "sortable":true },
        { "targets": 3, "sortable":false },
        { "targets": 4, "sortable":false },
        { "targets": 5, "sortable":false },
        { "targets": 6, "sortable":false },
        { "targets": 7, "sortable":false },
        { "targets": 8, "sortable":false },
        { "targets": 9, "sortable":false },
        { "targets": 10, "sortable":false },
        { "targets": 11, "sortable":false },
        { "targets": 12, "sortable":false },
        { "targets": 13, "sortable":false },
        ]
    });

    var x = $("#peserta_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    
    var target = $("#peserta_wrapper .row").first();
    target.addClass('table-control');
    
    $('#peserta_wrapper .col-sm-12.col-md-5').remove();
});
</script>
    
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection
@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/tugas.css') }}">
@endsection 

@section('title-window','Tugas Pertemuan Peserta')
@section('title','Tugas Pertemuan Peserta')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-tugas{{$data->tahun_angkatan}}-tab" href="/tugas/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{$skemafirst_id}}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
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
                        <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach
                @endif
                @if( $skema->nama_skema == '3D Illustration Artist' )   
                    @foreach(range(1, 6) as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data) ? 'active' : '' }} {{ $data == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data }}-tab" href="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data }}" aria-controls="tugas-semeseter{{ $data }}" aria-selected="true">{{ $data }}</a>
                    @endforeach
                @endif           
                </div>
            </div>
        
            <div class="cards">
                <ul class="nav nav-tabs menu-skema" role="tablist" id="mytab">
                    @if( $i_s < 7 )
                        @foreach( $skema_all as $data )
                            <li class="nav-item">
                                <a class="nav-link {{ request()->segment(5) == 's-0'.$data->id ? 'active' : '' }}" href="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $data->id }}/semester/{{ $i_s }}">{{ $data->nama_skema }}</a>
                            </li>
                        @endforeach
                    @endif
                    @if( $i_s > 6 )
                        <li class="nav-item">
                            <a class="nav-link active" href="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemas1->id }}/semester/{{ $i_s }}">{{ $skemas1->nama_skema }}</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="nav-tabContent">
                    <div id="tabel-peserta">
                        <table class="table" cellspacing="0" id="peserta">
                            <thead>
                                <tr>
                                    <th class="align-middle no" style="width: 4%;" rowspan="2">No</th>
                                    <th class="align-middle npm" style="width: 8%;" rowspan="2">NPM</th>
                                    <th class="align-middle nama" style="width: 27%;" rowspan="2">Nama</th>
                                    <th class="tugas-pertemuan" colspan="10">
                                        Tugas pertemuan ke-
                                    </th>
                                    <th class="align-middle aksi" style="width: 3%;" rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    @for ($i = 1; $i < 11; $i++)
                                        <th style="width: 6%;">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $tugas as $data )
                                    <tr> 
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->peserta->npm_peserta }}</td>
                                        <td>{{ $data->peserta->nama_peserta }}</td>
                                        @for ($i = 1; $i < 11; $i++)
                                            <td class="{{ $data->{'tugas_'.$i} == "Selesai" ? 'selesai' : ($data->{'tugas_'.$i} == "Belum Selesai" ? 'b-s' : '') }}">{!! $data->{'tugas_'.$i} == "Selesai" ? '&#x2713;' : ($data->{'tugas_'.$i} == "Belum Selesai"  ? '&#9866;' : '') !!}</td>
                                        @endfor
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
                    @foreach( $tugas as $data )
                        <div class="modal fade edit-peserta" id="edit-{{ $data->id_peserta }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Tugas Peserta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $i_s }}/edit/{{ $data->id_peserta }}" method="POST" id="formedittugas-{{ $data->id_peserta }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="semester">Semester : {{ $i_s }}</div>
                                            <div class="nama-peserta">{{ $data->peserta->nama_peserta }}</div>
                                            <hr>
                                            <div class="row d-flex justify-content-center text-center">
                                                <div class="row-1">
                                                    @for($i=1; $i<6; $i++)
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-form-label">Tugas ke-{{ $i }}</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-select {{ $data->{'tugas_'.$i} == "Belum Selesai" ? 'merah' : ($data->{'tugas_'.$i} == "Selesai" ? 'hijau' : '') }}" name={{ "tugas_".$i }} id="status-tugas{{ $i }}">
                                                                    @foreach(["Selesai" => "Selesai", "Belum Selesai" => "Belum Selesai"] as $status)
                                                                        <option class="{{ $status == "Belum Selesai" ? 'merah' : 'hijau' }}" value="{{ $status }}" {{ $data->{'tugas_'.$i} == "Belum Selesai" ? 'selected' : '' }}>{{ $status }}</option>
                                                                    @endforeach
                                                                    <option value="" {{ $data->{'tugas_'.$i} == "" ? 'selected' : '' }}>-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="row-2">
                                                    @for($i=6; $i<11; $i++)
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-form-label">Tugas ke-{{ $i }}</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-select {{ $data->{'tugas_'.$i} == "Belum Selesai" ? 'merah' : ($data->{'tugas_'.$i} == "Selesai" ? 'hijau' : '') }}" name={{ "tugas_".$i }} id="status-tugas{{ $i }}">
                                                                    @foreach(["Selesai" => "Selesai", "Belum Selesai" => "Belum Selesai"] as $status)
                                                                        <option class="{{ $status == "Belum Selesai" ? 'merah' : 'hijau' }}" value="{{ $status }}" {{ $data->{'tugas_'.$i} == "Belum Selesai" ? 'selected' : '' }}>{{ $status }}</option>
                                                                    @endforeach
                                                                    <option value="" {{ $data->{'tugas_'.$i} == "" ? 'selected' : '' }}>-</option>
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
                            Klik lihat Laporan untuk melihat semua data tugas peserta {{ $t_a }} pada semester ini
                        </div>
                    </div>
                    <a href="/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $i_s }}/laporan" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
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
    var sel = document.querySelectorAll('#status-tugas1, #status-tugas2, #status-tugas3, #status-tugas4, #status-tugas5, #status-tugas6, #status-tugas7, #status-tugas8, #status-tugas9, #status-tugas10, #status-tugas11, #status-tugas12, #status-tugas13, #status-tugas14');
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
        "ordering": false,
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 20,
        "info":     false,
        language: {
            search: '<i class="fas fa-search" aria-hidden="true"></i>',
            searchPlaceholder: "cari",
            "zeroRecords": "Record yang dicari tidak ditemukan",
        },
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
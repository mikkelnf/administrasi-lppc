@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/rapor.css') }}">
@endsection 

@section('title-window','Rapor Peserta')
@section('title','Rapor Peserta')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-rapor{{$data->tahun_angkatan}}-tab" href="/rapor/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
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
                            <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach
                        <a class="list-group-item list-group-item-action " id="nav-semester-tab" href="/rapor/angkatan/{{ $t_a }}/semester/rangkuman" aria-selected="true" target="_blank">Rangkuman</a>
                    @endif
                    @if( $skema->nama_skema == '3D Illustration Artist' )   
                        @foreach(range(1, 6) as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data) ? 'active' : '' }} {{ $data == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data }}-tab" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data }}" aria-controls="tugas-semeseter{{ $data }}" aria-selected="true">{{ $data }}</a>
                        @endforeach
                        <a class="list-group-item list-group-item-action" id="nav-semester-tab" href="/rapor/angkatan/{{ $t_a }}/semester/rangkuman" aria-selected="true" target="_blank">Rangkuman</a>
                    @endif
                </div>
            </div>
            <div class="cards">
                <ul class="nav nav-tabs menu-skema" role="tablist" id="mytab">
                    @if( $i_s < 7 )
                        @foreach( $skema_all as $data )
                            <li class="nav-item">
                                <a class="nav-link {{ request()->segment(5) == 's-0'.$data->id ? 'active' : '' }}" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $data->id }}/semester/{{ $i_s }}">{{ $data->nama_skema }}</a>
                            </li>
                        @endforeach
                    @endif
                    @if( $i_s > 6 )
                        <li class="nav-item">
                            <a class="nav-link active" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemas1->id }}/semester/{{ $i_s }}">{{ $skemas1->nama_skema }}</a>
                        </li>
                    @endif
                </ul>
                
                <div class="tab-content" id="nav-tabContent">

                    <div id="tabel-peserta">
                        <table class="table rounded" cellspacing="0" id="peserta">
                            <thead>
                                <tr>
                                    <th class="align-middle no" style="width: 10%;">No</th>
                                    <th class="align-middle npm" style="width: 25%;">NPM</th>
                                    <th class="align-middle nama" style="width: 55%;">Nama</th>
                                    <th class="align-middle aksi" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $raporp as $data )
                                    <tr class="position-relative"> 
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->peserta->npm_peserta }}</td>
                                        <td>{{ $data->peserta->nama_peserta }}</td>
                                        <td class="action">                          
                                            <a class="btn-link stretched-link" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $i_s }}/{{ $data->id }}" target="_blank">
                                                <span class="material-icons-outlined arrow">
                                                    chevron_right
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="info">
                            <hr>
                            <div class="alert d-flex">
                                <span class="material-icons-outlined info-icon">info</span>
                                <div class="info-text">
                                    Klik lihat Laporan untuk melihat data kelulusan rapor peserta {{ $t_a }} pada semester ini
                                </div>
                            </div>
                            <a href="/rapor/angkatan/{{ $t_a }}/semester/{{ $i_s }}/laporan" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
                        </div>
                    </div>
                    <div class="rapor-detail">
                        <div class="jenis">
                            <div class="judul">Semester Periode</div>
                            <div class="d-flex">
                                <div class="nama-semester">{{ $spa ? $spa : 'Isi semester periode' }}</div>
                                <div class="button-edit">
                                    <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#modaleditsemester">
                                        <span class="material-icons-outlined ip2">
                                            edit
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if( $skemacurrent_id == $skemas1->id )
                            @foreach( $rapor as $data )
                                <div class="jenis">
                                    <div class="judul">Pertemuan {{ $loop->iteration }}</div>
                                    <div class="d-flex">
                                        <div class="namadantugas">
                                            <div class="nama-pertemuan">{{ $data->nama_pertemuan ? $data->nama_pertemuan : 'Isi nama pertemuan' }}</div>
                                            <div class="d-flex">
                                                <div class="tugas">Tugas :</div>
                                                <div class="nama-tugas">{{ $data->nama_tugas ? $data->nama_tugas: '...' }}</div class="">
                                            </div>
                                        </div>
                                        <div class="button-edit">
                                            <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#modaleditpertemuan-{{ $data->id }}">
                                                <span class="material-icons-outlined ip2">
                                                    edit
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modaleditpertemuan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Pertemuan {{ $loop->iteration }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/rapor/angkatan/{{$t_a}}/skema/s-0{{ $skemacurrent_id }}/semester/{{$i_s}}/pertemuan/{{$data->id}}" method="POST" id="formeditpertemuan">
                                                @csrf
                                                <div class="modal-body modal-body-1">
                                                    <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                        <span class="success-text"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pertemuan" class="col col-form-label">Nama Pertemuan</label>
                                                        <input name="nama_pertemuan" type="text" class="form-control" id="nama_pertemuan" autocomplete="off" value="{{ $data->nama_pertemuan }}">
                                                        <small class="form-text text-muted">Contoh : Pengenalan SKKNI & Modeling Hardsurface (UK 08)</small>
                                                        <span class="text-danger error-text nama_pertemuan_error" role="alert"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_tugas" class="col col-form-label">Nama Tugas</label>
                                                        <input name="nama_tugas" type="text" class="form-control" id="nama_tugas" autocomplete="off" value="{{ $data->nama_tugas }}">
                                                        <small class="form-text text-muted">Contoh : Membuat Hardsurface : Model ruang tamu</small>
                                                        <span class="text-danger error-text nama_tugas_error" role="alert"></span>
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
                        @endif
                        @if( $skemacurrent_id == $skemad3->id )
                            @foreach( $rapord3 as $data )
                                <div class="jenis2">
                                    <div class="judul">Pertemuan {{ $loop->iteration }}</div>
                                    <div class="d-flex">
                                        <div class="namadantugas">
                                            <div class="nama-pertemuan">{{ $data->nama_pertemuan ? $data->nama_pertemuan : 'Isi nama pertemuan' }}</div>
                                            <div class="d-flex">
                                                <div class="tugas">Tugas :</div>
                                                <div class="nama-tugas">{{ $data->nama_tugas ? $data->nama_tugas: '...' }}</div class="">
                                            </div>
                                        </div>
                                        <div class="button-edit">
                                            <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#modaleditd3pertemuan-{{ $data->id }}">
                                                <span class="material-icons-outlined ip2">
                                                    edit
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modaleditd3pertemuan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Pertemuan {{ $loop->iteration }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/rapor/angkatan/{{$t_a}}/skema/s-0{{ $skemacurrent_id }}/semester/{{$i_s}}/pertemuan/{{$data->id}}" method="POST" id="formeditpertemuand3">
                                                @csrf
                                                <div class="modal-body modal-body-1">
                                                    <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                        <span class="success-text"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pertemuan" class="col col-form-label">Nama Pertemuan</label>
                                                        <input name="nama_pertemuand3" type="text" class="form-control" id="nama_pertemuan" autocomplete="off" value="{{ $data->nama_pertemuan }}">
                                                        <small class="form-text text-muted">Contoh : Pengenalan SKKNI & Modeling Hardsurface (UK 08)</small>
                                                        <span class="text-danger error-text nama_pertemuan_error" role="alert"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_tugas" class="col col-form-label">Nama Tugas</label>
                                                        <input name="nama_tugasd3" type="text" class="form-control" id="nama_tugas" autocomplete="off" value="{{ $data->nama_tugas }}">
                                                        <small class="form-text text-muted">Contoh : Membuat Hardsurface : Model ruang tamu</small>
                                                        <span class="text-danger error-text nama_tugas_error" role="alert"></span>
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
                        @endif
                    </div>

                    <div class="modal fade" id="modaleditsemester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Semester Periode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/rapor/angkatan/{{$t_a}}/semester/{{$i_s}}/semesterperiode" method="POST" id="formeditsemester">
                                    @csrf
                                    <div class="modal-body modal-body-1">
                                        <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                            <span class="success-text"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_semester" class="col col-form-label">Nama Semester</label>
                                            <input name="nama_semesterperiode" type="text" class="form-control" id="nama_semesterperiode" autocomplete="off" value="{{ $spa }}">
                                            <small class="form-text text-muted">Contoh : PTA 2020/2021</small>
                                            <span class="text-danger error-text nama_semesterperiode_error" role="alert"></span>
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
$(document).ready( function () {
    table = $('#peserta').DataTable({     
        "order": [[ 2, "asc" ]],
        "ordering": false,
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 25,
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

$(function(){
    $('#mytab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = "{{ url()->current() }}?skema=" + $(this).val();
        if (target) {
            window.location = target;
        }
        return false;
    });
});
</script>
        
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection
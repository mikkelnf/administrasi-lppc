@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/peserta-angkatan.css') }}">
@endsection 

@section('title-window','Peserta Kursus')
@section('title','Peserta Kursus')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-peserta{{$data->tahun_angkatan}}-tab" href="/peserta/angkatan/{{$data->tahun_angkatan}}" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
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
                <div class="card-control" id="card-control">
                    <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" data-toggle="modal" data-target="#modaltambahpeserta">
                        <span class="material-icons add">
                            add
                        </span>
                    </button>
                </div>
                <div class="modal fade" id="modaltambahpeserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peserta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('peserta.tambah', $t_a) }}" method="POST" id="formtambahpeserta">
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                        <span class="success-text"></span>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputnpm" class="col-sm-2 col-form-label">NPM</label>
                                        <div class="col-sm-4">
                                            <input name="npm" type="number" class="form-control" id="inputnpm" autocomplete="off">
                                            <span class="text-danger error-text npm_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputnama" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input name="nama" type="text" class="form-control" id="inputnama" autocomplete="off">
                                            <span class="text-danger error-text nama_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputno_telp" class="col-sm-2 col-form-label">No. Telp</label>
                                        <div class="col-sm-4">
                                            <input name="no_telp" type="number" class="form-control" id="inputno_telp" autocomplete="off">
                                            <span class="text-danger error-text no_telp_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputemail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input name="email" type="email" class="form-control" id="inputemail" autocomplete="off">
                                            <span class="text-danger error-text email_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputkelas" class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-3">
                                            <input name="kelas" type="text" class="form-control" id="inputkelas"  maxlength="5" autocomplete="off">
                                            <small id="emailHelp" class="form-text text-muted">Contoh : IA01</small>
                                            <span class="text-danger error-text kelas_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputangkatan" class="col-sm-2 col-form-label">Angkatan</label>
                                        <div class="col-sm-3">
                                            <input name="id_angkatan" type="text" class="form-control" id="inputangkatan" autocomplete="off" value="{{ $angkatan->id }}" hidden>
                                            <input type="text" class="form-control"autocomplete="off" placeholder="{{ $t_a }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputjurusan" class="col-sm-2 col-form-label">Jurusan</label>
                                        <div class="col-sm-7">
                                            <select class="form-control form-select" name="id_jurusan">
                                                @foreach($jurusan as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama_jurusan }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text id_jurusan_error" role="alert"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if($peserta->count() > 0)
                    <div id="tabel-peserta">
                        <table class="table" cellspacing="0" id="peserta">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th style="width: 7%;">NPM</th>
                                    <th style="width: 24%;">Nama</th>
                                    <th style="width: 11%;">No. Telp</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 7%;">Kelas</th>
                                    <th style="width: 7%;">Angkatan</th>
                                    <th style="width: 12%;">Jurusan</th>
                                    <th style="width: 7%;">Skema</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( $peserta as $data )
                                <tr> 
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->npm_peserta }}</td>
                                    <td>{{ $data->nama_peserta }}</td>
                                    <td>{{ $data->notelp_peserta == null ?  '-' : $data->notelp_peserta }}</td>
                                    <td>{{ $data->email_peserta == null ?  '-' : $data->email_peserta }}</td>
                                    <td>{{ $data->kelas_peserta == null ?  '-' :  $data->kelas_peserta }}</td>
                                    <td>{{ $data->angkatan->tahun_angkatan }}</td>
                                    <td>{{ $data->jurusan->nama_jurusan }}</td>
                                    <td>{{ $data->id_skema == null ?  '-' : 'S-0'.$data->id_skema }}</td>
                                    <td class="action">
                                        <div class="row">                              
                                        <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#edit-{{ $data->id }}">
                                            <span class="material-icons-outlined ip2">
                                                edit
                                            </span>
                                        </button>
                                        <div></div>
                                        <button type="button" class="btn btn-outline-danger btn-delete btn-ctrl" data-toggle="modal" data-target="#delete-{{ $data->id }}">
                                            <span class="material-icons-round ip2">
                                                delete_outline
                                            </span>
                                        </button>
                                        </div>  
                                    </td>
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
                    </div>
                @else
                    <div class="status">
                        <a>Tidak ada peserta pada angkatan ini</a>
                    </div>
                @endif
                @foreach( $peserta as $data )
                    <div class="modal fade edit-peserta" id="edit-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Peserta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/peserta/angkatan/{{ $t_a }}/edit/{{ $data->id }}" method="POST" id="formeditpeserta-{{ $data->id }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                            <span class="success-text"></span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputnpm" class="col-sm-2 col-form-label">NPM</label>
                                            <div class="col-sm-4">
                                                <input name="npm" type="number" class="form-control" id="inputnpm" autocomplete="off" value="{{ $data->npm_peserta }}">
                                                <span class="text-danger error-text npm_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputnama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input name="nama" type="text" class="form-control" id="inputnama" autocomplete="off" value="{{ $data->nama_peserta }}">
                                                <span class="text-danger error-text nama_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputno_telp" class="col-sm-2 col-form-label">No. Telp</label>
                                            <div class="col-sm-4">
                                                <input name="no_telp" type="number" class="form-control" id="inputno_telp" autocomplete="off" value="{{ $data->notelp_peserta }}">
                                                <span class="text-danger error-text no_telp_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputemail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input name="email" type="email" class="form-control" id="inputemail" autocomplete="off" value="{{ $data->email_peserta }}">
                                                <span class="text-danger error-text email_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputkelas" class="col-sm-2 col-form-label">Kelas</label>
                                            <div class="col-sm-3">
                                                <input name="kelas" type="text" class="form-control" id="inputkelas" autocomplete="off" value="{{ $data->kelas_peserta }}">
                                                <small id="kelasHelp" class="form-text text-muted">Contoh : IA01</small>
                                                <span class="text-danger error-text kelas_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputangkatan" class="col-sm-2 col-form-label">Angkatan</label>
                                            <div class="col-sm-3">
                                                <select class="form-control form-select" name="id_angkatan">
                                                    @foreach($angkatan_aktif as $angkatan)
                                                        <option value="{{ $angkatan->id }}" {{ $angkatan->tahun_angkatan == $t_a ? 'selected' : '' }}>{{ $angkatan->tahun_angkatan }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text id_angkatan_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputjurusan" class="col-sm-2 col-form-label">Jurusan</label>
                                            <div class="col-sm-7">
                                                <select class="form-control form-select" name="id_jurusan">
                                                    @foreach($jurusan as $jur)
                                                        <option value="{{ $jur->id }}" {{ $data->jurusan->id == $jur->id ? 'selected' : '' }}>{{ $jur->nama_jurusan }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text id_jurusan_error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputskema" class="col-sm-2 col-form-label">Skema</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-select" name="id_skema">
                                                    <option value="">-</option>
                                                    @foreach($skema as $skm)
                                                        <option value="{{ $skm->id }}" {{ $data->id_skema ? ($data->skema->id == $skm->id ? 'selected' : '') : '' }}>{{ $skm->nama_skema }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text id_skema_error" role="alert"></span>
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
                @foreach( $peserta as $data )
                    <div class="modal fade" id="delete-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Data Peserta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin menghapus "{{ $data->nama_peserta }}" ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>                           
                                <a href="/peserta/angkatan/{{ $t_a }}/hapus/{{ $data->id }}" class="btn btn-outline-danger">Ya</a>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(!$skema->count() == 0)
                <div class="info">
                    <hr>
                    <div class="alert d-flex">
                        <span class="material-icons-outlined info-icon">info</span>
                        <div class="info-text">
                                @foreach($skema as $data)
                                    Skema S-0{{ $data->id }} = {{ $data->nama_skema }} 
                                    <br>
                                @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
    @foreach( $peserta as $data )
        $("#formeditpeserta-{{$data->id}}").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success:function(data){
                    if(data.status==0){
                        $.each(data.error, function(prefix, val){
                            $('#formeditpeserta-{{$data->id}} span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        localStorage.setItem("Status-tambahsemester",data.OperationStatus)
                        window.location.reload(); 
                    }
                }
            })
        })
    @endforeach

    if(localStorage.getItem("Status-tambahsemester"))
    {
        $('#edit-alert').show();
        $(document).find('span.edit-success').text('Peserta berhasil diedit');
        localStorage.clear();
    }
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
        { "targets": 8, "sortable":false }
        ]
    });

    var x = $("#peserta_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    
    var target = $("#peserta_wrapper .row").first();
    var a = "<div class='col-sm-12 col-md-6 tambah'></div>";
    target.append(a);
    target.addClass('table-control');
    $("#peserta_wrapper .col-sm-12.col-md-6").first().addClass('cari');

    var target2 = $("#peserta_wrapper .tambah").first();
    var cardcontrol = $('#card-control');
    target2.append(cardcontrol);
    
    $('#peserta_wrapper .col-sm-12.col-md-5').remove();
});
</script>
    
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection 

@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/jadwal-menu.css') }}">
@endsection 

@section('title-window','Jadwal Kursus')
@section('title','Jadwal Kursus')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-jadwal{{$data->tahun_angkatan}}-tab" href="/jadwal-kursus/angkatan/{{$data->tahun_angkatan}}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
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

        <div class="alert alert-success collapse" role="alert" id="edit-alert">
            <span class="edit-success"></span>
        </div> 

        @if( $peserta->count() > 0)
            <div class="semester-aktif">
                Semester Aktif : {{ $angkatan->semester_aktif ? $angkatan->semester_aktif : '-' }}
            </div>
            <div class="border row">
                <div class="menu-semester">
                    <div class="list-group list-group-flush">
                        <a class="list-group-head">Semester</a>
                        @foreach($semester as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(5) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $data->id }}" aria-controls="jadwal-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach        
                    </div>
                </div>

                @if( $jadwal_kursus->count() > 0)
                    <div class="cards">
                        <div class="catatan">
                            <div class="catatan-box">
                                <div class="catatan-text">Catatan</div>
                                <div class="catatan-info">
                                    <a>
                                        {!! $catatan ? nl2br($catatan) : '----------' !!}
                                    </a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#modaleditcatatan">
                                <span class="material-icons-outlined icon-edit">
                                    edit
                                </span>
                            </button>
                        </div>
                        <div class="modal fade" id="modaleditcatatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit catatan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/catatan" method="POST" id="formeditcatatan">
                                        @csrf
                                        <div class="modal-body modal-body-catatan">
                                            <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                <span class="success-text"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputcatatan" class="col-form-label">Catatan</label>
                                                <div class="">
                                                    <textarea name="catatan" type="text" class="form-control" id="inputcatatan" rows="4">{{ $catatan }}</textarea>
                                                    <small class="form-text text-muted">Contoh : <br>
                                                        Pertemuan 1 : <br>
                                                        Pindah dari Selasa (13.00-16.00) ke Jumat (13.00-16.00): <br>
                                                        1. MUHAMMAD IRGI FIRMANSYAH (51421002) <br>
                                                        2. AZHAR AFDAL FATAMI (10121234)
                                                    </small>
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
                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                            @if($pesertabelumadajadwal->count() > 0)
                                <div class="card-control">
                                    <a class="tambah">Tambah Jadwal</a>
                                    <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" data-toggle="modal" data-target="#modaltambahjadwal">
                                        <span class="material-icons add">
                                            add
                                        </span>
                                    </button>
                                </div>
                            @endif
                        @endif
                        @if($pesertabelumadajadwal->count() == 0)
                            <div class="alert alert-warning" role="alert">
                                <span class="material-icons-round warning-icon d-flex justify-content-center">
                                    warning_amber
                                </span>
                                <span class="delete-success d-flex justify-content-center mr-auto ml-auto text-center warning">
                                    Semua peserta angkatan {{ $t_a }} sudah masuk ke dalam jadwal
                                </span>
                                <hr>
                                <small class="d-flex justify-content-center warning-info">Tidak dapat menambah jadwal baru</small>
                            </div>
                        @endif
                        <div id="daftar-jadwal">
                            <div class="row">
                                @foreach($jadwal_kursus as $data)
                                    <div class="col-sm-4">
                                        <div class="card card-jadwal">
                                            <div class="card-body">
                                                <div class="d-flex title">
                                                <h5 class="card-title">{{ $data->hari }} &nbsp; ({{ $data->jam }})</h5>
                                                @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                                    <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#modaleditjadwal-{{ $data->id }}">
                                                        <span class="material-icons-outlined ip2">
                                                            edit
                                                        </span>
                                                    </button>
                                                @endif
                                                </div>
                                                <hr>
                                                <p class="card-text">Jumlah Peserta : {{ $pesertadijadwal->where('id_jadwalkursus', $data->id)->count() }}</p>
                                                <p class="card-text">Link : {{ $data->link }}</p>
                                                <div class="detail">
                                                    @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#delete-{{ $data->id }}">Hapus</button>
                                                    @endif
                                                    <a class="btn btn-outline-primary" href="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/jadwal-{{ $data->id }}">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="delete-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Jadwal Kursus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin menghapus jadwal "{{ $data->hari }} &nbsp; ({{ $data->jam }})" ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>                           
                                                <a href="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/jadwal-{{ $data->id }}/hapus" class="btn btn-outline-danger">Ya</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="alert d-flex">
                                <span class="material-icons-outlined info-icon">info</span>
                                <div class="info-text">
                                    Hanya admin yang dapat mengelola jadwal kursus <br>
                                    <hr>
                                    Download pdf untuk mengunduh file jadwal kursus pada semester ini
                                </div>
                            </div>
                            <a href="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/semua-jadwal" class="btn btn-outline-success btn-pdf">Download pdf</a>
                        </div>
                    </div>
                    @foreach($jadwal_kursus as $data)
                        <div class="modal fade" id="modaleditjadwal-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Kursus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/edit/jadwal-{{ $data->id }}" method="POST" id="formeditjadwal-{{ $data->id }}">
                                        @csrf
                                        <div class="modal-body modal-body-1">
                                            <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                <span class="success-text"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputhari" class="col-sm-2 col-form-label">Hari</label>
                                                <div class="col-sm-5">
                                                    <select class="form-control form-select" name="hari">
                                                        <option value="Senin">Senin</option>
                                                        <option value="Selasa">Selasa</option>
                                                        <option value="Rabu">Rabu</option>
                                                        <option value="Kamis">Kamis</option>
                                                        <option value="Jumat">Jumat</option>
                                                        <option value="Sabtu">Sabtu</option>
                                                    </select>
                                                    <span class="text-danger error-text hari_error" role="alert"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputjam" class="col-sm-2 col-form-label">Jam</label>
                                                <div class="col-sm-5">
                                                    <input name="jam" type="text" class="form-control" id="inputjam" autocomplete="off" value="{{ $data->jam }}">
                                                    <small class="form-text text-muted">Contoh : 12:30 - 15:30</small>
                                                    <span class="text-danger error-text jam_error" role="alert"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputlink" class="col-sm-2 col-form-label">Link</label>
                                                <div class="col-sm-8">
                                                    <input name="link" type="text" class="form-control" id="inputlink" autocomplete="off" value="{{ $data->link }}">
                                                    <small class="form-text text-muted">Contoh : bit.ly/Animasi-Angkatan2017</small>
                                                    <span class="text-danger error-text link_error" role="alert"></span>
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
                @else
                    <div class="cards">
                        <div class="card-control">
                            @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                <a class="tambah">Tambah Jadwal</a>
                                <button type="button" class="btn btn-tambah btn-ctrl btn-outline-secondary" data-toggle="modal" data-target="#modaltambahjadwal">
                                    <span class="material-icons add">
                                        add
                                    </span>
                                </button>
                            @endif
                        </div>
                        <a class="jadwal-kosong">Belum ada jadwal di semester ini</a>
                        <div class="info">
                            <hr>
                            <div class="alert d-flex">
                                <span class="material-icons-outlined info-icon">info</span>
                                <div class="info-text">
                                    Hanya admin yang dapat mengelola jadwal kursus
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="modal fade" id="modaltambahjadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Kursus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/tambah" method="POST" id="formtambahjadwal">
                                @csrf
                                <div class="modal-body modal-body-1">
                                    <div class="alert alert-success collapse" role="alert" id="success-alerts-tambah">
                                        <span class="success-text-tambah"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputhari" class="col-sm-2 col-form-label">Hari</label>
                                        <div class="col-sm-5">
                                            <select class="form-control form-select" name="hari">
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                            </select>
                                            <span class="text-danger error-text hari_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputjam" class="col-sm-2 col-form-label">Jam</label>
                                        <div class="col-sm-5">
                                            <input name="jam" type="text" class="form-control" id="inputjam" autocomplete="off">
                                            <small class="form-text text-muted">Contoh : 12:30 - 15:30</small>
                                            <span class="text-danger error-text jam_error" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputlink" class="col-sm-2 col-form-label">Link</label>
                                        <div class="col-sm-8">
                                            <input name="link" type="text" class="form-control" id="inputlink" autocomplete="off">
                                            <small class="form-text text-muted">Contoh : bit.ly/Animasi-Angkatan2017</small>
                                            <span class="text-danger error-text link_error" role="alert"></span>
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
            </div>
        @else
            <div class="card card-status">
                <div class="status">
                    <a>Tidak ada peserta pada angkatan ini</a>
                </div>
            </div>
        @endif
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
<script type="text/javascript" src="{{ asset('js') }}/jadwal-kursus.js"></script>
<script type="text/javascript">
@foreach( $jadwal_kursus as $data )
    $("#formeditjadwal-{{$data->id}}").on('submit', function(e){
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
                        $('#formeditjadwal-{{$data->id}} span.'+prefix+'_error').text(val[0]);
                    });
                }else{
                    $('#modaleditjadwal-{{ $data->id }}').modal('toggle');
                    $("#daftar-jadwal").load( "/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }} #daftar-jadwal" );
                    const $msg = (data.msg);
                    $(document).find('#edit-alert').show();
                    $(document).find('span.edit-success').text($msg);
                }
            }
        })
    })
@endforeach
</script>
@endsection
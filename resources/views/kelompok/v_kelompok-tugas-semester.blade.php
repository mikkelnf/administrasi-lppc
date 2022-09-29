@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelompok-tugas.css') }}">
@endsection 

@section('title-window','Kelompok Asistensi')
@section('title','Kelompok Asistensi')
       
@section('content')
<div class="page-content">
    <div class="asisten d-flex">
        <div class="asisten-pendamping">Asisten</div>
        <div class="nama-asisten">{{$asisten->nama_user}}</div>
    </div>
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
            <a class="nav-item nav-link {{ request()->segment(4) == 'peserta' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/peserta" aria-controls="" aria-selected="true">
                Peserta
            </a>
            <a class="nav-item nav-link {{ request()->segment(4) == 'kehadiran' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/kehadiran/semester/" aria-controls="" aria-selected="true">
                Kehadiran
            </a>
            <a class="nav-item nav-link {{ request()->segment(4) == 'tugas' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/tugas/semester/" aria-controls="" aria-selected="true">
                Tugas
            </a>
        </div>
    </nav>
    
    @if(session('pesan'))
        <div class="alert alert-success" role="alert" id="edit-alert">
            <span class="edit-success">{{ session('pesan')}}</span>
        </div> 
    @endif

    @if($peserta_kelompok->count() > 0)
        <div class="border row">
            <div class="menu-semester">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Semester</a>
                    @foreach($semester_all as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(6) == ($data->id) ? 'active' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/kelompok-asistensi/asisten/{{$user->id}}/tugas/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach        
                </div>
            </div>
        
            <div class="cards">
                <div id="detail-tugas">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingone">
                            <div class="collapsed detail" role="button" data-toggle="collapse" data-parent="#accordion" href="#tugas" aria-expanded="true" aria-controls="tugas">
                                <img class="icon" src="{{ asset('img') }}/outline_info_black_48dp.png">
                                <a>Detail Tugas</a>
                                <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
                            </div>
                            <button type="button" class="btn tugas-setting" data-toggle="modal" data-target="#edit-detail">
                                <img class="setting" src="{{ asset('img') }}/outline_settings_black_48dp.png">
                            </button>
                        </div>
                        <div id="tugas" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingone">
                            <div class="panel-body">
                                <div class="d-flex align-content-stretch flex-wrap justify-content-center isi">
                                    @foreach($detail_tugas as $data)
                                        <div class="a">
                                            <div class="nomor-tugas">
                                                Tugas ke-{{$data->nomor_tugas}}
                                            </div>
                                            <div class="nama-tugas">
                                                <a>{{ $data->nama_tugas ? $data->nama_tugas : '-' }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade edit-detail" id="edit-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Detail Tugas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/kelompok-asistensi/asisten/{{ $user->id }}/tugas/semester/{{ $i_s }}" method="POST" id="formeditdetail">
                                @csrf
                                <div class="modal-body">
                                    <div class="semester">Semester : {{ $i_s }}</div>
                                    <hr>
                                    <div class="row d-flex justify-content-center text-center">
                                        <div class="row-1">
                                            @for($i=1; $i<6; $i++)
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-form-label">Tugas ke-{{ $i }}</label>
                                                    <div class="nama-tugas">
                                                        <input name="tugas{{ $i }}" type="text" class="form-control" autocomplete="off" value="{{ $detail_tugas->where('nomor_tugas', $i)->first()->nama_tugas }}">
                                                        <span class="text-danger error-text tugas1_error" role="alert"></span>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="row-2">
                                            @for($i=6; $i<11; $i++)
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-form-label">Tugas ke-{{ $i }}</label>
                                                    <div class="nama-tugas">
                                                        <input name="tugas{{ $i }}" type="text" class="form-control" autocomplete="off" value="{{ $detail_tugas->where('nomor_tugas', $i)->first()->nama_tugas }}">
                                                        <span class="text-danger error-text tugas6_error" role="alert"></span>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>                                    
                                    <small class="form-text text-muted">Contoh : Form UK-01/Cerita/Previs/Blender</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div id="tabel-peserta">
                        <table class="table" cellspacing="0" id="peserta">
                            <thead>
                                <tr>
                                    <th class="align-middle no" style="width: 4%;" rowspan="2">No</th>
                                    <th class="align-middle npm" style="width: 8%;" rowspan="2">NPM</th>
                                    <th class="align-middle nama" style="width: 27%;" rowspan="2">Nama</th>
                                    <th class="tugas-pertemuan" colspan="10">
                                        Tugas ke-
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
                                    <form action="/kelompok-asistensi/asisten/{{ $user->id }}/tugas/semester/{{ $i_s }}/edit/{{ $data->id_peserta }}" method="POST" id="formedittugas-{{ $data->id }}">
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
            </div>
        </div>
    @else
        <div class="card">
            <div class="status">
                <a>Tidak ada peserta pada kelompok ini</a>
            </div>
        </div>
    @endif
</div>
@endsection  

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
<script type="text/javascript">
    var sel = document.querySelectorAll('#status-tugas1, #status-tugas2, #status-tugas3, #status-tugas4, #status-tugas5, #status-tugas6, #status-tugas7, #status-tugas8, #status-tugas9, #status-tugas10');
    sel.forEach(function(el){
        el.addEventListener('change', function(){
            el.classList.remove("hijau");
            el.classList.remove("merah");
            el.classList.add(el.options[el.selectedIndex].className);
        });
    });
</script>
@endsection
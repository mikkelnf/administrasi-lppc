@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/evaluasitugas.css') }}">
@endsection 

@section('title-window','Evaluasi Tugas Peserta')
@section('title','Evaluasi Tugas Peserta')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(4) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-tugas{{$data->tahun_angkatan}}-tab" href="/evaluasi/tugas/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/modul/" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
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

        <div class="border row">
            <div class="menu-semester">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Modul</a>
                    @if( $skema->nama_skema == 'Pembuat Ide Gerak & Cerita (Generalist)' )
                        @foreach($semester_all as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(8) == ($data->id) ? 'active' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/modul/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach
                    @endif
                    @if( $skema->nama_skema == '3D Illustration Artist' )   
                        @foreach(range(1, 6) as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(8) == ($data) ? 'active' : '' }}" id="nav-semester{{ $data }}-tab" href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/modul/{{ $data }}" aria-controls="tugas-semeseter{{ $data }}" aria-selected="true">{{ $data }}</a>
                        @endforeach
                    @endif      
                </div>
            </div>
        
            <div class="cards">
                <ul class="nav nav-tabs menu-skema" role="tablist" id="mytab">
                    @if( $i_s == 1 || $i_s == 2 || $i_s == 3 || $i_s == 4 || $i_s == 5 || $i_s == 6 )
                        @foreach( $skema_all as $data )
                            <li class="nav-item">
                                <a class="nav-link {{ request()->segment(6) == 's-0'.$data->id ? 'active' : '' }}" href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $data->id }}/modul/{{ $i_s }}">{{ $data->nama_skema }}</a>
                            </li>
                        @endforeach
                    @endif
                    @if( $i_s == 7 || $i_s == 8 )
                        <li class="nav-item">
                            <a class="nav-link active" href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemas1->id }}/modul/{{ $i_s }}">{{ $skemas1->nama_skema }}</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="nav-tabContent">
                    <div class="table-responsive" id="tabel-peserta">
                        <table class="table" style="width: {{ $detail->count() > 5 ? '2000px' : '1000' }}" id="peserta" data-toggle="table" data-pagination="true" data-show-columns="true" data-height="500" data-toolbar="#toolbar">
                            <thead class=result_table_header>
                                <tr>
                                    @if( $skema->nama_skema == '3D Illustration Artist' )
                                        @if( $i_s == 1 )
                                            <th colspan="3"></th>
                                            <th colspan="2">Folder Modul 1.1 (UK-01)</th>
                                            <th colspan="2">Folder Modul 1.2 (UK-03)</th>
                                            <th colspan="2">Folder Modul 1.3 (UK-06)</th>
                                            <th colspan="2">Folder Modul 1.4 (UK-19)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 2 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 2.1 (UK-36)</th>
                                            <th>Folder Modul 2.2 (UK-40)</th>
                                            <th>Folder Modul 2.3 (UK-34)</th>
                                            <th>Folder Modul 2.4 (UK-38)</th>
                                            <th>Folder Modul 2.5 (UK-35)</th>
                                            <th>Folder Modul 2.6 (UK-39)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 3 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 3.1 (UK-04)</th>
                                            <th>Folder Modul 3.2 (UK-08)</th>
                                            <th>Folder Modul 3.3 (UK-09)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 4 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 4.1 (UK-07)</th>
                                            <th>Folder Modul 4.2 (UK-11)</th>
                                            <th>Folder Modul 4.3 (UK-12)</th>
                                            <th>Folder Modul 4.4 (UK-13)</th>
                                            <th>Folder Modul 4.5 (UK-20)</th>
                                            <th>Folder Modul 4.6 (UK-31)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 5 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 5.1 (UK-15)</th>
                                            <th>Folder Modul 5.2 (UK-14)</th>
                                            <th>Folder Modul 5.3 (UK-21)</th>
                                            <th>Folder Modul 5.4 (UK-23)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 6 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 6.1 (UK-43)</th>
                                            <th></th>
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
                                            <th></th>
                                        @endif
                                        @if( $i_s == 2 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 2.1 (UK-36)</th>
                                            <th>Folder Modul 2.2 (UK-40)</th>
                                            <th>Folder Modul 2.3 (UK-34)</th>
                                            <th>Folder Modul 2.4 (UK-38)</th>
                                            <th>Folder Modul 2.5 (UK-35)</th>
                                            <th>Folder Modul 2.6 (UK-39)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 3 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 3.1 (UK-05)</th>
                                            <th>Folder Modul 3.2 (UK-16)</th>
                                            <th>Folder Modul 3.3 (UK-18)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 4 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 4.1 (UK-08)</th>
                                            <th>Folder Modul 4.2 (UK-09)</th>
                                            <th>Folder Modul 4.3 (UK-17)</th>
                                            <th>Folder Modul 4.4 (UK-04)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 5 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 5.1 (UK-07)</th>
                                            <th>Folder Modul 5.2 (UK-11)</th>
                                            <th>Folder Modul 5.3 (UK-12)</th>
                                            <th>Folder Modul 5.4 (UK-13)</th>
                                            <th>Folder Modul 5.5 (UK-20)</th>
                                            <th>Folder Modul 5.6 (UK-31)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 6 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 6.1 (UK-15)</th>
                                            <th>Folder Modul 6.2 (UK-14)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 7 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 7.1 (UK-24)</th>
                                            <th>Folder Modul 7.2 (UK-26)</th>
                                            <th></th>
                                        @endif
                                        @if( $i_s == 8 )
                                            <th colspan="3"></th>
                                            <th>Folder Modul 8.1 (UK-43)</th>
                                            <th>Folder Modul 8.2 (UK-44)</th>
                                            <th>Folder Modul 8.3 (UK-45)</th>
                                            <th></th>
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
                                    <th style="width: 80px !important">Aksi</th>
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
                                    <td class="action">                          
                                        <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#edit-{{ $data->id }}">
                                            <span class="material-icons-outlined ip2">
                                                edit
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>                              
                    </div>
                    @foreach( $pesertaskema as $data )
                        <div class="modal fade edit-peserta" id="edit-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Tugas Peserta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/modul/{{ $i_s }}/edit/{{ $data->id }}" method="POST" id="formedittugas-{{ $data->id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="semester">Modul : {{ $i_s }}</div>
                                            <div class="nama-peserta">{{ $data->nama_peserta }}</div>
                                            <hr>
                                            <div class="text-center">
                                                @foreach ($detail as $dtl)
                                                    @if( $skema->nama_skema == '3D Illustration Artist' )
                                                        @if( $i_s == 1 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 2 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+8)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+8 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+8)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+8)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 3 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+14 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 4 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+17)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+17 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+17)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+17)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 5 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+23 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 6 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+27 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasid3->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                    @else
                                                        @if( $i_s == 1 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 2 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+14 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+14)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 3 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+20)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+20 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+20)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+20)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 4 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+23 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+23)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 5 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+27 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+27)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif    
                                                        @if( $i_s == 6 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+33)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+33 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+33)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+33)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if( $i_s == 7 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+35)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+35 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+35)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+35)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if( $i_s == 8 )
                                                            <div class="form-group row">
                                                                <label class="col-sm-7 col-form-label">{{ $dtl->nama_tugas ? $dtl->nama_tugas : 'Tugas-'.$loop->iteration }}</label>
                                                                <div class="col-sm-4 ml-auto">
                                                                    <select class="form-control form-select {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+37)->first() ? 'merah' : 'hijau' }}" name={{ $loop->iteration+37 }} id="status-tugas{{ $loop->iteration }}">
                                                                        <option class="hijau" value="selesai" {{ $evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+37)->first() ? 'selected' : '' }}>Selesai</option>
                                                                        <option class="merah" value="" {{ !$evaluasis1->where('id_peserta', $data->id)->where('id_tugas', $loop->iteration+37)->first() ? 'selected' : '' }}>---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif 
                                                @endforeach                                
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
                    <a href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/modul/{{ $i_s }}/laporan" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
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
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
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
        "pageLength": 15,
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
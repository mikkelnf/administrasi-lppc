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
                    <a class="nav-item nav-link {{ request()->segment(4) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-tugas{{$data->tahun_angkatan}}-tab" href="/evaluasi/tugas/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/modul/" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
                        Angkatan {{$data->tahun_angkatan}}
                    </a>
                @endforeach
            </div>
        </nav>

        @if( $peserta->count() > 0)
            <div class="border row">
                <div class="menu-semester">
                    <div class="list-group list-group-flush">
                        <a class="list-group-head">Modul</a>
                        @foreach($semester as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(8) == ($data->id) ? 'active' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/evaluasi/tugas/angkatan/{{ $t_a }}/skema/s-0{{ $skemafirst_id }}/modul/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach        
                    </div>
                </div>
                <div class="cards">
                    <a class="pilih-semester">Pilih Modul</a>
                </div>
            </div>
        @else
            <div class="card">
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
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection 

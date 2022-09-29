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
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-rapor{{$data->tahun_angkatan}}-tab" href="/rapor/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
                        Angkatan {{$data->tahun_angkatan}}
                    </a>
                @endforeach
            </div>
        </nav>

        @if( $peserta->count() > 0)
            <div class="semester-aktif">
                Semester Aktif : {{ $angkatan->semester_aktif ? $angkatan->semester_aktif : '-' }}
            </div>
            <div class="border row">
                <div class="menu-semester">
                    <div class="list-group list-group-flush">
                        <a class="list-group-head">Semester</a>
                        @foreach($semester as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(5) == ($data->id) ? 'active' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemafirst_id }}/semester/{{ $data->id }}" aria-controls="rapor-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach        
                    </div>
                </div>
                <div class="cards">
                    <a class="pilih-semester">Pilih Semester </a>
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
<script type="text/javascript" src="{{ asset('js') }}/peserta.js"></script>
@endsection 

@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/jadwal-asisten.css') }}">
@endsection 

@section('title-window','Jadwal Asisten')
@section('title','Jadwal Asisten')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
                @foreach($s_periode as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->id) ? 'active' : '' }}" href="/jadwal-asisten/semester/{{ $data->id }}/pertemuan" aria-selected="true">
                        {{$data->nama_semesterperiode}}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="border row">
            <div class="menu-pertemuan">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Pertemuan</a>
                    @foreach($pertemuan as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(5) == ($data->id) ? 'active' : '' }}" id="nav-pertemuan{{ $data->id }}-tab" href="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $data->id }}" aria-controls="jadwal-pertemuan{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach        
                </div>
            </div>
        
            <div class="cards">
                <a class="pilih-semester">Pilih Pertemuan</a>
            </div>
        </div>
    </div>
@else
    <div class="page-content">
        <div class="card">
            <div class="status">
                <a>Semester {{ $n_s }} tidak dapat diolah karena berstatus Tidak Aktif</a>
            </div>
        </div>
    </div>
@endif
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/peserta.js"></script>
@endsection 

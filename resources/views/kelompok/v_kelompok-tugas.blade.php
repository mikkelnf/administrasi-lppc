@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelompok-tugas.css') }}">
@endsection 

@section('title-window','Kelompok Asistensi')
@section('title','Kelompok Asistensi')
       
@section('content')
<div class="page-content">
    <div class="d-flex">
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

    @if($peserta_kelompok->count() > 0)
        <div class="border row">
            <div class="menu-semester">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Semester</a>
                    @foreach($semester as $data)
                    <a class="list-group-item list-group-item-action {{ request()->segment(6) == ($data->id) ? 'active' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/kelompok-asistensi/asisten/{{$user->id}}/tugas/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
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
                <a>Tidak ada peserta pada kelompok ini</a>
            </div>
        </div>
    @endif
</div>
@endsection  

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection
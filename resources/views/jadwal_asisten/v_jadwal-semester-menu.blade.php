@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection 

@section('title-window','Jadwal Asisten')
@section('title','Jadwal Asisten')

@section('content')
<div class="page-content">
    @if($s_periode->count() > 0)
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
            @foreach($s_periode as $data)
            <a class="nav-item nav-link" href="/jadwal-asisten/semester/{{$data->id}}/pertemuan" aria-controls="semester{{$data->id_angkatan}}" aria-selected="true">
                {{$data->nama_semesterperiode}}
            </a>
            @endforeach
        </div>
    </nav>

    <div class="text-center justify-content-center pilih">
        Pilih Semester
    </div>
    
    @else
    <div class="card">
        <div class="status">
            <a>Tidak ada semester yang aktif</a>
        </div>
    </div>
    @endif
    
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection 
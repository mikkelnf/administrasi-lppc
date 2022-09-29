@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection 

@section('title-window','Jadwal Kursus')
@section('title','Jadwal Kursus')

@section('content')
<div class="page-content">
    @if($angkatan_aktif->count() > 0)
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
                @foreach($angkatan_aktif as $data)
                    <a class="nav-item nav-link" href="/jadwal-kursus/angkatan/{{$data->tahun_angkatan}}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
                        Angkatan {{$data->tahun_angkatan}}
                    </a>
                @endforeach
            </div>
        </nav>
        <div class="text-center justify-content-center pilih">
            Pilih Angkatan 
        </div>
    @else
        <div class="card">
            <div class="status">
                <a>Tidak ada angkatan yang aktif</a>
            </div>
        </div>
    @endif
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection 
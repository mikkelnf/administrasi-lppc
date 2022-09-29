@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelompok.css') }}">
@endsection 

@section('title-window','Kelompok Asistensi')
@section('title','Kelompok Asistensi')
       
@section('content')
<div class="page-content">
    @if($asisten->count() > 0)
        <div class="content-header">Daftar Kelompok</div>
        <div class="row">
            @foreach($asisten as $ast)
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ast->nama_user }}</h5>
                            <hr>
                            <p class="card-text">Jumlah Peserta : {{$ast->peserta()->whereIn('id_angkatan', $angkatan_aktif)->count()}}</p>
                            <div class="detail">
                                <a class="btn btn-outline-primary stretched-link" href="/kelompok-asistensi/asisten/{{ $ast->id }}/peserta">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="info-text info-jml">
            Jumlah peserta yang belum masuk kelompok : {{ $peserta->count() }}
        </div>
        <hr>
        <div class="alert d-flex">
            <span class="material-icons-outlined info-icon">info</span>
            <div class="info-text">
                Setiap kelompok memiliki peserta yang dapat diolah kehadiran dan tugasnya, 
                <br>
                Hanya dapat mengolah peserta dari angkatan berstatus aktif
            </div>
        </div>
    @else
        <div class="content-header">Tidak ada asisten untuk dijadikan sebagai kelompok</div>
        <div class="info-text info-jml">
            Jumlah peserta yang belum masuk kelompok : {{ $peserta->count() }}
        </div>
        <hr>
        <div class="alert d-flex">
            <span class="material-icons-outlined info-icon">info</span>
            <div class="info-text">
                Setiap kelompok memiliki peserta yang dapat diolah kehadiran dan tugasnya, 
                <br>
                Hanya dapat mengolah peserta dari angkatan berstatus aktif
            </div>
        </div>
    @endif
</div>
@endsection  

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection

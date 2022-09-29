@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection 

@section('title-window','Rapor Peserta')
@section('title','Rapor Peserta')

@section('content')
<div class="page-content">
    @if($angkatan_aktif->count() > 0)
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
                @foreach($angkatan_aktif as $data)
                    <a class="nav-item nav-link" href="/rapor/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skema_id }}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}" aria-selected="true">
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
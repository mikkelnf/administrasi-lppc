@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/asisten.css') }}">
@endsection 

@section('title-window','Asisten Lab')
@section('title','Staff Laboratorium')
       
@section('content')
@if($staff->count() > 0)
<div class="page-content">
    <div class="content-header">Daftar Staff Aktif</div>
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100 ver2">
                    <div class="table100-head">
                        <table class="table">
                            <thead>
                                <tr class="row100 head">
                                    <th class="cell100 column1">No</th>
                                    <th class="cell100 column2">Nama</th>
                                    <th class="cell100 column3">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table100-body">
                        <table class="table">
                            <tbody>
                                @foreach ($staff as $data)
                                    @if(!$data->status == null)
                                        <tr class="row100 body">
                                            <td class="cell100 column1">{{ $loop->index }}</td>
                                            <td class="cell100 column2">{{ $data->nama_user }}</td>
                                            <td class="cell100 column3">{{ $data->status }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="page-content">
    <div class="card">
        <div class="status">
            <a>Tidak ada staff yang aktif</a>
        </div>
    </div>
</div>
@endif
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/4.js"></script>
@endsection 
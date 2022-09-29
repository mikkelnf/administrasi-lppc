@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/berkas.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection 

@section('title-window','Berkas-berkas')
@section('title','Berkas-berkas')

@section('content')
<div class="page-content">
    <div class="file-manager" style="height: 700px;">
        <div id="fm"></div>
    </div>
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/berkas.js"></script>
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection 


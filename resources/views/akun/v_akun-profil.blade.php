@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/akun.css') }}">
@endsection 

@section('title-window','Akun')
@section('title','Akun')
       
@section('content')
<div class="page-content">
    <div class="content-header">Ubah Profil</div>
    <div class="profil row">
        <div class="profil-menu">
            <div class="list-group list-group-flush">
                <a href="/akun/profil" class="list-group-item list-group-item-action {{ request()->is('akun/profil') ? 'active' : ''}}">
                    <span class="material-icons-outlined account-icon">
                        account_circle
                    </span>
                    Profil
                </a>
                <a href="/akun/password" class="list-group-item list-group-item-action {{ request()->is('akun/password') ? 'active' : ''}}">
                    <span class="material-icons-outlined password-icon">
                        lock
                    </span>
                    Password
                </a>
            </div>
        </div>

        <div class="profil-content">
            <div id="profil">
                <div class="profile-icon">
                    <span class="material-icons">
                        account_circle
                    </span>
                </div>
                <div class="nama">{{ auth()->user()->nama_user }}</div>
                <div class="role">Role : {{ auth()->user()->roles->nama_role }}</div>
                <hr class="profil-divider">
                <div class="user-info">
                    <form action="/akun/profil/edit-{{ auth()->user()->id }}" method="post" id="form-editprofil">
                        @csrf
                        <div class="alert alert-success collapse" role="alert" id="success-alert-profil">
                            <span class="success-text"></span>
                        </div>
                        @if(session('pesan-akun'))
                        <div class="alert alert-success" role="alert">
                            <span class="delete-success">{{ session('pesan-akun')}}</span>
                        </div>
                        @endif 
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input name="nama" class="form-control" id="disabledInput" type="text" value="{{ auth()->user()->nama_user }}">
                            <span class="text-danger error-text nama_error" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input name="username" class="form-control" id="disabledInput" type="text" value="{{ auth()->user()->username }}">
                            <span class="text-danger error-text username_error" role="alert"></span>
                        </div>
                        <button type="submit" class="btn btn-outline-primary profil-btn" data-toggle="modal" data-target="#profil-id">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/akun.js"></script>
@endsection 
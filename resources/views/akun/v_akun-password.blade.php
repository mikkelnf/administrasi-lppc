@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/akun.css') }}">
@endsection 

@section('title-window','Ubah Password')
@section('title','Akun')
       
@section('content')
<div class="page-content">
    <div class="content-header">Ubah Password</div>
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
            <div class="profile-icon">
                <span class="material-icons">
                    account_circle
                </span>
            </div>
            <div class="nama">{{ auth()->user()->nama_user }}</div>
            <div class="role">Role : {{ auth()->user()->roles->nama_role }}</div>
            <hr class="profil-divider">
            <div class="user-info">
                <form action="/akun/password/edit-{{ auth()->user()->id }}" method="post" id="form-editpassword">
                    @csrf
                    @method("PATCH")
                    <div class="alert alert-success collapse" role="alert" id="success-alert-profil">
                        <span class="success-text"></span>
                    </div>
                    @if(session('pesan-akun'))
                        <div class="alert alert-success" role="alert">
                            <span class="success-text">{{ session('pesan-akun')}}</span>
                        </div>
                    @endif
                    @if(session('pesan-password-error'))
                        <div class="alert alert-danger" role="alert">
                            <span class="error-text">{{ session('pesan-password-error')}}</span>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="old_password">Password Lama</label>
                        <input type="password" name="old_password" class="form-control" id="old_password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off">
                        <span class="text-danger error-text nama_error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" autocomplete="off">
                        <span class="text-danger error-text nama_error" role="alert"></span>
                    </div>
                    <button type="submit" class="btn btn-outline-primary profil-btn">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/akun.js"></script>
@endsection 
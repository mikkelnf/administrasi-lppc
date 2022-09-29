@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection 

@section('title-window','Beranda')
@section('title','Beranda')
       
@section('content')
<div class="page-content">
    <div class="card-menus justify-content-around row">
        <div class="card total-peserta media position-relative">
            <div class="card-body">
                <div class="row">
                    <span class="material-icons-outlined icon">
                        groups
                    </span>
                    <div class="media-body">
                        <h6 class="" style="font-size: 14px; color: #e7e7e7; margin-bottom:15px;">Total Peserta Kursus</h6>
                        <a href="/peserta" class="stretched-link" style="color: #fcfcfc;">{{ $jml_peserta_aktif }}</a>
                        <a href="/peserta" class="stretched-link" style="color: #fcfcfc;"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card total-staff media position-relative">
            <div class="card-body">
                <div class="row">
                    <span class="material-icons-outlined icon">
                        people
                    </span>
                    <div class="media-body">
                        <h6 class="" style="font-size: 14px; color: #e7e7e7; margin-bottom:15px;">Total Staff Aktif</h6>
                        <a href="/staff" class="stretched-link" style="color: #fcfcfc;">{{ $jml_user }}</a>
                        <a href="/staff" class="stretched-link" style="color: #fcfcfc;"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card kursus media position-relative">
            <div class="card-body">
                <div class="row">
                    <span class="material-icons-outlined icon">
                        auto_stories
                    </span>
                    <div class="media-body">
                        <h6 class="" style="font-size: 14px; color: #e7e7e7; margin-bottom:15px;">Kursus saat ini</h6>
                        @if($semesterberjalan->id_semesterperiode == null)
                        <a href="#" class="stretched-link" style="color: #fcfcfc;">
                            {{ $semesterberjalan_nama }}
                        </a>
                        @else
                        <a href="/jadwal-asisten/semester/{{ $semesterberjalan_id }}/pertemuan" class="stretched-link" style="color: #fcfcfc;">
                            {{ $semesterberjalan_nama }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="home-divider">
    <div class="second-title">
        Menu Utama
    </div>
    <div class="row second-part">
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            people
                        </span>
                        Peserta Kursus
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span>                      
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola data peserta berdasarkan angkatan aktif
                        <a class="btn btn-outline-link stretched-link" href="/peserta/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            list_alt
                        </span>
                        Kehadiran Peserta
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola data kehadiran peserta 
                        <a class="btn btn-outline-link stretched-link" href="/kehadiran/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            assignment
                        </span>
                        Tugas Peserta
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola data tugas peserta 
                        <a class="btn btn-outline-link stretched-link" href="/tugas/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            summarize
                        </span>
                        Rapor Peserta
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola rapor peserta tiap semesternya
                        <a class="btn btn-outline-link stretched-link" href="/rapor/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            fact_check
                        </span>
                        Kelulusan Peserta
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Melihat data kelulusan peserta 
                        <a class="btn btn-outline-link stretched-link" href="/kelulusan-peserta/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            insert_drive_file
                        </span>
                        Berkas-berkas
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola berkas-berkas terkait kursus
                        <a class="btn btn-outline-link stretched-link" href="/berkas"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            schedule
                        </span>
                        Jadwal Kursus
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola jadwal kursus dari semua angkatan aktif
                        <a class="btn btn-outline-link stretched-link" href="/jadwal-kursus/angkatan"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            schedule
                        </span>
                        Jadwal Asisten
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Mengelola jadwal asisten berdasarkan jadwal kursus
                        <a class="btn btn-outline-link stretched-link" href="/jadwal-asisten/semester"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            cloud
                        </span>
                        Gdrive Asisten
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Folder gdrive laboratorium
                        <a class="btn btn-outline-link stretched-link" href="https://drive.google.com/drive/u/2/folders/12p6-C5s4e2cwlM23SEoPpHHPs0p6xdQo" target="_blank"></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="card">
                <div class="card-body">
                    <a class="card-title">
                        <span class="material-icons-outlined icon">
                            cloud
                        </span>
                        Gdrive Peserta
                        <span class="material-icons-outlined arrow">
                            navigate_next
                        </span> 
                    </a>
                    <hr>
                    <p class="card-text">
                        Folder gdrive tugas dari tiap peserta
                        <a class="btn btn-outline-link stretched-link" href="https://drive.google.com/drive/folders/12vwjtoj7uuGae_kiKZp_YqmnLxLcS_JN?usp=sharing" target="_blank"></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
@endsection 
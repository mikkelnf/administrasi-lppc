<div class="sidebarmenu" style="border-top: 1px solid rgba(0, 0, 0, 0.22);">
    <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('/') ? 'activemenu' : 'inactivemenu'}}" href="/">
            <img class="iconmenu" src="{{ asset('img') }}/home-regular-50.png">
            Beranda
        </a>
    </div>
    <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('peserta/*') ? 'activemenu' : 'inactivemenu'}}" href="/peserta/angkatan">
            <img class="iconmenu" src="{{ asset('img') }}/outline_people_alt_black_48dp.png">
            Peserta Kursus
        </a>
    </div>
    <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('kehadiran/*') ? 'activemenu' : 'inactivemenu'}}" href="/kehadiran/angkatan">
            <img class="iconmenu" src="{{ asset('img') }}/outline_list_alt_black_48dp.png">
            Kehadiran Peserta
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading {{ request()->is('tugas/*', 'evaluasi/*') ? 'active' : ''}}" role="tab" id="headingone">
            <a class="{{ request()->is('tugas/*', 'evaluasi/*') ? 'activemenu' : 'inactivemenu collapsed'}}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseone" aria-expanded="true" aria-controls="collapseone">
                <img class="iconmenu" src="{{ asset('img') }}/outline_assignment_black_48dp.png">
                Tugas Peserta
                <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
            </a>
        </div>
        <div id="collapseone" class="panel-collapse collapse in {{ request()->is('tugas/*', 'evaluasi/*') ? 'show' : ''}}" role="tabpanel" aria-labelledby="headingone">
            <div class="panel-body">
                <ul class="nav submenubg nav-tab d-block" id="pageSubmenu">
                    <li>
                        <a class="{{ request()->is('tugas/*') ? 'activemenu' : 'inactivemenu'}}" href="/tugas/angkatan">Tugas Pertemuan (Rapor)</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('evaluasi/*') ? 'activemenu' : 'inactivemenu'}}" href="/evaluasi/tugas/angkatan">Evaluasi Per-Modul</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('rapor/*') ? 'activemenu' : 'inactivemenu'}}" href="/rapor/angkatan">
            <img class="iconmenu" src="{{ asset('img') }}/outline_summarize_black_48dp.png">
            Rapor Peserta
        </a>
    </div>
    <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('kelulusan-peserta/*') ? 'activemenu' : 'inactivemenu'}}" href="/kelulusan-peserta/angkatan">
            <img class="iconmenu" src="{{ asset('img') }}/outline_fact_check_black_48dp.png">
            Kelulusan Peserta
        </a>
    </div>
    {{-- <div class="panel-heading" role="tab" id="headingOne">
        <a class="{{ request()->is('kelompok-asistensi/*') ? 'activemenu' : 'inactivemenu'}}" href="/kelompok-asistensi/asisten">
            <img class="iconmenu" src="{{ asset('img') }}/outline_group_work_black_48dp.png">
            Kelompok Asistensi
        </a>
    </div> --}}
    <div class="panel-heading" role="tab" id="headingtwo">
        <a class="collapsed {{ request()->is('berkas/*', 'berkas') ? 'activemenu' : 'inactivemenu'}}" href="/berkas">
            <img class="iconmenu" src="{{ asset('img') }}/outline_insert_drive_file_black_48dp.png">
            Berkas-berkas
        </a>
    </div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading {{ request()->is('jadwal-kursus/*', 'jadwal-asisten/*') ? 'active' : ''}}" role="tab" id="headingtwo">
                <a class="{{ request()->is('jadwal-kursus/*', 'jadwal-asisten/*') ? 'activemenu' : 'inactivemenu collapsed'}}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                    <img class="iconmenu" src="{{ asset('img') }}/outline_schedule_black_48dp.png">
                    Jadwal
                    <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
                </a>
            </div>
            <div id="collapsetwo" class="panel-collapse collapse in {{ request()->is('jadwal-kursus/*', 'jadwal-asisten/*') ? 'show' : ''}}" role="tabpanel" aria-labelledby="headingone">
                <div class="panel-body">
                    <ul class="nav submenubg nav-tab d-block" id="pageSubmenu">
                        <li>
                            <a class="{{ request()->is('jadwal-kursus/*') ? 'activemenu' : 'inactivemenu'}}" href="/jadwal-kursus/angkatan">Kursus</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('jadwal-asisten/*') ? 'activemenu' : 'inactivemenu'}}" href="/jadwal-asisten/semester">Asisten</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingthree">
                <a class="collapsed inactivemenu" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                    <img class="iconmenu" src="{{ asset('img') }}/round_cloud_queue_black_48dp.png">
                    Gdrive Asisten
                    <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
                </a>
            </div>
            <div id="collapsethree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingthree">
                <div class="panel-body">
                    <ul class="nav submenubg nav-tab d-block" id="pageSubmenu">
                        <li>
                            <a class="inactivemenu" href="https://drive.google.com/drive/folders/1zcgJhYI2DKzv98JT7DqteJR3tCWwb8xE" target="_blank">Bukti Kehadiran Kursus</a>
                        </li>
                        <li>
                            <a class="inactivemenu" href="http://bit.ly/BukuRaporAnimasi" target="_blank">Buku Rapor Peserta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingfour">
                <a class="collapsed inactivemenu" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                    <img class="iconmenu" src="{{ asset('img') }}/round_cloud_queue_black_48dp.png">
                    Gdrive Peserta
                    <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
                </a>
            </div>
            <div id="collapsefour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingfour">
                <div class="panel-body">
                    <ul class="nav submenubg nav-tab d-block" id="pageSubmenu">
                        <li>
                            <a class="inactivemenu" href="https://drive.google.com/drive/folders/1zk5VeGXCXXFhTZnbvbi1snKd0DYWbf8S?usp=sharing" target="_blank">MI</a>
                        </li>
                        <li>
                            <a class="inactivemenu" href="https://drive.google.com/drive/folders/1zkduQk7jJZmIVuPLFhB1OwD9F0l3eH3w?usp=sharing" target="_blank">SI</a>
                        </li>
                        <li>
                            <a class="inactivemenu" href="https://drive.google.com/drive/folders/1WJbH0NcWINoQiEj7D7Mq9HTI4AJmCfq-?usp=sharing" target="_blank">TI</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/rapor-peserta.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection 

@section('title-window','Rapor Peserta')
@section('title','Rapor Peserta')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
                @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-rapor{{$data->tahun_angkatan}}-tab" href="/rapor/angkatan/{{$data->tahun_angkatan}}/skema/s-0{{ $skemafirst_id }}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
                        Angkatan {{$data->tahun_angkatan}}
                    </a>
                @endforeach
            </div>
        </nav>

        @if(session('pesan'))
            <div class="alert alert-success" role="alert" id="edit-alert">
                <span class="edit-success">{{ session('pesan')}}</span>
            </div> 
        @endif


        <div class="semester-aktif">
            Semester Aktif : {{ $angkatan->semester_aktif ? $angkatan->semester_aktif : '-' }}
        </div>
        <div class="border row">
            <div class="menu-semester">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Semester</a>
                    @if( $skema->nama_skema == 'Pembuat Ide Gerak & Cerita (Generalist)' )
                        @foreach($semester_all as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data->id }}" aria-controls="tugas-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                        @endforeach
                        <a class="list-group-item list-group-item-action " id="nav-semester-tab" href="/rapor/angkatan/{{ $t_a }}/semester/rangkuman" aria-selected="true">Rangkuman</a>
                    @endif
                    @if( $skema->nama_skema == '3D Illustration Artist' )   
                        @foreach(range(1, 6) as $data)
                            <a class="list-group-item list-group-item-action {{ request()->segment(7) == ($data) ? 'active' : '' }} {{ $data == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data }}-tab" href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $data }}" aria-controls="tugas-semeseter{{ $data }}" aria-selected="true">{{ $data }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        
            <div class="cards">
                <div class="tab-content" id="nav-tabContent">
                    <form action="/rapor/angkatan/{{ $t_a }}/semester/{{ $i_s }}/{{ $i_r }}" method="post" id="form-editrapor">
                        @csrf
                        <div class="rapor">
                            <div class="btnprint">
                                <a href="/rapor/angkatan/{{ $t_a }}/skema/s-0{{ $skemacurrent_id }}/semester/{{ $i_s }}/{{ $i_r }}/print" class="btn btn-outline-success" target="_blank">
                                    <span class="material-icons-outlined">
                                        print
                                    </span>
                                </a>
                            </div>
                            <div class="header">
                                <div class="logo">
                                    <img src="{{ asset('img') }}/logo_gundar.png"style="width:100px; height:100px;">
                                </div>
                                <div class="judul">Rapor Peserta Kursus Animasi Berbasis Kompetensi Universitas Gunadarma</div>
                            </div>
                            <div class="content1">
                                <table class="table table-bordered tabel-rapor" style="width:100%">
                                    <tr>
                                        <th style="font-weight: 600;">Nama</th>
                                        <td>{{ $rapor->peserta->nama_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">NPM</th>
                                        <td>{{ $rapor->peserta->npm_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Telp</th>
                                        <td>{{ $rapor->peserta->notelp_peserta ? $rapor->peserta->notelp_peserta :'-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Jurusan</th>
                                        <td>{{ $rapor->peserta->jurusan->nama_jurusan ? $rapor->peserta->jurusan->nama_jurusan :'-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Skema</th>
                                        <td>{{ $rapor->peserta->skema->nama_skema }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Semester</th>
                                        <td>{{ $i_s }} {{ $spa ? '('.$spa.')' : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Kehadiran</th>
                                        <td>{{ $counter_hadir }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Kelengkapan Tugas</th>
                                        <td>{{ $counter_selesai }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-weight: 600;">Status Kelulusan</th>
                                        <td>{{ $status_kelulusan }}</td>
                                    </tr>
                                </table>
                            </div>
                            @foreach ($raporsem as $data)
                                <div class="content2">
                                    <table class="table table-bordered tabel-pert" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle pert" style="width: 10%; font-weight: 600; background: rgba(0, 0, 0, 0.1);">Pertemuan {{ $loop->iteration }}</th>
                                                <th class="align-middle npert" style="width: 90%; font-weight: 600; background: rgba(0, 0, 0, 0.1);" colspan="7">{{ $data->nama_pertemuan ? $data->nama_pertemuan : '-' }}</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle ip" style="width: 10%; background: rgba(0, 0, 0, 0.08);" rowspan="2">Item Penilaian</th>
                                                <th class="align-middle ab" style="width: 15%; background: rgba(0, 0, 0, 0.08); text-align: center" colspan="2">Absensi</th>
                                                <th class="align-middle nt" style="width: 25%; background: rgba(0, 0, 0, 0.08); text-align: center" colspan="2">{{ $data->nama_tugas ? $data->nama_tugas : 'Tugas' }}</th>
                                                <th class="align-middle ap" style="width: 14%; background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">Asisten Penilai</th>
                                                <th class="align-middle tp" style="width: 14%; background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">Diperiksa pada tanggal</th>
                                                <th class="align-middle ct" style="width: 22%; background: rgba(0, 0, 0, 0.08); text-align: center" rowspan="2">catatan</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle had" style="width: 7.5%; background: rgba(0, 0, 0, 0.08); text-align: center">Hadir</th>
                                                <th class="align-middle thad" style="width: 7.5%; background: rgba(0, 0, 0, 0.08); text-align: center">Tidak Hadir</th>
                                                <th class="align-middle ya" style="width: 12.5%; background: rgba(0, 0, 0, 0.08); text-align: center">Ya</th>
                                                <th class="align-middle tdk" style="width: 12.5%; background: rgba(0, 0, 0, 0.08); text-align: center">Tidak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> 
                                                <td class="align-middle">Hasil Penilaian</td>
                                                <td style="text-align: center;" class="align-middle">
                                                    <input type="hidden" name="{{ 'k'.$loop->iteration }}" value="">
                                                    <input type="checkbox" class="{{ 'k'.$loop->iteration }} check" name="{{ 'k'.$loop->iteration }}" value="Hadir" {{ $kehadiran->{'pertemuan_'.$loop->iteration} == "Hadir" ? "Checked" : '' }}/>
                                                </td>
                                                <td style="text-align: center;" class="align-middle">
                                                    <input type="checkbox" class="{{ 'k'.$loop->iteration }} check" name="{{ 'k'.$loop->iteration }}" value="Absen" {{ $kehadiran->{'pertemuan_'.$loop->iteration} == "Absen" ? "Checked" : '' }}/>
                                                </td>
                                                <td style="text-align: center;" class="align-middle">
                                                    <input type="hidden" name="{{ 't'.$loop->iteration }}" value="">
                                                    <input type="checkbox" class="{{ 't'.$loop->iteration }} check" name="{{ 't'.$loop->iteration }}" value="Selesai" {{ $tugas->{'tugas_'.$loop->iteration} == "Selesai" ? "Checked" : '' }}/>
                                                </td>
                                                <td style="text-align: center;" class="align-middle">
                                                    <input type="checkbox" class="{{ 't'.$loop->iteration }} check" name="{{ 't'.$loop->iteration }}" value="Belum Selesai" {{ $tugas->{'tugas_'.$loop->iteration} == "Belum Selesai" ? "Checked" : '' }}/>
                                                </td>
                                                <td>
                                                    <select class="form-control form-select" name="asistp{{ $loop->iteration }}" id="asistp{{ $loop->iteration }}">
                                                        <option value="">-</option>
                                                        @if($asisten->count() > 0)
                                                            @foreach($asisten as $ast)
                                                                <option value={{ $ast->id }} {{ $apr->{'pertemuan_'.$loop->parent->iteration} == $ast->id ? 'selected' : '' }}>{{ $ast->nama_user }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td><input name="tanggal{{ $loop->iteration }}" type="text" class="form-control tanggal" id="inputtanggal{{ $loop->iteration }}" autocomplete="off" value="{{ $tpr->{'pertemuan_'.$loop->iteration} }}"></td>
                                                <td><textarea type="text" class="catatan form-control" name="catatan{{ $loop->iteration }}" placeholder="-">{{ $cr->{'pertemuan_'.$loop->iteration} }}</textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                        <div class="btnsimpan">
                            <button type="submit" class="btn btn-outline-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="page-content">
        <div class="card">
            <div class="status">
                <a>Angkatan {{ $t_a }} tidak dapat diolah karena berstatus Tidak Aktif</a>
            </div>
        </div>
    </div>
@endif
@endsection 

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/rapor.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
@foreach ($raporsem as $data)
    $('.k{{ $loop->iteration }}').click(function() {
        $('.k{{ $loop->iteration }}').not(this).prop('checked', false);
    });
    $('.t{{ $loop->iteration }}').click(function() {
        $('.t{{ $loop->iteration }}').not(this).prop('checked', false);
    });
@endforeach

$(function() {
    @foreach ($raporsem as $data)
        $('input[name="tanggal{{ $loop->iteration }}"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "M",
                    "S",
                    "S",
                    "R",
                    "K",
                    "J",
                    "S"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
            },
        });

        $('input[name="tanggal{{ $loop->iteration }}"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        $('input[name="tanggal{{ $loop->iteration }}"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="tanggal{{ $loop->iteration }}"]').data('daterangepicker').setStartDate(moment());
        $('input[name="tanggal{{ $loop->iteration }}"]').data('daterangepicker').setEndDate();

        $('.drp-buttons button.cancelBtn').removeClass('btn-default');
        $('.drp-buttons button.cancelBtn').addClass('btn-link').css({"color": "rgb(71, 71, 71)"});

        $('.drp-buttons button.applyBtn').removeClass('btn-primary');
        $('.drp-buttons button.applyBtn').addClass('btn-outline-primary');
    @endforeach
});
</script>
@endsection
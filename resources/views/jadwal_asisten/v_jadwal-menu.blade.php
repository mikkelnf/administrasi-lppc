@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/jadwal-asisten-menu.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection 

@section('title-window','Jadwal Asisten')
@section('title','Jadwal Asisten')

@section('content')
@if($checker)
    <div class="page-content">
        <nav>
            <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
                @foreach($s_periode as $data)
                    <a class="nav-item nav-link {{ request()->segment(3) == ($data->id) ? 'active' : '' }}" href="/jadwal-asisten/semester/{{ $data->id }}/pertemuan" aria-controls="semester{{ $data->tahun_angkatan }}" aria-selected="true">
                        {{$data->nama_semesterperiode}}
                    </a>
                @endforeach
            </div>
        </nav>

        @if(session('pesan'))
            <div class="alert alert-success" role="alert" id="edit-alert-periode">
                <span class="edit-success">{{ session('pesan')}}</span>
            </div> 
        @endif

        <div class="alert alert-success collapse" role="alert" id="success-alert-jadwal">
            <span class="add-success sukses-jadwal"></span>
        </div>

        <div class="border row">
            <div class="menu-pertemuan">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Pertemuan</a>
                    @foreach($pertemuan_all as $data)
                        <a class="list-group-item list-group-item-action {{ request()->segment(5) == ($data->id) ? 'active' : '' }}" id="nav-pertemuan{{ $data->id }}-tab" href="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $data->id }}" aria-controls="jadwal-pertemuan{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach        
                </div>
            </div>
            <div class="cards">
                <div  id="card-control">
                    <div class="card-control">
                        <div class="periode">
                            <div class="periode-text">Periode</div>
                            <div class="periode-info {{ $periode->periode ? '' : 'kosong' }}">
                                <a>
                                    {{ $periode->periode ? $periode->periode : '----------' }}
                                </a>
                            </div>
                        </div>
                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                            <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#modaleditperiode">
                                <span class="material-icons-outlined icon-edit">
                                    edit
                                </span>
                            </button>
                        @endif
                        <div class="modal fade" id="modaleditperiode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Periode</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $i_p }}/edit/periode" method="POST" id="formeditperiode">
                                        @csrf
                                        <div class="modal-body modal-body-periode">
                                            <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                <span class="success-text"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputjam" class="col-sm-2 col-form-label">Periode</label>
                                                <div class="">
                                                    <input name="periode" type="text" class="form-control" id="inputperiode" autocomplete="off" value="{{ $periode->periode }}">
                                                    <small class="form-text text-muted">Pilih tanggal awal dan akhir periode</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                            <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="blank">
                        </div>
                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                            <a class="tambah">
                                Tambah Jadwal
                            </a>
                            <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" data-toggle="modal" data-target="#modaltambahjadwal">
                                <span class="material-icons add">
                                    add
                                </span>
                            </button>
                        @endif

                        {{-- modal tambah --}}
                        <div class="modal fade" id="modaltambahjadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg-tambah" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Asisten</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $i_p }}/tambah-jadwal" method="POST" id="formtambahjadwal">
                                        @csrf
                                        <div class="modal-body modal-body-1">
                                            <div class="alert alert-success collapse" role="alert" id="success-alerts-tambah">
                                                <span class="success-text-tambah"></span>
                                            </div>
                                            @if($jadwalkursus->count() > 0)
                                                <div class="pilih">
                                                    Pilih jadwal kursus
                                                </div>
                                            @endif
                                            <div class="card">
                                            @if($jadwalkursus->count() > 0)
                                                <table class="table pilih-jadwal" cellspacing="0" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-1">No</th>
                                                            <th class="col-2">Id</th>
                                                            <th class="col-3">Angkatan</th>
                                                            <th class="col-4">Semester</th>
                                                            <th class="col-5">Hari</th>
                                                            <th class="col-6">Jam</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($jadwalkursus as $data)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $data->id }}</td>
                                                                <td>{{ $data->angkatan->tahun_angkatan }}</td>
                                                                <td>{{ $data->id_semesterkuliah }}</td>
                                                                <td>{{ $data->hari }}</td>
                                                                <td>{{ $data->jam }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="status">
                                                    <a>Tidak ada jadwal kursus untuk dipilih</a>
                                                </div>
                                            @endif
                                            </div>
                                            <div class="form-group row form-instruktur">
                                                <label for="inputisntruktur" class="col-sm-3 col-form-label">Instruktur</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control form-select" name="instruktur" id="instruktur">
                                                        <option value="">-</option>
                                                        @foreach($asisten as $ins)
                                                            <option value={{ $ins->id }}>{{ $ins->nama_user }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text instruktur_error" role="alert"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputhost" class="col-sm-3 col-form-label">Host</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control form-select" name="host" id="host">
                                                        <option value="">-</option>
                                                        @if($asisten->count() > 0)
                                                            @foreach($asisten as $ins)
                                                                <option value={{ $ins->id }}>{{ $ins->nama_user }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger error-text host_error" role="alert"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputhost" class="col-sm-3 col-form-label">Asisten</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control form-select js-example-basic-multiple" name="asisten[]" multiple="multiple" style="width: 100%;" id="asisten">
                                                        @if($asisten->count() > 0)
                                                            @foreach($asisten as $ins)
                                                                <option value={{ $ins->id }}>{{ $ins->nama_user }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger error-text asisten_error" role="alert"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                            <button type="submit" class="btn btn-outline-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if( $jadwal_asisten->count() > 0)
                    <div id="daftar-jadwal">
                        <div class="row jadwal">
                            @foreach($jadwal_asisten as $data)
                            <div class="col-sm-4">
                                <div class="card card-jadwal">
                                    <div class="card-body">
                                        <div class="d-flex title">
                                        <h5 class="card-title">{{ $data->jadwalkursus ? $data->jadwalkursus->hari : '-' }} &nbsp; ({{ $data->jadwalkursus ? $data->jadwalkursus->jam : '-' }})</h5>
                                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                            <button type="button" class="btn btn-outline-primary btn-edit btn-ctrl" data-toggle="modal" data-target="#modaleditjadwal{{ $data->id }}">
                                                <span class="material-icons-outlined ip2">
                                                    edit
                                                </span>
                                            </button>
                                        @endif
                                        </div>
                                        <hr>
                                        <p class="card-text">Angkatan : {{ $data->jadwalkursus ? $data->jadwalkursus->angkatan->tahun_angkatan : '-' }}</p>
                                        <p class="card-text">Jumlah Peserta : {{ $data->jadwalkursus ? $pesertadijadwal->where('id_jadwalkursus', $data->jadwalkursus->id)->count() : '-' }}</p>
                                        <p class="card-text">Link : {{ $data->jadwalkursus ? $data->jadwalkursus->link : '-' }}</p>
                                        <p class="card-text">Instruktur : {{ $data->instrukturs ? $data->instrukturs->nama_user : '-' }}</p>
                                        <p class="card-text">Host : {{ $data->hosts ? $data->hosts->nama_user : '-' }}</p>
                                        <div class="card-text bbb">
                                            <a class="abc">Asisten : </a>
                                            @if($b->where('id_jadwalasisten', $data->id)->count() > 0)
                                                <div class="aa">
                                                    @foreach($b->where('id_jadwalasisten', $data->id) as $d)
                                                        <a class="ss">
                                                            - {{ $d->user->nama_user }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="aa">
                                                    -
                                                </div>
                                            @endif
                                        </div>
                                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                            <div class="detail">
                                                <button type="button" class="btn btn-outline-danger btn-hapus" data-toggle="modal" data-target="#delete-{{ $data->id }}">Hapus</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- modal edit --}}
                            <div class="modal fade modaleditjadwal" id="modaleditjadwal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg-edit" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Asisten</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $i_p }}/edit-jadwal/{{ $data->id }}" method="POST" id="formeditjadwal{{ $data->id }}">
                                            @csrf
                                            <div class="modal-body modal-body-1">
                                                <div class="alert alert-success collapse" role="alert" id="success-alerts-edit">
                                                    <span class="success-text-edit"></span>
                                                </div>
                                                @if($jadwalkursus->count() > 0)
                                                <div class="pilih">
                                                    Pilih jadwal kursus
                                                </div>
                                            @endif
                                            <div class="card">
                                            @if($jadwalkursus->count() > 0)
                                                <table class="table pilih-jadwal" cellspacing="0" id="example_{{ $data->id }}">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-1">No</th>
                                                            <th class="col-2">Id</th>
                                                            <th class="col-3">Angkatan</th>
                                                            <th class="col-4">Semester</th>
                                                            <th class="col-5">Hari</th>
                                                            <th class="col-6">Jam</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($jadwalkursus as $j)
                                                            <tr class="{{ $data->id_jadwalkursus == $j->id ? 'selected' : '' }}">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $j->id }}</td>
                                                                <td>{{ $j->angkatan->tahun_angkatan }}</td>
                                                                <td>{{ $j->id_semesterkuliah }}</td>
                                                                <td>{{ $j->hari }}</td>
                                                                <td>{{ $j->jam }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="status">
                                                    <a>Tidak ada jadwal kursus untuk dipilih</a>
                                                </div>
                                            @endif
                                            </div>
                                                <div class="form-group row form-instruktur">
                                                    <label for="inputisntruktur" class="col-sm-3 col-form-label">Instruktur</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control form-select" name="instruktur" id="instruktur{{ $data->id }}">
                                                            <option value="">-</option>
                                                            @foreach($asisten as $ast)
                                                                <option value={{ $ast->id }} {{ $data->instruktur == $ast->id ? 'selected' : '' }}>{{ $ast->nama_user }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text instruktur_error" role="alert"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputhost" class="col-sm-3 col-form-label">Host</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control form-select" name="host" id="host{{ $data->id }}">
                                                            <option value="">-</option>
                                                            @if($asisten->count() > 0)
                                                                @foreach($asisten as $ast)
                                                                    <option value={{ $ast->id }} {{ $data->host == $ast->id ? 'selected' : '' }}>{{ $ast->nama_user }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <span class="text-danger error-text host_error" role="alert"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputhost" class="col-sm-3 col-form-label">Asisten</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control form-select js-example-basic-multiple asisten_edit{{ $data->id }}" name="asisten[]" multiple="multiple" style="width: 100%;">
                                                            @if($asisten->count() > 0)
                                                                @foreach($asisten as $ast)
                                                                    @if(!$b->where('id_jadwalasisten', $data->id)->first() == null)
                                                                        <option value={{ $ast->id }} 
                                                                            @foreach($b->where('id_jadwalasisten', $data->id) as $d)
                                                                                {{ $d->user->id == $ast->id ? 'selected' : '' }}
                                                                            @endforeach>
                                                                            {{ $ast->nama_user }}
                                                                        </option>
                                                                    @else
                                                                        <option value={{ $ast->id }}>{{ $ast->nama_user }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <span class="text-danger error-text asisten_error" role="alert"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                                                <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- modal delete --}}
                            <div class="modal fade" id="delete-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Jadwal Asisten</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin menghapus jadwal "{{ $data->jadwalkursus ? $data->jadwalkursus->hari : '-' }} &nbsp; ({{ $data->jadwalkursus ? $data->jadwalkursus->jam : '-' }})" ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>                           
                                        <a href="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $i_p }}/hapus-jadwal/{{ $data->id }}" class="btn btn-outline-danger">Ya</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    <div class="alert d-flex">
                        <span class="material-icons-outlined info-icon">info</span>
                        <div class="info-text">
                            Hanya admin yang dapat mengelola jadwal asisten <br>
                            <hr>
                            Klik lihat laporan untuk melihat semua jadwal asisten pada pertemuan ini
                        </div>
                    </div>
                    <a href="/jadwal-asisten/semester/{{ $i_s }}/pertemuan/{{ $i_p }}/semua-jadwal" class="btn btn-outline-success btn-pdf" target="_blank">Lihat Laporan</a>
                @else
                    <a class="jadwal-kosong">Belum ada jadwal di pertemuan ini</a>
                    <div class="info">
                        <hr>
                        <div class="alert d-flex">
                            <span class="material-icons-outlined info-icon">info</span>
                            <div class="info-text">
                                Hanya admin yang dapat mengelola jadwal asisten
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="page-content">
        <div class="card">
            <div class="status">
                <a>Semester {{ $n_s }} tidak dapat diolah karena berstatus Tidak Aktif</a>
            </div>
        </div>
    </div>
@endif
@endsection 

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/jadwal-asisten.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        font: '12px'
    });

    $(function() {
        $('input[name="periode"]').daterangepicker({
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

        $('input[name="periode"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="periode"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input[name="periode"]').data('daterangepicker').setStartDate(moment());
        $('input[name="periode"]').data('daterangepicker').setEndDate();

        $('.drp-buttons button.cancelBtn').removeClass('btn-default');
        $('.drp-buttons button.cancelBtn').addClass('btn-link').css({"color": "rgb(71, 71, 71)"});

        $('.drp-buttons button.applyBtn').removeClass('btn-primary');
        $('.drp-buttons button.applyBtn').addClass('btn-outline-primary');
    });

    table = $('#example').DataTable({
        "order": [[ 0, "asc" ]],
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 5,
        "info":     false,
        select: true,
        language: {
            search: '<i class="fas fa-search" aria-hidden="true"></i>',
            searchPlaceholder: "cari",
            "zeroRecords": "Record yang dicari tidak ditemukan",
        },
        columnDefs: [
        { "targets": 0 },
        { "targets": 1, 'visible':false },
        { "targets": 2 },
        { "targets": 3 },
        { "targets": 4, "sortable":false },
        { "targets": 5, "sortable":false }
        ]
    });


    $("#formtambahjadwal").on('submit', function(e){
        e.preventDefault();
        var a = table.rows( { selected: true } );
        if (a.any()) {
            x = a.data()[0][1];
        }
        else{
            x = null;
        }
        b = $("#instruktur").val();
        c = $("#host").val();
        d = $("#asisten").val();
        console.log(d);
        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:{
                id_kursus:x,
                instruktur:b,
                host:c,
                asisten:d,
                _token: @json(csrf_token())
            },
            success:function(data){
                localStorage.setItem("Status-tambah",data.OperationStatus)
                window.location.reload(); 
            }
        })
    })

    var x = $("#example_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    $('#example_wrapper .col-sm-12.col-md-5').remove();

    @foreach($jadwal_asisten as $data)
        table{{ $data->id }} = $('#example_{{ $data->id }}').DataTable({
            "order": [[ 0, "asc" ]],
            "pagingType": "numbers",
            stateSave: true,
            "lengthChange": false,
            "pageLength": 5,
            "info":     false,
            select: true,
            language: {
                search: '<i class="fas fa-search" aria-hidden="true"></i>',
                searchPlaceholder: "cari",
                "zeroRecords": "Record yang dicari tidak ditemukan",
            },
            columnDefs: [
            { "targets": 0 },
            { "targets": 1, 'visible':false },
            { "targets": 2 },
            { "targets": 3 },
            { "targets": 4, "sortable":false },
            { "targets": 5, "sortable":false }
            ]
        });

        $('#example_{{ $data->id }} tbody').on( 'click', 'tr', function () {
            $('.check').not(this).prop('checked', false);
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $(this).siblings().removeClass('selected');
            }
            else {
                table{{ $data->id }}.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $(this).siblings().removeClass('selected');
            }
        });

        $("#formeditjadwal{{ $data->id }}").on('submit', function(e){
            e.preventDefault();
            table{{ $data->id }}.rows('.selected').select();
            var a = table{{ $data->id }}.rows( { selected: true } );
            if (a.any()) {
                y = a.data()[0][1];
            }
            else{
                y = null;
            }
            console.log(x);
            b = $("#instruktur{{ $data->id }}").val();
            c = $("#host{{ $data->id }}").val();
            d = $(".asisten_edit{{ $data->id }}").val();
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:{
                    id_kursus:y,
                    instruktur:b,
                    host:c,
                    asisten:d,
                    _token: @json(csrf_token())
                },
                success:function(data){
                    localStorage.setItem("Status-edit",data.OperationStatus)
                    window.location.reload(); 
                }
            });
        });

        var x{{ $data->id }} = $("#example_{{ $data->id }}_wrapper .col-sm-12.col-md-6").first();
        x{{ $data->id }}.remove();
        $('#example_{{ $data->id }}_wrapper .col-sm-12.col-md-5').remove();
    @endforeach

    if(localStorage.getItem("Status-edit"))
    {
        $('#success-alert-jadwal').show();
        $('#edit-alert-periode').hide();
        $(document).find('span.sukses-jadwal').text('Jadwal berhasil diubah');
        localStorage.clear();
    }

    if(localStorage.getItem("Status-tambah"))
    {
        $('#success-alert-jadwal').show();
        $('#edit-alert-periode').hide();
        $(document).find('span.sukses-jadwal').text('Jadwal berhasil ditambah');
        localStorage.clear();
    }
});
</script>
@endsection 

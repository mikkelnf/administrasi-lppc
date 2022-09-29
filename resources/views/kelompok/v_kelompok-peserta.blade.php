@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelompok-peserta.css') }}">
@endsection 

@section('title-window','Kelompok Asistensi')
@section('title','Kelompok Asistensi')
       
@section('content')
<div class="page-content">
    <div class="asisten d-flex">
        <div class="asisten-pendamping">Asisten</div>
        <div class="nama-asisten">{{$asisten->nama_user}}</div>
    </div>
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-tab" role="tablist">
            <a class="nav-item nav-link {{ request()->segment(4) == 'peserta' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/peserta" aria-controls="" aria-selected="true">
                Peserta
            </a>
            <a class="nav-item nav-link {{ request()->segment(4) == 'kehadiran' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/kehadiran/semester/" aria-controls="" aria-selected="true">
                Kehadiran
            </a>
            <a class="nav-item nav-link {{ request()->segment(4) == 'tugas' ? 'active' : '' }}" href="/kelompok-asistensi/asisten/{{$user->id}}/tugas/semester/" aria-controls="" aria-selected="true">
                Tugas
            </a>
        </div>
    </nav>

    @if(session('pesan'))
        <div class="alert alert-success" role="alert">
            <span class="delete-success">{{ session('pesan')}}</span>
        </div>
    @endif

    <div class="card">
        @if(auth()->user()->id_role == 0 | 1)
            <div class="card-control">
                <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" data-toggle="modal" data-target="#modaltambahpeserta">
                    <span class="material-icons add">
                        add
                    </span>
                </button>
            </div>
        @endif
        <div class="modal fade" id="modaltambahpeserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-tambah" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah peserta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/kelompok-asistensi/asisten/{{$user->id}}/peserta" method="POST" id="formtambahpeserta">
                        @csrf
                        <div class="modal-body" id="modalLgContent">
                            <div class="d-flex asisten">
                                <div class="asisten-pendamping">Asisten</div>
                                <div class="nama-asisten">{{$asisten->nama_user}}</div>
                            </div>
                            @if($peserta->count() > 0)
                                <div class="pilih">
                                    Pilih peserta untuk ditambah ke kelompok ini
                                </div>
                            @endif
                            <div class="card">
                                <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                    <span class="success-text"></span>
                                </div>
                                @if($peserta->count() > 0)
                                    <table class="table pilih-peserta" cellspacing="0" id="example">
                                        <thead>
                                            <tr>
                                                <th class="col-1"></th>
                                                <th class="col-2">No</th>
                                                <th class="col-3">NPM</th>
                                                <th class="col-4">Nama</th>
                                                <th class="col-5">Angkatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($peserta as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="checkbox" name="check-box[]" value={{ $data->id }}></td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->npm_peserta }}</td>
                                                    <td>{{ $data->nama_peserta }}</td>
                                                    <td>{{ $data->angkatan->tahun_angkatan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <div class="status">
                                    <a>Tidak ada peserta untuk dapat ditambah</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>
                            @if($peserta->count() > 0)
                                <button type="submit" class="btn btn-outline-primary" id="tambah-btn">Tambah</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if($peserta_kelompok->count() > 0)
            @if($peserta_kelompok_ta->count() > 0)
                <div class="table-ta">
                    <a>Peserta dari angkatan aktif</a>
                </div>
            @endif
            <table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 15%;">NPM</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 25%;">Angkatan</th>
                        @if(auth()->user()->id_role == 0 | 1)
                            <th style="width: 20%;">Hapus</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($peserta_kelompok as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->npm_peserta }}</td>
                            <td>{{ $data->nama_peserta }}</td>
                            <td>{{ $data->angkatan->tahun_angkatan }}</td>
                            @if(auth()->user()->id_role == 0 | 1)
                                <td class="action">
                                    <button type="button" class="btn btn-outline-danger btn-delete btn-ctrl" data-toggle="modal" data-target="#delete-{{ $data->id }}">
                                        <span class="material-icons-round ip2">
                                            delete_outline
                                        </span>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($peserta_kelompok_ta->count() > 0)
            <div class="status">
                <a>Tidak ada peserta dari angkatan aktif pada kelompok ini</a>
            </div>
        @else
            <div class="status">
                <a>Tidak ada peserta pada kelompok ini</a>
            </div>
        @endif
        @if($peserta_kelompok_ta->count() > 0)
            <div class="table-ta">
                <a>Peserta dari angkatan tidak aktif</a>
            </div>
            <table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 15%;">NPM</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 25%;">Angkatan</th>
                        <th style="width: 20%;">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peserta_kelompok_ta as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->npm_peserta }}</td>
                        <td>{{ $data->nama_peserta }}</td>
                        <td>{{ $data->angkatan->tahun_angkatan }}</td>
                        <td class="action">
                            <button type="button" class="btn btn-outline-danger btn-delete btn-ctrl" data-toggle="modal" data-target="#delete-{{ $data->id }}">
                                <span class="material-icons-round ip2">
                                    delete_outline
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="info">
            <hr>
            <div class="alert d-flex">
                <span class="material-icons-outlined info-icon">info</span>
                <div class="info-text">
                    Hanya admin yang dapat menambahkan dan menghapus peserta kelompok asistensi
                </div>
            </div>
        </div>
        @foreach( $peserta_kelompok as $data )
            <div class="modal fade modal-delete" id="delete-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Peserta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/kelompok-asistensi/asisten/{{$user->id}}/peserta/edit/{{ $data->id }}" method="POST" id="formeditpeserta-{{ $data->id }}">
                        @csrf
                        <div class="modal-body">
                            Apakah anda yakin menghapus "{{ $data->nama_peserta }}" dari kelompok ini ?
                            <small id="" class="form-text text-muted">Perhatian !</small>
                            <small id="" class="form-text text-muted">Menghapus peserta dari kelompok tidak akan menghapus data peserta</small>
                            <input name="id_asisten" type="hidden" class="form-control" id="id_asisten" autocomplete="off" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>                           
                            <button type="submit" class="btn btn-outline-danger">Ya</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        @endforeach
        @foreach( $peserta_kelompok_ta as $data )
            <div class="modal fade" id="delete-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Peserta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/kelompok-asistensi/asisten/{{$user->id}}/peserta/edit/{{ $data->id }}" method="POST" id="formeditpeserta-{{ $data->id }}">
                        @csrf
                        <div class="modal-body">
                            Apakah anda yakin menghapus "{{ $data->nama_peserta }}" dari kelompok ini ?
                            <small id="" class="form-text text-muted">Perhatian !</small>
                            <small id="" class="form-text text-muted">Menghapus peserta dari kelompok tidak akan menghapus data peserta</small>
                            <input name="id_asisten" type="hidden" class="form-control" id="id_asisten" autocomplete="off" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Close</button>                           
                            <button type="submit" class="btn btn-outline-danger">Ya</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection  

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    table = $('#example').DataTable({
        "order": [[ 1, "asc" ]],
        "pagingType": "numbers",
        "lengthChange": false,
        "pageLength": 15,
        "info":     false,
        language: {
            search: '<i class="fas fa-search" aria-hidden="true"></i>',
            searchPlaceholder: "cari",
            "zeroRecords": "Record yang dicari tidak ditemukan",
        },
        columnDefs: [
        { "targets": 0, "sortable":false },
        { "targets": 1 },
        { "targets": 2, "sortable":false },
        { "targets": 3, "sortable":false },
        { "targets": 4 }
        ]
    });

    $("#formtambahpeserta").on('submit', function(g){
        var $form = $(this);
    // Iterate over all checkboxes in the table
    table.$('input[type="checkbox"]').each(function(){
        // If checkbox doesn't exist in DOM
        if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
                // Create a hidden element 
                $form.append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', this.name)
                    .val(this.value)
                );
            }
        } 
    });
    });

    var checkbox_terpilih = $('#example tbody .checkbox:checked');
    var semua_id = [];
    table.rows().nodes().to$().find('input[type="checkbox"]:checked').each(function(){
        semua_id.push(this.value);
        $(form).append(
             $('<input>')
                .attr('type', 'checkbox')
                .val()
        );
    });
    console.log(semua_id.length)
    $('#tambah-btn').prop('disabled', true);
    if(semua_id.length === 0){
        $('#tambah-btn').prop('disabled', true);
    }else if(semua_id.length > 0){
        $('#tambah-btn').prop('disabled', false);
    }

    var x = $("#example_wrapper .col-sm-12.col-md-6").first();
    x.remove();
    $('#example_wrapper .col-sm-12.col-md-5').remove();
    $('#example tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('active');
        if($(this).find("input[type=checkbox]").is(':checked')){
            $(this).find("input[type=checkbox]").attr("checked", false);
        }
        else if(!$(this).find("input[type=checkbox]").is(':checked')){
            $(this).find("input[type=checkbox]").attr("checked", true)
        }
        var checkbox_terpilih = $('#example tbody .checkbox:checked');
        var semua_id = [];
        table.rows().nodes().to$().find('input[type="checkbox"]:checked').each(function(){
            semua_id.push(this.value);
        });
        console.log(semua_id.length)
        $('#tambah-btn').prop('disabled', true);
        if(semua_id.length === 0){
            $('#tambah-btn').prop('disabled', true);
        }else if(semua_id.length > 0){
            $('#tambah-btn').prop('disabled', false);
        }
    });
});
</script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection
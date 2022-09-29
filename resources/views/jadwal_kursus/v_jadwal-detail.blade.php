@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/jadwal-detail.css') }}">
@endsection 

@section('title-window','Jadwal Kursus')
@section('title','Jadwal Kursus')

@section('content')
@if($checker)
<div class="page-content">
    <nav>
        <div class="nav nav-tab nav-angkatan justify-content-center" id="nav-angkatan" role="tablist">
            @foreach($angkatan_aktif->sortBy('tahun_angkatan') as $data)
                <a class="nav-item nav-link {{ request()->segment(3) == ($data->tahun_angkatan) ? 'active' : '' }}" id="nav-jadwal{{$data->tahun_angkatan}}-tab" href="/jadwal-kursus/angkatan/{{$data->tahun_angkatan}}/semester/{{ $data->semester_aktif }}" aria-controls="angkatan{{$data->tahun_angkatan}}/semester" aria-selected="true">
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
    <div class="alert alert-success collapse" role="alert" id="input-alert">
        <span class="edit-success"></span>
    </div> 

    @if( $peserta->count() > 0)
        <div class="semester-aktif">
            Semester Aktif : {{ $angkatan->semester_aktif ? $angkatan->semester_aktif : '-' }}
        </div>
        <div class="border row">
            <div class="menu-semester">
                <div class="list-group list-group-flush">
                    <a class="list-group-head">Semester</a>
                    @foreach($semester_all as $data)
                    <a class="list-group-item list-group-item-action {{ request()->segment(5) == ($data->id) ? 'active' : '' }} {{ $data->id == $angkatan->semester_aktif ? 'tanda-aktif' : '' }}" id="nav-semester{{ $data->id }}-tab" href="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $data->id }}" aria-controls="jadwal-semeseter{{ $data->id }}" aria-selected="true">{{ $data->id }}</a>
                    @endforeach        
                </div>
            </div>
        
            <div class="cards">
                <ul class="nav nav-tabs menu" role="tablist" id="mytab">
                    <li class="nav-item">
                      <a class="nav-link active" href="#daftarpeserta" role="tab" data-toggle="tab">Daftar Peserta</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#inputkehadiran" role="tab" data-toggle="tab" id="kehadirans">Input Kehadiran</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="daftarpeserta">
                        <div class="table-ta">
                            <div>
                                <a>Hari : {{ $jadwal->hari }}</a>
                                <a>Jam : {{ $jadwal->jam }}</a>
                                <a>Link : {{ $jadwal->link }}</a>
                            </div>
                            @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                <button type="button" class="btn btn-tambah btn-ctrl btn-outline-dark" data-toggle="modal" data-target="#modaltambahpeserta">
                                    <span class="material-icons add">
                                        add
                                    </span>
                                </button>
                            @endif
                        </div>
                        <div class="modal fade" id="modaltambahpeserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg-tambah" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah peserta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/jadwal-{{ $i_j }}" method="POST" id="formtambahpeserta">
                                        @csrf
                                        <div class="modal-body" id="modalLgContent">
                                            <div class="d-flex info1">
                                                <div class="angkatan">Angkatan {{ $angkatan->tahun_angkatan }}</div>
                                                <div class="semester">Semester {{ $semester->id }}</div>
                                            </div>
                                            <div class="d-flex info2">
                                                <div class="hari">{{ $jadwal->hari }}</div>
                                                <div class="jam">{{ $jadwal->jam }}</div>
                                            </div>
                                            @if($pesertabelumadajadwal->count() > 0)
                                                <div class="pilih">
                                                    Pilih peserta untuk ditambah ke jadwal ini
                                                </div>
                                            @endif
                                            <div class="card">
                                                <div class="alert alert-success collapse" role="alert" id="success-alerts">
                                                    <span class="success-text"></span>
                                                </div>
                                                @if($pesertabelumadajadwal->count() > 0)
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
                                                            @foreach($pesertabelumadajadwal as $data)
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
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th style="width: 15%;">NPM</th>
                                    <th style="width: 30%;">Nama</th>
                                    @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                        <th style="width: 18%;">Hapus</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesertadijadwal as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->peserta->npm_peserta }}</td>
                                        <td>{{ $data->peserta->nama_peserta }}</td>
                                        @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                            <td class="action">
                                                <button type="button" class="btn btn-outline-danger btn-delete btn-ctrl" data-toggle="modal" data-target="#delete-{{ $data->id_peserta }}">
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
                        @if($pesertadijadwal->count() == 0)
                            <div class="peserta-kosong">
                                Belum ada peserta di jadwal ini
                            </div>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="inputkehadiran">
                        @if(session('pesan-berhasil'))
                            <div class="alert alert-success" role="alert" id="success-alert">
                                <span class="edit-success">{{ session('pesan')}}</span>
                            </div> 
                        @endif
                        @if(session('pesan-error'))
                            <div class="alert alert-danger" role="alert" id="error-alert">
                                <span class="delete-success">{{ session('pesan-error')}}</span>
                            </div>
                        @endif 
                        <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/jadwal-{{ $i_j }}/input-kehadiran" method="post" id="form-inputkehadiran">
                            @csrf
                            <div class="pilihpertemuan">
                                <div class="textpertemuan">Pilih Pertemuan</div>
                                <div class="selectpertemuan">
                                    <select class="form-control form-select" name="nomor_pertemuan" id="nomor_pertemuan">
                                        <option value="">-</option>
                                        @for($i=1; $i<11; $i++)
                                            <option value={{ $i }} {{ $i == request()->input('pertemuan') ? 'selected' : '' }}>Pertemuan {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <span class="text-danger error-text nomor_pertemuan_error" role="alert"></span>
                                </div>
                            </div>
                            <div class="table-ta">
                                <div>
                                    <a>Hari : {{ $jadwal->hari }}</a>
                                    <a>Jam : {{ $jadwal->jam }}</a>
                                    <a>Link : {{ $jadwal->link }}</a>
                                </div>
                            </div>
                            <table class="table" cellspacing="0" id="tabelkehadiran">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">No</th>
                                        <th style="width: 15%;">NPM</th>
                                        <th style="width: 51%;">Nama</th>
                                        <th style="width: 12%;">Hadir</th>
                                        <th style="width: 12%;">Tidak Hadir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kehadiran as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->peserta->npm_peserta }}</td>
                                            <td>{{ $data->peserta->nama_peserta }}</td>
                                            <td style="text-align: center;" class="align-middle">
                                                <input type="hidden" name="{{ 'k'.$loop->iteration }}" value="">
                                                <input type="checkbox" class="{{ 'k'.$loop->iteration }} check" name="{{ 'k'.$loop->iteration }}" id="hadir" value="Hadir" {{ $data->{'pertemuan_'.request()->input('pertemuan')} == "Hadir" ? "Checked" : '' }}/>
                                            </td>
                                            <td style="text-align: center;" class="align-middle">
                                                <input type="checkbox" class="{{ 'k'.$loop->iteration }} check" name="{{ 'k'.$loop->iteration }}" id="absen" value="Absen" {{ $data->{'pertemuan_'.request()->input('pertemuan')} == "Absen" ? "Checked" : '' }}/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="btnsimpan">
                                <button type="submit" class="btn btn-outline-primary">Simpan</button>
                            </div>
                        </form>
                        
                        @if($pesertadijadwal->count() == 0)
                            <div class="peserta-kosong">
                                Belum ada peserta di jadwal ini
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="info">
                    <hr>
                    <div class="alert d-flex">
                        <span class="material-icons-outlined info-icon">info</span>
                        <div class="info-text">
                            Hanya admin yang dapat mengelola peserta jadwal kursus
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="status">
                <a>Tidak ada peserta pada angkatan ini</a>
            </div>
        </div>
    @endif
    @foreach($pesertadijadwal as $data)
        <div class="modal fade" id="delete-{{ $data->id_peserta }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/jadwal-kursus/angkatan/{{ $t_a }}/semester/{{ $i_s }}/jadwal-{{ $i_j }}/hapus-{{ $data->id_peserta }}" method="POST" id="formeditpeserta-{{ $data->id_peserta }}">
                    @csrf
                    <div class="modal-body">
                        Apakah anda yakin menghapus "{{ $data->peserta->nama_peserta }}" dari jadwal ini ?
                        <input name="peserta_id" type="hidden" class="form-control" id="id_asisten" autocomplete="off" value={{ $data->id_peserta }}>
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
<script type="text/javascript" src="{{ asset('js') }}/1.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    @foreach ($pesertadijadwal as $data)
        $('.k{{ $loop->iteration }}').click(function() {
            $('.k{{ $loop->iteration }}').not(this).prop('checked', false);
        });
    @endforeach

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

    $(function(){
        $('#nomor_pertemuan').on('change', function () {
            var url = "{{ url()->current() }}?pertemuan=" + $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
        var t = window.location.href.indexOf('?pertemuan=') > 0;
        if (t) {
            $('.nav-tabs a[href="#inputkehadiran"]').tab('show');
        }
    });

    $(function(){
        $("#form-inputkehadiran").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success:function(data){
                    if(data.status==0){
                        $.each(data.error, function(prefix, val){
                            $('#form-inputkehadiran span.'+prefix+'_error').text(val[0]);
                        });
                        $(document).find('span.success-text').text('');
                        $('#success-alert').hide();
                    }
                    else{
                        localStorage.setItem("Status-edit",data.OperationStatus)
                        window.location.reload(); 
                    }
                }
            })
        })

        if(localStorage.getItem("Status-edit"))
        {
            $('#input-alert').show();
            $(document).find('#input-alert span').text('Kehadiran berhasil diinput');
            localStorage.clear();
        }
    });
});
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
@endsection
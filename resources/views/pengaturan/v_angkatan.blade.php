<div class="content-header kursus">Angkatan</div>

<div class="daftar-angkatan">
    <div class="alert alert-success collapse" role="alert" id="success-alert-angkatan">
        <span class="delete-success tambah-sukses-angkatan"></span>
    </div>
</div>

<div id="daftar-angkatan">
    <div class="daftar-angkatan">
        @if(session('pesan-angkatan'))
            <div class="alert alert-success" role="alert">
                <span class="delete-success">{{ session('pesan-angkatan')}}</span>
            </div>
        @endif 
        @if(session('pesan-angkatan-error'))
            <div class="alert alert-danger" role="alert">
                <span class="delete-success">{{ session('pesan-angkatan-error')}}</span>
            </div>
        @endif 
        @if($angkatan_aktif->count() < 4)
            <button type="button" class="btn btn-tambah btn-outline-dark" data-toggle="modal" data-target="#tambah-angkatan">
                <span class="material-icons add">
                    add
                </span>
            </button>
        @endif
        @if($angkatan_aktif->count() == 4)
            <div class="alert alert-warning" role="alert">
                <span class="material-icons-round warning-icon d-flex justify-content-center">
                    warning_amber
                </span>
                <span class="warning d-flex justify-content-center mr-auto ml-auto text-center">
                    Angkatan berstatus Aktif sudah mencapai batas maksimum : 4
                </span>
                <hr>
                <small class="d-flex justify-content-center warning-info">Tidak dapat menambah angkatan baru</small>
            </div>
        @endif
        <div class="modal fade" id="tambah-angkatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Angkatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('angkatan.tambah') }}" method="POST" id="form-tambahangkatan">
                        @csrf
                        <div class="modal-body modal-body-1">
                            <div class="alert alert-success collapse" role="alert" id="success-alert-angkatan">
                                <span class="success-text"></span>
                            </div>
                            <div class="form-group">
                                <label for="tahun_angkatan" class="col col-form-label">Tahun Angkatan</label>
                                <input name="tahun_angkatan" type="number" class="form-control" id="tahun_angkatan" autocomplete="off">
                                <small id="Help" class="form-text text-muted">Contoh : 2020</small>
                                <span class="text-danger error-text tahun_angkatan_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col col-form-label">Status</label>
                                <select class="form-control form-select hijau" name="status" id="status-angkatan">
                                    @foreach(["Aktif" => "Aktif", "Tidak Aktif" => "Tidak Aktif"] as $statusangkatan)
                                        <option class="{{ $statusangkatan == "Tidak Aktif" ? 'merah' : 'hijau' }}" value="{{$statusangkatan}}">{{$statusangkatan}}</option>
                                    @endforeach
                                </select>
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
        <ul class="list-group">
            @forelse ($semua_angkatan as $data)
                @if($semua_angkatan->count() > 3)
                    @if($semua_angkatan->count() == 4)
                        <li class="list-group-item text-left">
                            <div class="list-content row">
                                <span class="material-icons-outlined angkatan-icon">
                                    school
                                </span>
                                <div class="nama-angkatan">Angkatan {{ $data->tahun_angkatan }}</div>
                                <div class="status">
                                    Status : 
                                    <a class="{{ $data->status_angkatan == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_angkatan }}</a>
                                </div>
                                <div class="semester-aktif">
                                    Semester : 
                                    <a>{{ $data->semester_aktif ? $data->semester_aktif : '-' }}</a>
                                </div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-angkatan-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-angkatan-{{ $data->id }}">Hapus</button>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="list-group-item text-left {{ $loop->iteration > 4 ? 'x hide' : '' }}">
                            <div class="list-content row">
                                <span class="material-icons-outlined angkatan-icon">
                                    school
                                </span>
                                <div class="nama-angkatan">Angkatan {{ $data->tahun_angkatan }}</div>
                                <div class="status">
                                    Status : 
                                    <a class="{{ $data->status_angkatan == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_angkatan }}</a>
                                </div>
                                <div class="semester-aktif">
                                    Semester : 
                                    <a>{{ $data->semester_aktif ? $data->semester_aktif : '-' }}</a>
                                </div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-angkatan-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-angkatan-{{ $data->id }}">Hapus</button>
                                </div>
                            </div>
                        </li>
                        @if($loop->last)
                            <li class="list-group-item text-center list-button">
                                <a class="list-content" type="button" id="button-bottom">
                                    Tampilkan lebih banyak
                                    <img class="arrowicon" src="{{ asset('img') }}/arrow.png">
                                </a>
                            </li>
                        @endif
                    @endif
                @else
                    <li class="list-group-item text-left">
                        <div class="list-content row">
                            <span class="material-icons-outlined angkatan-icon">
                                school
                            </span>
                            <div class="nama-angkatan">Angkatan {{ $data->tahun_angkatan }}</div>
                            <div class="status">
                                Status : 
                                <a class="{{ $data->status_angkatan == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_angkatan }}</a>
                            </div>
                            <div class="button">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-angkatan-{{ $data->id }}">Edit</button>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-angkatan-{{ $data->id }}">Hapus</button>
                            </div>
                        </div>
                    </li>
                @endif
                @empty
                <li class="list-group-item text-center">
                    <div class="empty">
                        Belum ada angkatan
                    </div>
                </li>
            @endforelse
        </ul>
        <div class="alert d-flex">
            <span class="material-icons-outlined info-icon">info</span>
            <div class="info-text">
                Hanya angkatan berstatus aktif yang akan diolah aplikasi
            </div>
        </div>
        @foreach ($semua_angkatan as $data)
            <div class="modal fade edit-angkatan" id="edit-angkatan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Angkatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/pengaturan/angkatan/edit/{{$data->id}}" method="POST" id="form-editangkatan">
                            @csrf
                            <div class="modal-body modal-body-1">
                                <input name="id" type="hidden" value="{{$data->id}}">
                                <div class="form-group">
                                    <label for="tahun_angkatan" class="col col-form-label">Tahun Angkatan</label>
                                    <input name="tahun_angkatan" type="text" class="form-control text-center" id="tahun_angkatan" autocomplete="off" value="{{ $data->tahun_angkatan }}" readonly>
                                    <span class="text-danger error-text tahun_angkatan_error" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col col-form-label">Status</label>
                                    <select class="form-control form-select {{ $data->status_angkatan == "Tidak Aktif" ? 'merah' : 'hijau' }}" name="status" id="status-angkatan{{ $data->id }}">
                                        @foreach(["Aktif" => "Aktif", "Tidak Aktif" => "Tidak Aktif"] as $statusangkatan)
                                        <option class="{{ $statusangkatan == "Tidak Aktif" ? 'merah' : 'hijau' }}" value="{{ $statusangkatan }}" {{ $data->status_angkatan == "Tidak Aktif" ? 'selected' : '' }}>{{$statusangkatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="semester_aktif" class="col col-form-label">Semester Aktif</label>
                                    <select class="form-control form-select" name="semester_aktif" id="semester_aktif{{ $data->id }}">
                                        <option value="">-</option>
                                        @for($i=1; $i<9; $i++)
                                            <option value="{{ $i }}" {{ $data->semester_aktif == $i ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
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
        @endforeach
        @foreach ($semua_angkatan as $data)
            <div class="modal fade" id="delete-angkatan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Data Angkatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin menghapus "Angkatan {{$data->tahun_angkatan}}" ?
                            <small id="" class="form-text text-muted">Perhatian !</small>
                            <small id="" class="form-text text-muted">Menghapus Angkatan {{$data->tahun_angkatan}} akan ikut menghapus seluruh peserta Angkatan {{$data->tahun_angkatan}} juga</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Tidak</button>
                            <a href="/pengaturan/angkatan/hapus/{{$data->id}}" class="btn btn-outline-danger">Ya</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="content-header kursus">Semester Periode</div>

<div class="daftar-semester">
    <div class="alert alert-success collapse" role="alert" id="success-alert-semester">
        <span class="delete-success tambah-sukses-semester"></span>
    </div>
</div>

<div id="daftar-semester">
    <div class="daftar-semester">
        @if(session('pesan-semester'))
            <div class="alert alert-success" role="alert">
                <span class="delete-success">{{ session('pesan-semester')}}</span>
            </div>
        @endif 
        @if(session('pesan-semester-error'))
            <div class="alert alert-danger" role="alert">
                <span class="delete-success">{{ session('pesan-semester-error')}}</span>
            </div>
        @endif 
        @if($semesterperiode_aktif->count() < 2)
            <button type="button" class="btn btn-tambah btn-outline-dark" data-toggle="modal" data-target="#tambah-semester">
                <span class="material-icons add">
                    add
                </span>
            </button>
        @endif
        @if($semesterperiode_aktif->count() == 2)
            <div class="alert alert-warning" role="alert">
                <span class="material-icons-round warning-icon d-flex justify-content-center">
                    warning_amber
                </span>
                <span class="warning d-flex justify-content-center mr-auto ml-auto text-center">
                    Semester berstatus Aktif sudah mencapai batas maksimum : 2
                </span>
                <hr>
                <small class="d-flex justify-content-center warning-info">Tidak dapat menambah semester baru</small>
            </div>
        @endif
        <div class="modal fade" id="tambah-semester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Semester</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('semester.tambah') }}" method="POST" id="form-tambahsemester">
                        @csrf
                        <div class="modal-body modal-body-1">
                            <div class="form-group">
                                <label for="nama_semester" class="col col-form-label">Nama Semester</label>
                                <input name="nama_semesterperiode" type="text" class="form-control" id="nama_semesterperiode" autocomplete="off">
                                <small class="form-text text-muted">Contoh : PTA 2020/2021</small>
                                <span class="text-danger error-text nama_semesterperiode_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col col-form-label">Status</label>
                                <select class="form-control form-select hijau" name="status" id="status-semester">
                                    @foreach(["Aktif" => "Aktif", "Tidak Aktif" => "Tidak Aktif"] as $statussemester)
                                    <option class="{{ $statussemester == "Tidak Aktif" ? 'merah' : 'hijau' }}" value="{{$statussemester}}">{{$statussemester}}</option>
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
            @forelse ($semua_semesterperiode as $data)
                @if($semua_semesterperiode->count() > 3)
                    @if($semua_semesterperiode->count() == 4)
                        <li class="list-group-item text-left">
                            <div class="list-content row">
                                <span class="material-icons-outlined semester-icon">
                                    import_contacts
                                </span>
                                <div class="nama-semester">{{ $data->nama_semesterperiode }}</div>
                                <div class="status">
                                    Status : 
                                    <a class="{{ $data->status_semesterperiode == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_semesterperiode }}</a>
                                </div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-semester-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-semester-{{ $data->id }}">Hapus</button>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="list-group-item text-left {{ $loop->iteration > 4 ? 'x hide' : '' }}">
                            <div class="list-content row">
                                <span class="material-icons-outlined semester-icon">
                                    import_contacts
                                </span>
                                <div class="nama-semester">{{ $data->status_semesterperiode }}</div>
                                <div class="status">
                                    Status : 
                                    <a class="{{ $data->status == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_semesterperiode }}</a>
                                </div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-semester-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-semester-{{ $data->id }}">Hapus</button>
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
                            <span class="material-icons-outlined semester-icon">
                                import_contacts
                            </span>
                            <div class="nama-semester">{{ $data->nama_semesterperiode }}</div>
                            <div class="status">
                                Status : 
                                <a class="{{ $data->status_semesterperiode == "Aktif" ? 'aktif' : 'tidak-aktif' }}">{{ $data->status_semesterperiode }}</a>
                            </div>
                            <div class="button">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-semester-{{ $data->id }}">Edit</button>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-semester-{{ $data->id }}">Hapus</button>
                            </div>
                        </div>
                    </li>
                @endif
                @empty
                <li class="list-group-item text-center">
                    <div class="empty">
                        Belum ada semester periode
                    </div>
                </li>
            @endforelse
        </ul>
        <div class="alert d-flex">
            <span class="material-icons-outlined info-icon">info</span>
            <div class="info-text">
                Hanya semester berstatus aktif yang akan tampil di menu jadwal asisten, <br>
                Semester Ganjil -> (PTA) | Genap -> (ATA)
            </div>
        </div>
        @foreach ($semua_semesterperiode as $data)
            <div class="modal fade edit-semester" id="edit-semester-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Semester</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/pengaturan/semester/edit/{{$data->id}}" method="POST" id="form-editsemester">
                            @csrf
                            <div class="modal-body modal-body-1">
                                <input name="id" type="hidden" value="{{$data->id}}">
                                <div class="form-group">
                                    <label for="username" class="col col-form-label">Nama Semester</label>
                                    <input name="nama_semester" type="text" class="form-control text-center" id="nama_semester" autocomplete="off" value="{{ $data->nama_semesterperiode }}" readonly>
                                    <span class="text-danger error-text nama_semester_error" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col col-form-label">Status</label>
                                    <select class="form-control form-select {{ $data->status_semesterperiode == "Tidak Aktif" ? 'merah' : 'hijau' }}" name="status" id="status-semester{{ $data->id }}">
                                        @foreach(["Aktif" => "Aktif", "Tidak Aktif" => "Tidak Aktif"] as $statussemester)
                                        <option class="{{ $statussemester == "Tidak Aktif" ? 'merah' : 'hijau' }}" value="{{ $statussemester }}" {{ $data->status_semesterperiode == "Tidak Aktif" ? 'selected' : '' }}>{{$statussemester}}</option>
                                        @endforeach
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
        @foreach ($semua_semesterperiode as $data)
            <div class="modal fade" id="delete-semester-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Data Semester</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin menghapus "{{ $data->nama_semesterperiode }}" ?
                            <small id="" class="form-text text-muted">Perhatian !</small>
                            <small id="" class="form-text text-muted">Menghapus Semester {{ $data->nama_semesterperiode }} akan ikut menghapus seluruh jadwal asisten yang ada pada semester ini</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Tidak</button>
                            <a href="/pengaturan/semester/hapus/{{ $data->id }}" class="btn btn-outline-danger">Ya</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
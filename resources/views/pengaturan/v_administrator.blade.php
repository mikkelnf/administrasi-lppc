<div class="content-header administrator">Administrator</div>

<div class="daftar-administrator">
    @if(session('pesan-administrator'))
    <div class="alert alert-success" role="alert">
        <span class="delete-success">{{ session('pesan-administrator')}}</span>
    </div>
    @endif 
    <button type="button" class="btn btn-tambah btn-outline-dark" data-toggle="modal" data-target="#tambah-administrator">
        <span class="material-icons add">
            add
        </span>
    </button>
    @if(auth()->user()->id_role == 0)
        <div class="modal fade" id="tambah-administrator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('administrator.tambah-admin') }}" method="POST" id="form-tambahadministrator">
                        @csrf
                        <div class="modal-body modal-body-2">
                            <div class="alert alert-success collapse" role="alert" id="success-alert-administrator">
                                <span class="success-text"></span>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <input name="nama" type="text" class="form-control" id="nama" autocomplete="off">
                                <span class="text-danger error-text nama_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <input name="username" type="text" class="form-control" id="username" autocomplete="off">
                                <span class="text-danger error-text username_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <input name="password" type="password" class="form-control" id="password" autocomplete="off">
                                <span class="text-danger error-text password_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-12 col-form-label">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" class="form-control" id="password" autocomplete="off">
                                <span class="text-danger error-text password_confirmation_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <select class="form-control form-select" name="status" id="status-user">
                                    @foreach(["Staff Lab" => "Staff Lab", "Mahasiswa" => "Mahasiswa"] as $statususer)
                                        <option value="{{$statususer}}">{{$statususer}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 col-form-label">Role</label>
                                <select class="form-control form-select" name="id_role" id="role-user">
                                    @foreach(["Admin" => "Admin", "Asisten" => "Asisten"] as $rolesuser)
                                        <option value="{{$rolesuser == "Admin" ? 1 : 2}}">{{$rolesuser}}</option>
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
    @endif
    @if(auth()->user()->id_role == 1)
        <div class="modal fade" id="tambah-administrator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('administrator.tambah') }}" method="POST" id="form-tambahadministrator">
                        @csrf
                        <div class="modal-body modal-body-2">
                            <div class="alert alert-success collapse" role="alert" id="success-alert-administrator">
                                <span class="success-text"></span>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <input name="nama" type="text" class="form-control" id="nama" autocomplete="off">
                                <span class="text-danger error-text nama_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <input name="username" type="text" class="form-control" id="username" autocomplete="off">
                                <span class="text-danger error-text username_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <input name="password" type="password" class="form-control" id="password" autocomplete="off">
                                <span class="text-danger error-text password_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col col-form-label">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" class="form-control" id="password" autocomplete="off">
                                <span class="text-danger error-text password_confirmation_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 col-form-label">Status</label>
                                <input name="role_id" type="text" placeholder="Mahasiswa" class="form-control role" id="role" autocomplete="off" disabled>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 col-form-label">Role</label>
                                <input name="role_id" type="text" placeholder="Asisten" class="form-control role" id="role" autocomplete="off" disabled>
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
    @endif
    <ul class="list-group">
        @foreach ($super_admin as $data)
            <li class="list-group-item text-left">
                <div class="list-content row">
                    <div class="profile-icon">
                        <span class="material-icons">
                            account_circle
                        </span>
                    </div>
                    <div class="nama">{{ $data->nama_user }}</div>
                    <div class="status-user">({{ $data->status ? $data->status : '-'}})</div>
                    <div class="role">Role : {{ $data->roles->nama_role }}</div>
                </div>
            </li>
        @endforeach
        @foreach ($admin as $data)
            <li class="list-group-item text-left">
                <div class="list-content row">
                    <div class="profile-icon">
                        <span class="material-icons">
                            account_circle
                        </span>
                    </div>
                    <div class="nama">{{ $data->nama_user }}</div>
                    <div class="status-user">({{ $data->status}})</div>
                    <div class="role">Role : {{ $data->roles->nama_role }}</div>
                    @if(auth()->user()->id_role == 0)
                        <div class="button">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-admin{{ $data->id }}">Edit</button>
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-administrator-{{ $data->id }}">Hapus</button>
                        </div>
                    @endif
                </div>
            </li>
            <div class="modal fade" id="edit-admin{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Administrator</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/pengaturan/administrator/edit/{{$data->id}}" method="POST" id="form-editadmin">
                            @csrf
                            <div class="modal-body modal-body-2">
                                <div class="form-group">
                                    <input type="text" placeholder="{{ $data->nama_user }}" class="form-control role" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <select class="form-control form-select" name="status" id="status-user">
                                        @foreach(["Staff Lab" => "Staff Lab", "Mahasiswa" => "Mahasiswa"] as $statususer)
                                            <option value="{{$statususer}}" {{ $statususer == $data->status ? 'selected' : '' }}>{{$statususer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <select class="form-control form-select" name="id_role" id="role-user">
                                        @foreach(["Admin" => "Admin", "Asisten" => "Asisten"] as $rolesuser)
                                            <option value="{{$rolesuser == "Admin" ? 1 : 2}}" {{ $rolesuser == $data->id_role ? 'selected' : '' }}>{{$rolesuser}}</option>
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
        @foreach ($asisten as $data)
            @if($asisten->count() > 3)
                @if($asisten->count() == 4)
                    <li class="list-group-item text-left">
                        <div class="list-content row">
                            <div class="profile-icon">
                                <span class="material-icons">
                                    account_circle
                                </span>
                            </div>
                            <div class="nama">{{ $data->nama_user }}</div>
                            <div class="status-user">({{ $data->status}})</div>
                            <div class="role">Role : {{ $data->roles->nama_role }}</div>
                            <div class="button">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-admin{{ $data->id }}">Edit</button>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-administrator-{{ $data->id }}">Hapus</button>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="list-group-item text-left {{ $loop->iteration > 4 ? 'x hide' : '' }}">
                        <div class="list-content row">
                            <div class="profile-icon">
                                <span class="material-icons">
                                    account_circle
                                </span>
                            </div>
                            <div class="nama">{{ $data->nama_user }}</div>
                            <div class="status-user">({{ $data->status}})</div>
                            <div class="role">Role : {{ $data->roles->nama_role }}</div>
                            <div class="button">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-admin{{ $data->id }}">Edit</button>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-administrator-{{ $data->id }}">Hapus</button>
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
                        <div class="profile-icon">
                            <span class="material-icons">
                                account_circle
                            </span>
                        </div>
                        <div class="nama">{{ $data->nama_user }}</div>
                        <div class="status-user">({{ $data->status}})</div>
                        <div class="role">Role : {{ $data->roles->nama_role }}</div>
                        <div class="button">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-admin{{ $data->id }}">Edit</button>
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-administrator-{{ $data->id }}">Hapus</button>
                        </div>
                    </div>
                </li>
            @endif
            <div class="modal fade" id="edit-admin{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Administrator</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/pengaturan/administrator/edit/{{$data->id}}" method="POST" id="form-editadmin">
                            @csrf
                            <div class="modal-body modal-body-2">
                                <div class="form-group">
                                    <input type="text" placeholder="{{ $data->nama_user }}" class="form-control role" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <select class="form-control form-select" name="status" id="status-user">
                                        @foreach(["Staff Lab" => "Staff Lab", "Mahasiswa" => "Mahasiswa"] as $statususer)
                                            <option value="{{$statususer}}" {{ $statususer == $data->status ? 'selected' : '' }}>{{$statususer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <select class="form-control form-select" name="id_role" id="role-user">
                                        @foreach(["Admin" => "Admin", "Asisten" => "Asisten"] as $rolesuser)
                                            <option value="{{$rolesuser == "Admin" ? 1 : 2}}" {{ $loop->iteration == $data->id_role ? 'selected' : '' }}>{{$rolesuser}}</option>
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
    </ul>
    <div class="alert d-flex">
        <span class="material-icons-outlined info-icon">info</span>
        <div class="info-text">
            Administrator merupakan user yang mempunyai akses untuk login, <br>
            Setiap asisten hanya memiliki 1 akun
        </div>
    </div>
    @foreach ($administrator as $data)
    <div class="modal fade" id="delete-administrator-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Data Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin menghapus "{{$data->nama_user}}" ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Tidak</button>
                    <a href="/pengaturan/administrator/hapus/{{$data->id}}" class="btn btn-outline-danger">Ya</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


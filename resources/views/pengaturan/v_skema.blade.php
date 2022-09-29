<div class="content-header kursus">Skema</div>

<div class="daftar-skema">
    <div class="alert alert-success collapse" role="alert" id="success-alert-skema">
        <span class="delete-success tambah-sukses-skema"></span>
    </div>
</div>

<div id="daftar-skema">
    <div class="daftar-skema">
        @if(session('pesan-skema'))
            <div class="alert alert-success" role="alert">
                <span class="delete-success">{{ session('pesan-skema')}}</span>
            </div>
        @endif 
        @if(session('pesan-skema-error'))
            <div class="alert alert-danger" role="alert">
                <span class="delete-success">{{ session('pesan-skema-error')}}</span>
            </div>
        @endif 
        <button type="button" class="btn btn-tambah btn-outline-dark" data-toggle="modal" data-target="#tambah-skema">
            <span class="material-icons add">
                add
            </span>
        </button>
        <div class="modal fade" id="tambah-skema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Skema</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('skema.tambah') }}" method="POST" id="form-tambahskema">
                        @csrf
                        <div class="modal-body modal-body-1">
                            <div class="form-group">
                                <label for="nama_skema" class="col col-form-label">Nama Skema</label>
                                <input name="nama_skema" type="text" class="form-control" id="nama_skema" autocomplete="off">
                                <small class="form-text text-muted">Contoh : 3D Illustration Artist</small>
                                <span class="text-danger error-text nama_skema_error" role="alert"></span>
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
            @forelse ($skema as $data)
                @if($skema->count() > 3)
                    @if($skema->count() == 4)
                        <li class="list-group-item text-left">
                            <div class="list-content row">
                                <span class="material-icons-outlined skema-icon">
                                    api
                                </span>
                                <div class="nama-skema">{{ $data->nama_skema }}</div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-skema-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-skema-{{ $data->id }}">Hapus</button>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="list-group-item text-left {{ $loop->iteration > 4 ? 'x hide' : '' }}">
                            <div class="list-content row">
                                <span class="material-icons-outlined skema-icon">
                                    api
                                </span>
                                <div class="nama-skema">{{ $data->nama_skema }}</div>
                                <div class="button">
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-skema-{{ $data->id }}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-skema-{{ $data->id }}">Hapus</button>
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
                            <span class="material-icons-outlined skema-icon">
                                api
                            </span>
                            <div class="nama-skema">{{ $data->nama_skema }}</div>
                            <div class="button">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit-skema-{{ $data->id }}">Edit</button>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-skema-{{ $data->id }}">Hapus</button>
                            </div>
                        </div>
                    </li>
                @endif
                @empty
                <li class="list-group-item text-center">
                    <div class="empty">
                        Belum ada skema
                    </div>
                </li>
            @endforelse
        </ul>
        @foreach ($skema as $data)
            <div class="modal fade edit-skema" id="edit-skema-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit skema</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/pengaturan/skema/edit/{{$data->id}}" method="POST" id="form-editskema{{ $data->id }}">
                            @csrf
                            <div class="modal-body modal-body-1">
                                <input name="id" type="hidden" value="{{$data->id}}">
                                <div class="form-group">
                                    <label for="username" class="col col-form-label">Nama skema</label>
                                    <input name="nama_skema" type="text" class="form-control text-center" id="nama_skema" autocomplete="off" value="{{ $data->nama_skema }}">
                                    <span class="text-danger error-text nama_skema_error" role="alert"></span>
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
        @foreach ($skema as $data)
            <div class="modal fade" id="delete-skema-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title title-delete" id="exampleModalLabel">Hapus Data skema</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin menghapus "{{ $data->nama_skema }}" ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal" style="color: rgb(71, 71, 71);">Tidak</button>
                            <a href="/pengaturan/skema/hapus/{{ $data->id }}" class="btn btn-outline-danger">Ya</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
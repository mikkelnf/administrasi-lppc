<div class="content-header kursus">Kursus Saat Ini</div>

<div class="kursus-aktif">
    <input class="form-control" id="disabledInput" type="text" placeholder="{{ $kursus_sekarang->id_semesterperiode == null ? '-' : $kursus_sekarang->semesterperiode->nama_semesterperiode }}" disabled>
    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#edit-kursus">Edit</button>
</div>
<div class="modal fade" id="edit-kursus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Kursus Saat Ini</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/pengaturan/edit-kursus/{{ $kursus_id }}" method="post">
            @csrf
            <div class="modal-body modal-body-1">
                <div class="form-group">
                    <label for="nama" class="col col-form-label">Pilih semester periode yang sedang berjalan</label>
                    <select class="form-control form-select" name="id_semesterperiode" id="">
                        <option value="" {{ $kursus_sekarang == null ? 'selected' : '' }}>-</option>
                        @foreach($semesterperiode_aktif as $data)
                        <option value="{{ $data->id }}" {{ $kursus_sekarang == null ? '' : ($kursus_sekarang->id_semesterperiode == $data->id ? 'selected' : '') }}>{{ $data->nama_semesterperiode }}</option>
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
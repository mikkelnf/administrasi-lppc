<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'npm_peserta',
        'nama_peserta',
        'notelp_peserta',
        'email_peserta',
        'kelas_peserta',
    ];

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema');
    }
    public function asisten()
    {
        return $this->belongsTo(User::class, 'id_asisten'); 
    }
    public function semester1()
    {
        return $this->belongsTo(TugasPesertaSem1::class, 'id_peserta');
    }
    public function semester2()
    {
        return $this->belongsTo(TugasPesertaSem2::class, 'id_peserta');
    }
    public function semester3()
    {
        return $this->belongsTo(TugasPesertaSem3::class, 'id_peserta');
    }
    public function semester4()
    {
        return $this->belongsTo(TugasPesertaSem4::class, 'id_peserta');
    }
    public function semester5()
    {
        return $this->belongsTo(TugasPesertaSem5::class, 'id_peserta');
    }
    public function semester6()
    {
        return $this->belongsTo(TugasPesertaSem6::class, 'id_peserta');
    }
    public function semester7()
    {
        return $this->belongsTo(TugasPesertaSem7::class, 'id_peserta');
    }
    public function semester8()
    {
        return $this->belongsTo(TugasPesertaSem8::class, 'id_peserta');
    }
    public function semesterkehadiran()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'kehadiran_peserta', 'id_peserta', 'id_semesterkuliah')
        ->withPivot(['pertemuan_1', 'pertemuan_2', 'pertemuan_3', 'pertemuan_4', 'pertemuan_5', 'pertemuan_6', 'pertemuan_7', 'pertemuan_8', 'pertemuan_9', 'pertemuan_10'])
        ->using(KehadiranPeserta::class);
    }
    public function semestertugas()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'tugas_peserta', 'id_peserta', 'id_semesterkuliah')
        ->withPivot(['tugas_1', 'tugas_2', 'tugas_3', 'tugas_4', 'tugas_5', 'tugas_6', 'tugas_7', 'tugas_8', 'tugas_9', 'tugas_10', 'tugas_11', 'tugas_12', 'tugas_13', 'tugas_14']);
    }
    public function jadwal()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'peserta_jadwalkursus', 'id_peserta', 'id_jadwalkursus')
        ->using(PesertaJadwalkursus::class);
    }

    public function rapor()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'rapor_peserta', 'id_peserta', 'id_semesterkuliah');
    }
}

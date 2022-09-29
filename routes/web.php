<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DaftarStaffController;
use App\Http\Controllers\DetailTugasController;
use App\Http\Controllers\JadwalAsistenController;
use App\Http\Controllers\JadwalKursusController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KehadiranPesertaController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\EvaluasiTugasController;
use App\Http\Controllers\KelulusanPesertaController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PesertaAngkatanController;
use App\Http\Controllers\PesertaKeseluruhanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\RaporPesertaController;
use App\Http\Controllers\SemesterPeriodeController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\TugasPesertaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginuser']);
Route::get('/logout', [LoginController::class, 'logoutuser'])->name('logout');

Route::group(['middleware' => ['auth', 'rolecheck:0,1']], function(){
    Route::get('/pengaturan', [PengaturanController::class, 'index']);
        
    Route::post('/pengaturan/edit-kursus/{id}', [PengaturanController::class, 'edit_semesterberjalan']);

    Route::get('/pengaturan/administrator', [UserController::class, 'index']);
    Route::post('/pengaturan/administrator', [UserController::class, 'store'])->name('administrator.tambah');
    Route::post('/pengaturan/administrator/admin', [UserController::class, 'store_admin'])->name('administrator.tambah-admin');
    Route::post('/pengaturan/administrator/edit/{id}', [UserController::class, 'edit']);
    Route::get('/pengaturan/administrator/hapus/{id}', [UserController::class, 'destroy']);

    Route::get('/pengaturan/angkatan', [AngkatanController::class, 'index']);
    Route::post('/pengaturan/angkatan', [AngkatanController::class, 'store'])->name('angkatan.tambah');
    Route::post('/pengaturan/angkatan/edit/{id}', [AngkatanController::class, 'edit']);
    Route::get('/pengaturan/angkatan/hapus/{id}', [AngkatanController::class, 'destroy']);

    Route::get('/pengaturan/semester', [SemesterPeriodeController::class, 'index']);
    Route::post('/pengaturan/semester', [SemesterPeriodeController::class, 'store'])->name('semester.tambah');
    Route::post('/pengaturan/semester/edit/{id}', [SemesterPeriodeController::class, 'edit']);
    Route::get('/pengaturan/semester/hapus/{id}', [SemesterPeriodeController::class, 'destroy']);

    Route::get('/pengaturan/skema', [SkemaController::class, 'index']);
    Route::post('/pengaturan/skema', [SkemaController::class, 'store'])->name('skema.tambah');
    Route::post('/pengaturan/skema/edit/{id}', [SkemaController::class, 'edit']);
    Route::get('/pengaturan/skema/hapus/{id}', [SkemaController::class, 'destroy']);

    Route::post('/tugas/angkatan/{angkatan:tahun_angkatan}/semester/{semester}', [DetailTugasController::class, 'edit1']);
    Route::post('/kelompok-asistensi/asisten/{user:id}/tugas/semester/{semester}', [DetailTugasController::class, 'edit2']);
});

Route::group(['middleware' => ['auth', 'rolecheck:0,1,2']], function(){
    Route::get('/', [BerandaController::class, 'index']);

    Route::get('/staff', [DaftarStaffController::class, 'index']);
        
    Route::get('/peserta', [PesertaKeseluruhanController::class, 'index']);

    Route::get('/berkas', [BerkasController::class, 'index']);

    Route::redirect('/akun', '/akun/profil');
    Route::get('/akun/profil', [ProfilController::class, 'index']);
    Route::post('/akun/profil/edit-{id}', [ProfilController::class, 'update']);
    Route::get('/akun/password', [PasswordController::class, 'index']);
    Route::patch('/akun/password/edit-{id}', [PasswordController::class, 'update']);

    Route::get('/peserta/angkatan', [PesertaAngkatanController::class, 'index']);
    Route::get('/peserta/angkatan/{angkatan:tahun_angkatan}', [PesertaAngkatanController::class, 'show']);
    Route::post('/peserta/angkatan/{angkatan:tahun_angkatan}', [PesertaAngkatanController::class, 'store'])->name('peserta.tambah');
    Route::post('/peserta/angkatan/{angkatan:tahun_angkatan}/edit/{peserta:id}', [PesertaAngkatanController::class, 'edit']);
    Route::get('/peserta/angkatan/{angkatan:tahun_angkatan}/hapus/{peserta:id}', [PesertaAngkatanController::class, 'destroy']);

    Route::get('/kehadiran/angkatan', [KehadiranController::class, 'index']);
    Route::get('/kehadiran/angkatan/{angkatan:tahun_angkatan}', [KehadiranController::class, 'show']);
    Route::get('/kehadiran/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/', [KehadiranPesertaController::class, 'index']);
    Route::get('/kehadiran/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}', [KehadiranPesertaController::class, 'show']);
    Route::get('/kehadiran/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/laporan', [KehadiranPesertaController::class, 'laporan_kehadiran']);
    Route::post('/kehadiran/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/edit/{peserta:id}', [KehadiranPesertaController::class, 'edit']);

    Route::get('/tugas/angkatan', [TugasController::class, 'index']);
    Route::get('/tugas/angkatan/{angkatan:tahun_angkatan}', [TugasController::class, 'show']);
    Route::get('/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/', [TugasPesertaController::class, 'index']);
    Route::get('/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}', [TugasPesertaController::class, 'show']);
    Route::get('/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/laporan', [TugasPesertaController::class, 'laporan_tugas']);
    Route::post('/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/edit/{peserta:id}', [TugasPesertaController::class, 'edit']);

    Route::get('/evaluasi/tugas/angkatan', [EvaluasiTugasController::class, 'menu_angkatan']);
    Route::get('/evaluasi/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}', [EvaluasiTugasController::class, 'menu_modul']);
    Route::get('/evaluasi/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/modul/', [EvaluasiTugasController::class, 'menu_modul']);
    Route::get('/evaluasi/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/modul/{semester}', [EvaluasiTugasController::class, 'show']);
    Route::get('/evaluasi/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/modul/{semester}/laporan', [EvaluasiTugasController::class, 'laporan']);
    Route::post('/evaluasi/tugas/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/modul/{semester}/edit/{peserta:id}', [EvaluasiTugasController::class, 'edit']);

    Route::get('/rapor/angkatan', [RaporController::class, 'index']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}', [RaporController::class, 'show']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/', [RaporPesertaController::class, 'index']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}', [RaporPesertaController::class, 'show']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/laporan', [RaporPesertaController::class, 'laporan_semester']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/semester/rangkuman', [RaporPesertaController::class, 'rangkuman']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/{rapor_peserta}', [RaporPesertaController::class, 'rapor_peserta']);
    Route::get('/rapor/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/{rapor_peserta}/print', [RaporPesertaController::class, 'print']);
    Route::post('/rapor/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/{rapor_peserta}', [RaporPesertaController::class, 'edit']);
    Route::post('/rapor/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/semesterperiode', [RaporPesertaController::class, 'edit_semesterperiode']);
    Route::post('/rapor/angkatan/{angkatan:tahun_angkatan}/skema/s-0{skema}/semester/{semester}/pertemuan/{id}', [RaporPesertaController::class, 'edit_pertemuan']);

    Route::get('/kelulusan-peserta/angkatan', [KelulusanPesertaController::class, 'index']);
    Route::get('/kelulusan-peserta/angkatan/{angkatan:tahun_angkatan}', [KelulusanPesertaController::class, 'show']);
    Route::get('/kelulusan-peserta/angkatan/{angkatan:tahun_angkatan}/laporan', [KelulusanPesertaController::class, 'laporan_kelulusan']);

    Route::get('/kelompok-asistensi/asisten', [KelompokController::class, 'index']);
    Route::get('/kelompok-asistensi/asisten/{user:id}/peserta', [KelompokController::class, 'peserta']);
    Route::post('/kelompok-asistensi/asisten/{user:id}/peserta', [KelompokController::class, 'peserta_tambah']);
    Route::post('/kelompok-asistensi/asisten/{user:id}/peserta/edit/{peserta:id}', [KelompokController::class, 'peserta_edit']);
    Route::get('/kelompok-asistensi/asisten/{user:id}/kehadiran/semester/', [KelompokController::class, 'kehadiran']);
    Route::get('/kelompok-asistensi/asisten/{user:id}/kehadiran/semester/{semester}', [KelompokController::class, 'kehadiran_semester']);
    Route::post('/kelompok-asistensi/asisten/{user:id}/kehadiran/semester/{semester:id}/edit/{peserta:id}', [KelompokController::class, 'edit_kehadiran']);
    Route::get('/kelompok-asistensi/asisten/{user:id}/tugas/semester/', [KelompokController::class, 'tugas']);
    Route::get('/kelompok-asistensi/asisten/{user:id}/tugas/semester/{semester}', [KelompokController::class, 'tugas_semester']);
    Route::post('/kelompok-asistensi/asisten/{user:id}/tugas/semester/{semester:id}/edit/{peserta:id}', [KelompokController::class, 'edit_tugas']);

    Route::get('/jadwal-kursus/angkatan', [JadwalKursusController::class, 'index']);
    Route::get('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/', [JadwalKursusController::class, 'semester_menu']);
    Route::get('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}', [JadwalKursusController::class, 'jadwal_menu']);
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/catatan', [JadwalKursusController::class, 'edit_catatan']);
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/tambah', [JadwalKursusController::class, 'tambah_jadwal']);
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/edit/jadwal-{jadwal_kursus}', [JadwalKursusController::class, 'edit_jadwal']);
    Route::get('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/jadwal-{jadwal_kursus}/hapus', [JadwalKursusController::class, 'hapus_jadwal']);
    Route::get('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/jadwal-{jadwal_kursus}', [JadwalKursusController::class, 'jadwal_detail']);
    Route::get('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/semua-jadwal', [JadwalKursusController::class, 'semua_jadwal'])->name('jadwalkursus-htmlPdf');
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/jadwal-{jadwal_kursus}', [JadwalKursusController::class, 'tambah_peserta']);
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/jadwal-{jadwal_kursus}/hapus-{jadwal_peserta}', [JadwalKursusController::class, 'hapus_peserta']);
    Route::post('/jadwal-kursus/angkatan/{angkatan:tahun_angkatan}/semester/{semester}/jadwal-{jadwal_kursus}/input-kehadiran', [JadwalKursusController::class, 'input_kehadiran']);

    Route::get('/jadwal-asisten/semester', [JadwalAsistenController::class, 'index']);
    Route::get('/jadwal-asisten/semester/{semesterperiode}/pertemuan', [JadwalAsistenController::class, 'pertemuan_menu']);
    Route::get('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}', [JadwalAsistenController::class, 'jadwal_menu']);
    Route::post('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}/edit/periode', [JadwalAsistenController::class, 'edit_periode']);
    Route::post('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}/tambah-jadwal', [JadwalAsistenController::class, 'tambah_jadwal']);
    Route::post('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}/edit-jadwal/{jadwal_asisten}', [JadwalAsistenController::class, 'edit_jadwal']);
    Route::get('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}/hapus-jadwal/{jadwal_asisten}', [JadwalAsistenController::class, 'hapus_jadwal']);
    Route::get('/jadwal-asisten/semester/{semesterperiode}/pertemuan/{pertemuan}/semua-jadwal', [JadwalAsistenController::class, 'semua_jadwal'])->name('jadwal.asisten');
});
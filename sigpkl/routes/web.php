<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\CalendarsController;
use App\Http\Controllers\ChoicesController;
use App\Http\Controllers\EnigmasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustriesController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MyjobsController;
use App\Http\Controllers\MykuizsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlacementsController;
use App\Http\Controllers\PresencesController;
use App\Http\Controllers\PresentationsController;
use App\Http\Controllers\QuizzesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ScoresController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\UsersControler;
use App\Http\Controllers\VisitsController;

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

// sistem auth (login, registrasi, lupa sandi)
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('flogin');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('flogin');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('google_login');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback'])->name('google_callback');

Route::get('/bantuan', [App\Http\Controllers\HomeController::class, 'bantuan'])->name('bantuan');


Route::get('/registrasi', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('fregistrasi');
Route::get('/registrasi_admin', [App\Http\Controllers\Auth\RegisterController::class, 'registrasi_admin'])->name('fregistrasi_admin');
Route::post('/regist_admin', [App\Http\Controllers\Auth\RegisterController::class, 'regist_admin'])->name('regist_admin');
Route::post('/regist_guru', [App\Http\Controllers\Auth\RegisterController::class, 'regist_guru'])->name('regist_guru');
Route::post('/regist_industri', [App\Http\Controllers\Auth\RegisterController::class, 'regist_industri'])->name('regist_industri');
Route::post('/regist_siswa', [App\Http\Controllers\Auth\RegisterController::class, 'regist_siswa'])->name('regist_siswa');

Route::get('/forgot', [App\Http\Controllers\Auth\ResetPasswordController::class, 'forgot'])->name('forgot');

Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');



// User Admin

// Data Siswa
Route::get('/kelola_data_siswa', [App\Http\Controllers\StudentsController::class, 'index'])->name('kd_siswa');
Route::get('/tambah_siswa', [App\Http\Controllers\StudentsController::class, 'create'])->name('tbh_siswa');
Route::post('/tambah_siswa', [App\Http\Controllers\StudentsController::class, 'store'])->name('store_siswa');
Route::get('/edit_siswa/{student}', [App\Http\Controllers\StudentsController::class, 'edit']);
Route::post('/edit_siswa', [App\Http\Controllers\StudentsController::class, 'update'])->name('update_siswa');
Route::get('/detail_siswa/{student}', [App\Http\Controllers\StudentsController::class, 'show']);
Route::delete('/hapus_siswa/{student}', [App\Http\Controllers\StudentsController::class, 'destroy']);

// Data Guru
Route::get('/kelola_data_guru', [App\Http\Controllers\TeachersController::class, 'index'])->name('kd_guru');
Route::get('/detail_guru/{teacher}', [App\Http\Controllers\TeachersController::class, 'show'])->name('detail_guru');
Route::get('/tambah_guru', [App\Http\Controllers\TeachersController::class, 'create'])->name('tbh_guru');
Route::post('/tambah_guru', [App\Http\Controllers\TeachersController::class, 'store'])->name('store_guru');
Route::get('/edit_guru/{teacher}', [App\Http\Controllers\TeachersController::class, 'edit']);
Route::post('/edit_guru', [App\Http\Controllers\TeachersController::class, 'update'])->name('update_guru');
Route::delete('/hapus_guru/{teacher}', [App\Http\Controllers\TeachersController::class, 'destroy']);

// Data Industri
Route::get('/kelola_data_industri', [App\Http\Controllers\IndustriesController::class, 'index'])->name('kd_industri');
Route::get('/detail_industri/{industrie}', [App\Http\Controllers\IndustriesController::class, 'show']);
Route::get('/tambah_industri', [App\Http\Controllers\IndustriesController::class, 'create'])->name('tbh_industri');
Route::post('/tambah_industri', [App\Http\Controllers\IndustriesController::class, 'store'])->name('store_industri');
Route::get('/edit_industri/{industrie}', [App\Http\Controllers\IndustriesController::class, 'edit']);
Route::post('/edit_industri', [App\Http\Controllers\IndustriesController::class, 'update'])->name('update_indu');
Route::delete('/hapus_industri/{industrie}', [App\Http\Controllers\IndustriesController::class, 'destroy']);

// Data penempatan
Route::get('/kelola_data_penempatan', [App\Http\Controllers\PlacementsController::class, 'index'])->name('kd_penempatan');
Route::get('/tambah_penempatan', [App\Http\Controllers\PlacementsController::class, 'create'])->name('tbh_penempatan');
Route::post('/tambah_penempatan', [App\Http\Controllers\PlacementsController::class, 'store'])->name('store_penempatan');
Route::get('/edit_penempatan/{placement}', [App\Http\Controllers\PlacementsController::class, 'edit']);
Route::post('/edit_penempatan', [App\Http\Controllers\PlacementsController::class, 'update'])->name('update_penempatan');
Route::get('/detail_penempatan/{placement}', [App\Http\Controllers\PlacementsController::class, 'show']);

// Akses Menu
Route::get('/akses_menu', [App\Http\Controllers\MenusController::class, 'index'])->name('akses_menu');
Route::post('/aktif_menu', [App\Http\Controllers\MenusController::class, 'aktif'])->name('aktif_menu');

// pengajuan siswa
Route::get('/pengajuan_siswa', [App\Http\Controllers\SubmissionsController::class, 'index'])->name('ajuan_siswa');
Route::get('/detail_pengajuan/{id}', [App\Http\Controllers\SubmissionsController::class, 'detail_pengajuan']);

// penentuan penguji
Route::get('/penentuan_penguji', [App\Http\Controllers\PlacementsController::class, 'penentuan_penguji'])->name('penentuan_penguji');
Route::get('/edit_penguji/{id}', [App\Http\Controllers\PlacementsController::class, 'edit_penguji']);
Route::post('/edit_penguji', [App\Http\Controllers\TestsController::class, 'update'])->name('update_penguji');

// laporan nilai
Route::get('/laporan_nilai', [App\Http\Controllers\ScoresController::class, 'index'])->name('lapnil');
Route::get('/detail_nilai/{score}', [App\Http\Controllers\ScoresController::class, 'show']);
Route::get('/edit_nilai/{score}', [App\Http\Controllers\ScoresController::class, 'edit']);
Route::post('/edit_nilai', [App\Http\Controllers\ScoresController::class, 'update'])->name('update_nilai');

// User Guru
// Kunjungan
Route::get('/kunjungan', [App\Http\Controllers\VisitsController::class, 'index'])->name('kunjungan');
Route::get('/tambah_kunjungan', [App\Http\Controllers\VisitsController::class, 'create'])->name('tbh_kunjungan');
Route::post('/tambah_kunjungan', [App\Http\Controllers\VisitsController::class, 'store'])->name('store_kunjungan');
Route::get('/detail_kunjungan/{visit}', [App\Http\Controllers\VisitsController::class, 'show']);
Route::get('/edit_kunjungan/{visit}', [App\Http\Controllers\VisitsController::class, 'edit']);
Route::post('/edit_kunjungan', [App\Http\Controllers\VisitsController::class, 'update'])->name('update_kunjungan');

// pengujian
Route::get('/pengujian', [App\Http\Controllers\TestsController::class, 'uji'])->name('pengujian');
Route::post('/nilai_pengujian', [App\Http\Controllers\ScoresController::class, 'store'])->name('nilai_pengujian');

// user industri
// pengajuan
Route::get('/pengajuan', [App\Http\Controllers\SubmissionsController::class, 'pengajuan'])->name('pengajuan');
Route::post('/terima_pengajuan', [App\Http\Controllers\SubmissionsController::class, 'terima_pengajuan'])->name('terima_pengajuan');
Route::post('/tolak_pengajuan', [App\Http\Controllers\SubmissionsController::class, 'tolak_pengajuan'])->name('tolak_pengajuan');

// user siswa
// nilai
Route::get('/nilai_saya', [App\Http\Controllers\ScoresController::class, 'nilai_saya'])->name('nilai_saya');

// pilih industri
Route::get('/pilih_lokasi', [App\Http\Controllers\IndustriesController::class, 'pilih_industri'])->name('plh_industri');
Route::get('/mengajukan/{idi}', [App\Http\Controllers\SubmissionsController::class, 'create']);
Route::post('/mengajukan', [App\Http\Controllers\SubmissionsController::class, 'store'])->name('store_ajuan');
Route::get('/print_ajuan_saya/{idi}', [App\Http\Controllers\SubmissionsController::class, 'print']);
Route::get('/print_balasan_saya/{idi}', [App\Http\Controllers\SubmissionsController::class, 'print_balasan']);

// presentasi
Route::get('/presentasi', [App\Http\Controllers\PresentationsController::class, 'presentasi'])->name('presentasi');
Route::post('/store_presentasi', [App\Http\Controllers\PresentationsController::class, 'store'])->name('store_presentasi');
Route::get('/edit_presentasi/{presentation}', [App\Http\Controllers\PresentationsController::class, 'edit']);
Route::post('/update_presentasi', [App\Http\Controllers\PresentationsController::class, 'update'])->name('update_presentasi');
Route::get('/lihat_ppt/{presentation}', [App\Http\Controllers\PresentationsController::class, 'lihat_ppt']);

Auth::routes();

// multi user
// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// profil
Route::get('/profil', [App\Http\Controllers\UsersControler::class, 'profil'])->name('profil');
Route::get('/edit_profil', [App\Http\Controllers\UsersControler::class, 'edit_profil'])->name('edit_profil');
Route::post('/edit_profil', [App\Http\Controllers\UsersControler::class, 'update'])->name('simpan');
Route::get('/ganti_username_password', [App\Http\Controllers\UsersControler::class, 'ganti_usswrd'])->name('ganti_usswrd');
Route::post('/reset_username', [App\Http\Controllers\UsersControler::class, 'reset_username'])->name('reset_username');
Route::post('/reset_password', [App\Http\Controllers\UsersControler::class, 'reset_password'])->name('reset_password');

// data siswa
Route::get('/data_siswa', [App\Http\Controllers\PlacementsController::class, 'data_siswa'])->name('data_siswa');

// absensi
Route::get('/absensi', [App\Http\Controllers\CalendarsController::class, 'absensi'])->name('absensi');
Route::post('/masuk', [App\Http\Controllers\CalendarsController::class, 'store'])->name('masuk');
Route::post('/libur', [App\Http\Controllers\CalendarsController::class, 'store'])->name('libur');
Route::post('/hadir', [App\Http\Controllers\PresencesController::class, 'store'])->name('hadir');
Route::get('/kehadiran/{id}', [App\Http\Controllers\CalendarsController::class, 'kehadiran']);
Route::post('/hadirkan', [App\Http\Controllers\PresencesController::class, 'update'])->name('hadirkan');
Route::post('/tidak_hadir', [App\Http\Controllers\PresencesController::class, 'update'])->name('tidak_hadir');

// tugas
Route::get('/tugas_siswa', [App\Http\Controllers\TasksController::class, 'tugas_siswa'])->name('tugas');
Route::get('/buat_tugas', [App\Http\Controllers\TasksController::class, 'create'])->name('buat_tugas');
Route::post('/buat_tugas', [App\Http\Controllers\TasksController::class, 'store'])->name('store_tugas');
Route::get('/edit_tugas/{task}', [App\Http\Controllers\TasksController::class, 'edit']);
Route::post('/edit_tugas', [App\Http\Controllers\TasksController::class, 'update'])->name('update_tugas');
Route::post('/serahkan', [App\Http\Controllers\MyjobsController::class, 'serahkan'])->name('serahkan_tugas');
Route::get('/hasil_kerja/{id}', [App\Http\Controllers\MyjobsController::class, 'hasil_kerja']);
Route::post('/nilai_tugas', [App\Http\Controllers\MyjobsController::class, 'update'])->name('nilai_tugas');
Route::get('/file_tugas/{Myjob}', [App\Http\Controllers\MyjobsController::class, 'file_tugas']);

// kuis
Route::get('/buat_kuis/{idk}', [App\Http\Controllers\QuizzesController::class, 'create'])->name('buat_kuis');
Route::post('/buat_kuis', [App\Http\Controllers\QuizzesController::class, 'store'])->name('store_kuis');
Route::post('/edit_buat_kuis', [App\Http\Controllers\QuizzesController::class, 'update_buat_kuis'])->name('update_buat_kuis');
Route::post('/buat_tanyaan', [App\Http\Controllers\EnigmasController::class, 'store'])->name('store_tanyaan');
Route::post('/edit_buat_tanyaan', [App\Http\Controllers\EnigmasController::class, 'update_buat_tanyaan'])->name('update_buat_tanyaan');
Route::post('/edit_buat_pilihan', [App\Http\Controllers\ChoicesController::class, 'update_buat_pilihan'])->name('update_buat_pilihan');
Route::post('/tambah_edit_buat_pilihan', [App\Http\Controllers\ChoicesController::class, 'str_edit_buat_pilihan'])->name('str_edit_buat_pilihan');
Route::delete('/hapus_tanyaan_buat/{enigma}', [App\Http\Controllers\EnigmasController::class, 'destroy_buat']);
Route::delete('/hapus_pilihan_buat/{choice}', [App\Http\Controllers\ChoicesController::class, 'destroy_buat']);

Route::delete('/hapus_tanyaan/{enigma}', [App\Http\Controllers\EnigmasController::class, 'destroy']);
Route::delete('/hapus_pilihan/{choice}', [App\Http\Controllers\ChoicesController::class, 'destroy']);

Route::get('/edit_kuis/{quiz}', [App\Http\Controllers\QuizzesController::class, 'edit'])->name('edit_kuis');
Route::post('/edit_kuis', [App\Http\Controllers\QuizzesController::class, 'update'])->name('update_kuis');
Route::post('/edit_tanyaan', [App\Http\Controllers\EnigmasController::class, 'update'])->name('update_tanyaan');
Route::post('/tambah_edit_tanyaan', [App\Http\Controllers\EnigmasController::class, 'store_edit_tanyaan'])->name('store_edit_tanyaan');
Route::post('/edit_pilihan', [App\Http\Controllers\ChoicesController::class, 'update'])->name('update_pilihan');
Route::post('/tambah_edit_pilihan', [App\Http\Controllers\ChoicesController::class, 'store'])->name('store_edit_pilihan');

Route::get('/mengisi_kuis/{quiz}', [App\Http\Controllers\QuizzesController::class, 'isiKuis']);
Route::post('/serahkan_isi_kuis', [App\Http\Controllers\AnswersController::class, 'store'])->name('isi_kuis');

Route::get('/hasil_kuis/{id}', [App\Http\Controllers\MyquizzesController::class, 'hasil_kuis']);

// laporan
Route::get('/laporan', [App\Http\Controllers\ReportsController::class, 'laporan'])->name('laporan');
Route::post('/store_laporan', [App\Http\Controllers\ReportsController::class, 'store'])->name('store_laporan');
Route::get('/edit_laporan/{report}', [App\Http\Controllers\ReportsController::class, 'edit']);
Route::post('/edit_laporan', [App\Http\Controllers\ReportsController::class, 'update'])->name('edit_laporan');
Route::post('/respon_laporan', [App\Http\Controllers\ReportsController::class, 'respon_laporan'])->name('respon_laporan');
Route::get('/lihat_laporan/{report}', [App\Http\Controllers\ReportsController::class, 'lihat_laporan']);

// penilaian
Route::get('/penilaian', [App\Http\Controllers\PlacementsController::class, 'penilaian'])->name('penilaian');
Route::get('/beri_penilaian/{id}', [App\Http\Controllers\ScoresController::class, 'beri_penilaian']);
Route::post('/nilai_penilaian', [App\Http\Controllers\ScoresController::class, 'nilai_penilaian'])->name('nilai_penilaian');

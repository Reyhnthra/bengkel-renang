<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CoachAuthController;
use App\Http\Controllers\CoachDashboardController;

/*
|--------------------------------------------------------------------------
| 1. PORTAL ORANG TUA / PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
// Halaman Landing Page Utama
Route::get('/', [TrackingController::class, 'index'])->name('landing');

// Proses saat orang tua klik tombol 'View Progress' (Mencari ID)
Route::post('/track', [TrackingController::class, 'search'])->name('track.search');

// Halaman Hasil Progress Anak jika ID ditemukan
Route::get('/track/{code}', [TrackingController::class, 'show'])->name('track.show');


/*
|--------------------------------------------------------------------------
| 2. PORTAL AUTH PELATIH (GUEST ACCESS)
|--------------------------------------------------------------------------
*/
// Menampilkan form login pelatih
Route::get('/coach/login', [CoachAuthController::class, 'showLogin'])->name('coach.login');

// Memproses data form login pelatih saat disubmit
Route::post('/coach/login', [CoachAuthController::class, 'login'])->name('coach.login.submit');


/*
|--------------------------------------------------------------------------
| 3. PORTAL INTERNAL PELATIH (PROTECTED VIA MIDDLEWARE ALIAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['coach.auth'])->group(function () {
    
    // Halaman Utama Pelatih (Overview & Grafik Agregat)
    Route::get('/coach/dashboard', [CoachDashboardController::class, 'overview'])->name('coach.dashboard');
    
    // Halaman Manajemen Daftar Siswa & Aksi Simpan Siswa Baru
    Route::get('/coach/students', [CoachDashboardController::class, 'students'])->name('coach.students');
    Route::post('/coach/students/store', [CoachDashboardController::class, 'storeStudent'])->name('coach.students.store');
    
    // Halaman Jurnal Absensi + Input Slider Nilai Gaya Renang harian
    Route::get('/coach/attendance', [CoachDashboardController::class, 'attendance'])->name('coach.attendance');
    Route::post('/coach/attendance/store', [CoachDashboardController::class, 'storeSession'])->name('coach.attendance.store');
    Route::get('/coach/student-data/{id}', [CoachDashboardController::class, 'getStudentData'])->name('coach.student.data');
    
    
    // Aksi Logout Akun Pelatih
    Route::post('/coach/logout', [CoachAuthController::class, 'logout'])->name('coach.logout');


    
});
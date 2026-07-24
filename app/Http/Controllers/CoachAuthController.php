<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachAuthController extends Controller
{
    // 1. Fungsi menampilkan halaman login pelatih
    public function showLogin()
    {
        return view('coach.login');
    }

    // 2. Logika validasi akun Mr Iqbal / Pelatih
    public function login(Request $request)
    {
        // Validasi format email dan pin wajib diisi
        $request->validate([
            'email' => 'required|email',
            'pin'   => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format alamat email salah!',
            'pin.required'   => 'PIN akses wajib diisi!',
        ]);

        // Pengaman: Cek kredensial dengan perbandingan constant-time untuk mencegah timing attack
        $targetEmail = config('app.coach_email', 'iqbal@bengkelrenang.com');
        $targetPin   = config('app.coach_pin', '1234');

        if (hash_equals($targetEmail, $request->email) && hash_equals($targetPin, $request->pin)) {
            
            // Regenerasi ID Sesi untuk mencegah serangan Session Fixation
            $request->session()->regenerate();

            // Set session tanda pelatih sukses masuk
            session(['coach_logged_in' => true]);

            // Alihkan halaman ke dashboard internal pelatih
            return redirect()->route('coach.dashboard')->with('success', 'Selamat datang kembali Mr. Iqbal!');
        }

        // Jika salah, balikkan ke halaman login dengan pesan kesalahan
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Kombinasi Email atau PIN Akses Pelatih salah!');
    }

    // 3. Fungsi untuk proses keluar (Logout) dari sistem
    public function logout(Request $request)
    {
        // Hapus tanda pengenal session pelatih & bersihkan seluruh data sesi
        session()->forget('coach_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Alihkan kembali ke halaman login pelatih dengan pesan sukses
        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}
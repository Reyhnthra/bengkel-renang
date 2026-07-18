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

        // Pengaman Sederhana: Cek kredensial Mr Iqbal
        if ($request->email === 'iqbal@bengkelrenang.com' && $request->pin === '1234') {
            
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
        // Hapus tanda pengenal session pelatih
        session()->forget('coach_logged_in');

        // Alihkan kembali ke halaman login pelatih dengan pesan sukses
        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}
<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/home');
        }
        // Tampilkan landing page untuk tamu
        return view('landing');
    }

    public function dashboard()
    {
        // Harus login untuk akses dashboard
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        return view('v_home', [
            'nama' => session()->get('nama') ?? session()->get('email'),
        ]);
    }
}

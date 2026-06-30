<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengaturan extends BaseController
{
    // Redirect /pengaturan -> /pengaturan/profil
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return redirect()->to('/pengaturan/profil');
    }

    // ===== Edit Profil =====
    public function profil()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('pengaturan/profil');
    }

    public function profilUpdate()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $userModel = new UserModel();
        $id = session()->get('user_id');
        if ($id) {
            $userModel->update($id, [
                'nama'  => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
            ]);
        }
        session()->set('nama', $this->request->getPost('nama'));
        session()->set('email', $this->request->getPost('email'));
        session()->setFlashdata('profil_success', 'Profil berhasil diperbarui!');
        return redirect()->to('/pengaturan/profil');
    }

    // ===== Ganti Sandi =====
    public function sandi()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('pengaturan/sandi');
    }

    public function sandiUpdate()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $userModel = new UserModel();
        $id = session()->get('user_id');
        $user = $userModel->find($id);

        if (!$user || !password_verify($this->request->getPost('password_lama'), $user['password'])) {
            session()->setFlashdata('sandi_error', 'Password lama tidak cocok!');
            return redirect()->to('/pengaturan/sandi');
        }

        $baru = $this->request->getPost('password_baru');
        $konfirm = $this->request->getPost('konfirmasi_password');

        if ($baru !== $konfirm) {
            session()->setFlashdata('sandi_error', 'Konfirmasi password tidak cocok!');
            return redirect()->to('/pengaturan/sandi');
        }

        $userModel->update($id, ['password' => password_hash($baru, PASSWORD_DEFAULT)]);
        session()->setFlashdata('sandi_success', 'Password berhasil diperbarui!');
        return redirect()->to('/pengaturan/sandi');
    }

    // ===== Preferensi Soal =====
    public function preferensi()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('pengaturan/preferensi');
    }

    public function preferensiUpdate()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('pengaturan/tampilan');
    }
}

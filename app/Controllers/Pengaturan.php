<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiKeyModel;
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
        // Simpan ke session sebagai preferensi default generate soal
        session()->set('pref_jenjang',    $this->request->getPost('jenjang'));
        session()->set('pref_jumlah',     $this->request->getPost('jumlah_soal'));
        session()->set('pref_kesulitan',  $this->request->getPost('kesulitan'));
        session()->set('pref_tipe_soal',  $this->request->getPost('tipe_soal'));
        session()->set('pref_bahasa',     $this->request->getPost('bahasa'));
        session()->setFlashdata('pref_success', 'Preferensi soal berhasil disimpan!');
        return redirect()->to('/pengaturan/preferensi');
    }

    // ===== Tampilan =====
    public function tampilan()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('pengaturan/tampilan');
    }

    // ===== API Key CRUD =====
    public function apiKey()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $model = new ApiKeyModel();
        return view('pengaturan/api_key', [
            'apiKeys' => $model->findAll(),
        ]);
    }

    public function apiKeyStore()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $model = new ApiKeyModel();
        $keyName = trim($this->request->getPost('key_name'));
        $apiKey  = trim($this->request->getPost('api_key'));

        if (empty($keyName) || empty($apiKey)) {
            session()->setFlashdata('api_error', 'Nama key dan API key tidak boleh kosong!');
            return redirect()->to('/pengaturan/api-key');
        }

        $model->insert(['key_name' => $keyName, 'api_key' => $apiKey]);
        session()->setFlashdata('api_success', 'API Key berhasil ditambahkan!');
        return redirect()->to('/pengaturan/api-key');
    }

    public function apiKeyEdit($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $model = new ApiKeyModel();
        return view('pengaturan/api_key', [
            'apiKeys' => $model->findAll(),
            'editKey' => $model->find($id),
        ]);
    }

    public function apiKeyUpdate($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $model = new ApiKeyModel();
        $model->update($id, [
            'key_name' => trim($this->request->getPost('key_name')),
            'api_key'  => trim($this->request->getPost('api_key')),
        ]);
        session()->setFlashdata('api_success', 'API Key berhasil diperbarui!');
        return redirect()->to('/pengaturan/api-key');
    }

    public function apiKeyDelete($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        $model = new ApiKeyModel();
        $model->delete($id);
        session()->setFlashdata('api_success', 'API Key berhasil dihapus.');
        return redirect()->to('/pengaturan/api-key');
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
class AuthController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $newUser = new UserModel();
        $user = $newUser->where('email', $this->request->getPost('email'))->first();

        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            session()->set([
                'logged_in' => true,
                'email'     => $user['email'],
                'nama'      => $user['nama'] ?? $user['email'],
                'user_id'   => $user['id'] ?? null,
                'role'      => $user['role'] ?? 'user',
            ]);

            if (session()->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/home');
        }

        session()->setFlashdata('error', 'Email atau password salah!');
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('/auth/register');
    }

    public function registerProcess()
    {
        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();
        if ($user) {
            session()->setFlashdata('error', 'Email sudah terdaftar!');
            return redirect()->to('/register');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user',
        ];
        $userModel->insert($data);

        session()->setFlashdata('success', 'Registrasi berhasil, silakan login!');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

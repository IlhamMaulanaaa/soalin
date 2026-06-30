<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SoalModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $userModel = new UserModel();
        $soalModel = new SoalModel();

        $totalGuru     = $userModel->where('role', 'user')->countAllResults();
        $totalSoal     = $soalModel->countAllResults();
        $soalHariIni   = $soalModel->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
        $guruTerbaru   = $userModel->where('role', 'user')->orderBy('created_at', 'DESC')->findAll(5);

        return view('admin/dashboard', [
            'total_guru'    => $totalGuru,
            'total_soal'    => $totalSoal,
            'soal_hari_ini' => $soalHariIni,
            'guru_terbaru'  => $guruTerbaru,
        ]);
    }

    public function users()
    {
        $userModel = new UserModel();
        $users = $userModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/users', ['users' => $users]);
    }

    public function hapusUser($id)
    {
        if ($id == session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'Guru berhasil dihapus beserta semua soal-nya.');
    }

    public function bankSoal()
    {
        $soalModel = new SoalModel();
        $soalList = $soalModel
            ->select('soal.*, users.name as nama_guru')
            ->join('users', 'users.id = soal.user_id')
            ->orderBy('soal.created_at', 'DESC')
            ->findAll();

        return view('admin/bank_soal', ['soal_list' => $soalList]);
    }

    public function bankSoalDetail($id)
    {
        $soalModel = new SoalModel();
        $soal = $soalModel
            ->select('soal.*, users.name as nama_guru, users.email as email_guru')
            ->join('users', 'users.id = soal.user_id')
            ->where('soal.id', $id)
            ->first();

        if (!$soal) {
            return redirect()->to('/admin/bank-soal')->with('error', 'Soal tidak ditemukan');
        }

        return view('admin/bank_soal_detail', ['soal' => $soal]);
    }

    public function hapusSoal($id)
    {
        $soalModel = new SoalModel();
        $soal = $soalModel->find($id);

        if (!$soal) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Soal tidak ditemukan']);
        }

        $soalModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Soal berhasil dihapus']);
    }
}

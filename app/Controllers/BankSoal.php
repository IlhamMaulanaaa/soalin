<?php

namespace App\Controllers;

use App\Models\SoalModel;

class BankSoal extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        $soalModel = new SoalModel();
        $data['soal_list'] = $soalModel->getByUser(session()->get('user_id'));

        return view('bank_soal', $data);
    }

    public function simpan()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Harus login']);
        }

        $soalModel = new SoalModel();
        $data = [
            'user_id'     => session()->get('user_id'),
            'mapel'       => $this->request->getPost('mapel'),
            'jenjang'     => $this->request->getPost('jenjang'),
            'jumlah_soal' => $this->request->getPost('jumlah_soal'),
            'kesulitan'   => $this->request->getPost('kesulitan'),
            'tipe_soal'   => $this->request->getPost('tipe_soal'),
            'soal_text'   => $this->request->getPost('soal_text'),
        ];

        $id = $soalModel->insert($data);

        if ($id) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Soal berhasil disimpan ke Bank Soal!',
                'id'      => $id,
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menyimpan soal',
        ]);
    }

    public function detail($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        $soalModel = new SoalModel();
        $soal = $soalModel->getWithUser($id);

        if (!$soal || $soal['user_id'] != session()->get('user_id')) {
            return redirect()->to('/bank-soal')->with('error', 'Soal tidak ditemukan');
        }

        return view('bank_soal_detail', ['soal' => $soal]);
    }

    public function hapus($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Harus login']);
        }

        $soalModel = new SoalModel();
        $soal = $soalModel->find($id);

        if (!$soal || $soal['user_id'] != session()->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Soal tidak ditemukan']);
        }

        $soalModel->delete($id);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Soal berhasil dihapus']);
    }
}

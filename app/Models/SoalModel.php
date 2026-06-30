<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalModel extends Model
{
    protected $table      = 'soal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'mapel', 'jenjang', 'jumlah_soal',
        'kesulitan', 'tipe_soal', 'soal_text',
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    public function getByUser($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getWithUser($id)
    {
        return $this->select('soal.*, users.name as user_name')
            ->join('users', 'users.id = soal.user_id')
            ->where('soal.id', $id)
            ->first();
    }
}

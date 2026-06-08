<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BankSoal extends BaseController
{
    public function index()
    {
        return view('bank_soal');
    }
}

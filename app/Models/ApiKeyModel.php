<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiKeyModel extends Model
{
    protected $table      = 'api_keys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key_name', 'api_key'];
    protected $returnType    = 'array';
    protected $useTimestamps = true;
}
?>

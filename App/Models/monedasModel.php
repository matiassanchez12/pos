<?php

namespace App\Models;

use CodeIgniter\Model;


class MonedasModel extends Model
{
    protected $table      = 'monedas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'simbolo'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField = '';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

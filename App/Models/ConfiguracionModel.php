<?php

namespace App\Models;

use CodeIgniter\Model;


class ConfiguracionModel extends Model
{
    protected $table      = 'configuracion';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useSoftUpdate = false;
    protected $useSoftCreates = false;

    protected $allowedFields = ['nombre', 'valor'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

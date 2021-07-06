<?php

namespace App\Models;

use CodeIgniter\Model;


class CajasModel extends Model
{
    protected $table      = 'cajas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['numero_caja', 'nombre_caja', 'folio', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarCajaById($idCaja)
    {
        $resultado = $this->where('id', $idCaja)->first();

        if($resultado){
            return $resultado;
        }else{
            return null; 
        }
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;


class ClientesModel extends Model
{
    protected $table      = 'clientes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','telefono','direccion','correo_electronico','activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarClienteById($idCliente)
    {
        $resultado = $this->where('id', $idCliente)->first();

        if($resultado){
            return $resultado;
        }else{
            return null; 
        }
    }

}

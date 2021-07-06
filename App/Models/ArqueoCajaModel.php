<?php

namespace App\Models;

use CodeIgniter\Model;


class ArqueoCajaModel extends Model
{
    protected $table      = 'arqueo_caja';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_caja', 'id_usuario', 'fecha_inicio', 'fecha_fin', 'monto_inicial', 'monto_final', 'total_ventas', 'estatus'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField = '';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function buscarCajaById($id_caja)
    {
        $resultado = $this->where('id', $id_caja)->first();

        if($resultado){
            return $resultado;
        }else{
            return null; 
        }
    }

    public function getDatos($id_caja)
    {
        $this->select('arqueo_caja.*, cajas.nombre_caja');
        $this->join('cajas', 'arqueo_caja.id_caja = cajas.id');
        $this->where('arqueo_caja.id_caja', $id_caja);
        $this->orderBy('arqueo_caja.id', 'DESC');
        $datos = $this->findAll();

        return $datos;
    }
}

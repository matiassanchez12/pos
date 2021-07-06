<?php

namespace App\Models;

use CodeIgniter\Model;


class DetalleVentasModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_venta', 'id_producto', 'nombre', 'cantidad', 'precio'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function ProductosMasVendido()
    {
        $select =   array(
            'detalle_venta.nombre as nombre',
            'count(detalle_venta.id_producto) as total'
        );

        return $this
            ->select($select)
            ->groupBy('nombre')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }
}

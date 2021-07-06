<?php

namespace App\Models;

use CodeIgniter\Model;


class VentasModel extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_usuario', 'id_caja', 'id_cliente', 'forma_pago', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField = '';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaVenta($folio, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago)
    {
        $this->insert(
            [
                'folio' => $folio,
                'total' => $total,
                'id_usuario' => $id_usuario,
                'id_caja' => $id_caja,
                'id_cliente' => $id_cliente,
                'forma_pago' => $forma_pago
            ]
        );
        
        return $this->insertID();
    }

    public function buscarCajayCliente($activo = 1)
    {
        $this->select('ventas.*, u.usuario AS cajero, c.nombre AS cliente');
        $this->join('usuarios AS u', 'ventas.id_usuario = u.id');
        $this->join('clientes AS c', 'ventas.id_cliente = c.id');
        $this->where('ventas.activo', $activo);
        $this->orderBy('ventas.fecha_alta', 'DESC');
        $datos = $this->findAll();
        return $datos;
    }

    public function totalDia($fecha)
    {
        $this->select('sum(total) as total');
        $where = "activo = 1 AND DATE(fecha_alta) = '$fecha'";
        return $this->where($where)->first();
    }
}

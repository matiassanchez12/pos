<?php

namespace App\Models;

use CodeIgniter\Model;


class DetallesRolesPermisos extends Model
{
    protected $table      = 'detalle_roles_permisos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_rol', 'id_permiso'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField = '';
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function verificarAccesoUsuario($id_rol, $ruta_actual)
    {
        $this->select('permisos.ruta');
        $this->join('permisos', 'detalle_roles_permisos.id_permiso = permisos.id');
        $lista_rutas = $this->where(['id_rol' => $id_rol])->findAll();
        
        foreach ($lista_rutas as $ruta) {
            if ($ruta['ruta'] == $ruta_actual) {
                return true;
            }
        }

        return false;
    }
}

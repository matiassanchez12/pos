<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetallesRolesPermisos;
use App\Models\RolesModel;
use App\Models\PermisosModel;


class Roles extends BaseController
{
    protected $roles;
    protected $request;
    protected $reglas;
    protected $permisos;
    protected $detallesRoles;

    public function __construct()
    {
        $this->detallesRoles = new DetallesRolesPermisos();
        $this->permisos = new PermisosModel();
        $this->roles = new RolesModel();
        helper(['form']);
        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
        ];
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $roles = $this->roles->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Roles', 'datos' => $roles];

        echo view('header');
        echo view('roles/roles', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $roles = $this->roles->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Roles eliminados', 'datos' => $roles];

        echo view('header');
        echo view('roles/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $data = ['titulo' => 'Agregar rol'];

        echo view('header');
        echo view('roles/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->roles->save(
                [
                    "nombre" => $this->request->getPost('nombre')
                ]
            );

            return redirect()->to(base_url() . '/roles')->with('res', 'ok');
        } else {
            $data = [
                'titulo' => 'Agregar rol',
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('roles/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $rol = $this->roles->where('id', $id)->first();

        if ($valid != null) {

            $data = ['titulo' => 'Editar rol', 'datos' => $rol, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar rol', 'datos' => $rol];
        }

        echo view('header');
        echo view('roles/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->roles->update(
                $this->request->getPost('id'),
                [
                    "nombre" => $this->request->getPost('nombre')
                ]
            );
            return redirect()->to(base_url() . '/roles')->with('res', 'ok');
        } else {

            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->roles->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/roles')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->roles->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/roles')->with('res', 'ok');
    }

    public function detalles($id_rol)
    {
        $menus = $this->permisos->findAll();

        $permisosAsignados = $this->detallesRoles->where('id_rol', $id_rol)->findAll();
        $datos = array();

        foreach ($permisosAsignados as $permiso) {
            $datos[$permiso['id_permiso']] = true;
        }

        $data = [
            'titulo' => 'Asignar permisos',
            'permisos' => $menus,
            'id_rol' => $id_rol,
            'permisoAsignado' => $datos
        ];

        echo view('header');
        echo view('roles/detalles', $data);
        echo view('footer');
    }

    public function guardaPermisos()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == 'post') {

            $id_rol = $this->request->getPost('id_rol');
            $permisos = $this->request->getPost('permisos');
            
            $this->detallesRoles->where('id_rol', $id_rol)->delete();
         
            foreach ($permisos as $permiso) {
                
            $datos_permiso = explode('-',$permiso);
            $id = $datos_permiso[0];
            $ruta = $datos_permiso[1];

                $this->detallesRoles->save([
                    'id_rol' => $id_rol,
                    'id_permiso' => $id
                ]);
            }

            return redirect()->to(base_url() . "/roles")->with('res', 'ok');
        }
    }
}

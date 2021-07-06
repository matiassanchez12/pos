<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;

class Clientes extends BaseController
{
    protected $clientes;
    protected $request;


    public function __construct()
    {
        $this->clientes = new ClientesModel();
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $clientes = $this->clientes->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/clientes', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $clientes = $this->clientes->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Clientes eliminados', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $data = ['titulo' => 'Agregar cliente'];

        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post") {

            $this->clientes->save(
                [
                    "nombre" => $this->request->getPost('nombre'),
                    "direccion" => $this->request->getPost('direccion'),
                    "telefono" => $this->request->getPost('telefono'),
                    "correo_electronico" => $this->request->getPost('correo_electronico')
                ]
            );

            return redirect()->to(base_url() . '/clientes')->with('res', 'ok');
        } else {
            $data = [
                'titulo' => 'Agregar unidad',
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id)
    {
        $cliente = $this->clientes->where('id', $id)->first();
        $data = [
            'titulo' => 'Editar cliente',
            'cliente' => $cliente
        ];

        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        $this->clientes->update(
            $this->request->getPost('id'),
            [
                "nombre" => $this->request->getPost('nombre'),
                "telefono" => $this->request->getPost('telefono'),
                "direccion" => $this->request->getPost('direccion'),
                "correo_electronico" => $this->request->getPost('correo_electronico')
            ]
        );

        return redirect()->to(base_url() . '/clientes')->with('res', 'ok');
    }

    public function eliminar($id)
    {
        $this->clientes->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/clientes')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->clientes->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/clientes')->with('res', 'ok');
    }

        
    public function autocompleteData()
    {
        $returnData = array();

        $this->request = \Config\Services::request();

        $valor = $this->request->getGet('term');

        $clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->findAll();
    
        if (!empty($clientes)) {
            foreach ($clientes as $cliente) {
                $data['id'] = $cliente['id'];
                $data['value'] = $cliente['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }
}

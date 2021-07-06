<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\unidadesModel;

class Unidades extends BaseController
{
    protected $unidades;
    protected $request;
    protected $reglas;

    public function __construct()
    {
        $this->unidades = new UnidadesModel();
        helper(['form']);
        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre_corto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $unidades = $this->unidades->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Unidades', 'datos' => $unidades];

        echo view('header');
        echo view('unidades/unidades', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $unidades = $this->unidades->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Unidades eliminadas', 'datos' => $unidades];

        echo view('header');
        echo view('unidades/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $data = ['titulo' => 'Agregar unidad'];

        echo view('header');
        echo view('unidades/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->unidades->save(
                [
                    "nombre" => $this->request->getPost('nombre'),
                    "nombre_corto" => $this->request->getPost('nombre_corto')
                ]
            );

            return redirect()->to(base_url() . '/unidades')->with('res', 'ok');
        } else {
            $data = [
                'titulo' => 'Agregar unidad',
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('unidades/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $unidad = $this->unidades->where('id', $id)->first();

        if ($valid != null) {

            $data = ['titulo' => 'Editar unidad', 'datos' => $unidad, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar unidad', 'datos' => $unidad];
        }

        echo view('header');
        echo view('unidades/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->unidades->update(
                $this->request->getPost('id'),
                [
                    "nombre" => $this->request->getPost('nombre'),
                    "nombre_corto" => $this->request->getPost('nombre_corto')
                ]
            );
            return redirect()->to(base_url() . '/unidades')->with('res', 'ok');
        }else{

            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->unidades->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/unidades')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->unidades->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/unidades')->with('res', 'ok');
    }
}

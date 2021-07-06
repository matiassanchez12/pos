<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class Categorias extends BaseController
{
    protected $categorias;
    protected $request;

    public function __construct()
    {
        $this->categorias = new CategoriasModel();
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $categorias = $this->categorias->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Categorias', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/categorias', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $categorias = $this->categorias->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Categorias eliminadas', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $data = ['titulo' => 'Agregar categoria'];

        echo view('header');
        echo view('categorias/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        $this->categorias->save(
            [
                "nombre" => $this->request->getPost('nombre')
            ]
        );

        return redirect()->to(base_url() . '/categorias')->with('res', 'ok');
    }

    public function editar($id)
    {
        $unidad = $this->categorias->where('id', $id)->first();
        $data = ['titulo' => 'Editar categoria', 'datos' => $unidad];

        echo view('header');
        echo view('categorias/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        $this->categorias->update(
            $this->request->getPost('id'),
            [
                "nombre" => $this->request->getPost('nombre')
            ]
        );

        return redirect()->to(base_url() . '/categorias')->with('res', 'ok');
    }

    public function eliminar($id)
    {
        $this->categorias->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/categorias')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->categorias->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/categorias')->with('res', 'ok');
    }
}

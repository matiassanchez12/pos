<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
use App\Models\VentasModel;

class Cajas extends BaseController
{
    protected $cajas;
    protected $request;
    protected $reglas;
    protected $arqueoModel;
    protected $ventas;

    public function __construct()
    {
        $this->cajas = new CajasModel();
        $this->arqueoModel = new ArqueoCajaModel();
        $this->ventas = new VentasModel();

        helper(['form']);
        $this->reglas = [
            'numero_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'folio' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/cajas', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas eliminadas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $data = ['titulo' => 'Agregar caja'];

        echo view('header');
        echo view('cajas/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->cajas->save(
                [
                    "numero_caja" => $this->request->getPost('numero_caja'),
                    "nombre_caja" => $this->request->getPost('nombre_caja'),
                    "folio" => $this->request->getPost('folio')
                ]
            );

            return redirect()->to(base_url() . '/cajas')->with('res', 'ok');
        } else {
            $data = [
                'titulo' => 'Agregar caja',
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('cajas/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $caja = $this->cajas->where('id', $id)->first();

        if ($valid != null) {

            $data = ['titulo' => 'Editar caja', 'datos' => $caja, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar caja', 'datos' => $caja];
        }

        echo view('header');
        echo view('cajas/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->cajas->update(
                $this->request->getPost('id'),
                [
                    "numero_caja" => $this->request->getPost('numero_caja'),
                    "nombre_caja" => $this->request->getPost('nombre_caja'),
                    "folio" => $this->request->getPost('folio')
                ]
            );
            return redirect()->to(base_url() . '/cajas')->with('res', 'ok');
        } else {

            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->cajas->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/cajas')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->cajas->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/cajas')->with('res', 'ok');
    }

    public function arqueo($id_caja)
    {
        $arqueos = $this->arqueoModel->getDatos($id_caja);
        $data = [
            'titulo' => 'Cierres de caja',
            'datos' => $arqueos
        ];

        echo view('header');
        echo view('cajas/arqueos', $data);
        echo view('footer');
    }

    public function nuevo_arqueo()
    {
        $this->request = \Config\Services::request();
        $session = session();

        $arqueos_caja = $this->arqueoModel->where(['id_caja' => $session->id_caja, 'estatus' => 1])->countAllResults();

        if ($arqueos_caja) {
            echo "La caja ya esta abierta";
            exit;
        }

        if ($this->request->getMethod() == 'post') {
            $fecha = date('Y-m-d h:i:s');

            $this->arqueoModel->save([
                'id_caja' => $session->id_caja,
                'id_usuario' => $session->id_usuario,
                'fecha_inicio' => $fecha,
                'monto_inicial' => $this->request->getPost('monto_inicial'),
                'estatus' => 1
            ]);
            return redirect()->to(base_url() . "/cajas")->with('res', 'ok');
        } else {
            $caja = $this->cajas->where('id', $session->id_caja)->first();
            $data = ['titulo' => 'Apertura de caja', 'datos' => $caja];
            echo view('header');
            echo view('cajas/nuevo_arqueo', $data);
            echo view('footer');
        }
    }

    public function cerrar_caja()
    {
        $this->request = \Config\Services::request();
        $session = session();

        if ($this->request->getMethod() == 'post') {
            $fecha = date('Y-m-d h:i:s');

            $this->arqueoModel->update($this->request->getPost('id_arqueo'), [
                'fecha_fin' => $fecha,
                'monto_final' => $this->request->getPost('monto_final'),
                'total_ventas' => $this->request->getPost('total_ventas'),
                'estatus' => 0
            ]);

            return redirect()->to(base_url() . "/cajas");
        } else {
            $monto_total = $this->ventas->totalDia(date('Y-m-d'));
            $arqueo = $this->arqueoModel->where(['id_caja' => $session->id_caja, 'estatus' => 1])->first();
            $caja = $this->cajas->where('id', $session->id_caja)->first();

            $data = ['titulo' => 'Cierre de caja', 'datos' => $caja, 'arqueo' => $arqueo, 'monto_total' => $monto_total];
            echo view('header');
            echo view('cajas/cerrar_arqueo', $data);
            echo view('footer');
        }
    }

    public function cambiar_estado($id)
    {
        $this->request = \Config\Services::request();

        $arqueo_actual = $this->arqueoModel->where('id', $id)->first();

        if ($arqueo_actual['estatus'] == 1) {

            $this->arqueoModel->update(
                $id,
                [
                    "estatus" => 0
                ]
            );
        } else {

            $this->arqueoModel->update(
                $id,
                [
                    "estatus" => 1
                ]
            );
        }

        return redirect()->to(base_url() . "/cajas/arqueo/$id");
    }
}

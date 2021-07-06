<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use Imagenes;

class Configuracion extends BaseController
{
    protected $configuracion;
    protected $request;
    protected $reglas;

    public function __construct()
    {
        $this->configuracion = new ConfiguracionModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'rfc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'correo' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'valid_email' => 'Ingresar un email valido.'
                ]
            ],
            'telefono' => [
                'rules' => 'required|min_length[8]|max_length[11]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'min_length' => 'Ingresar numero de telefono valido.',
                    'max_length' => 'Ingresar numero de telefono valido.'
                ]
            ],
            'direccion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'ticket_leyenda' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'tienda_logo' => [
                'rules' => 'mime_in[tienda_logo,image/png]',
                'errors' => [
                    'mime_in' => 'Ingresar solo en formato PNG'
                ]
            ]
        ];
    }

    public function index($valid = null)
    {
        if ($valid != null) {
            $data =
                [
                    'titulo' => 'Configuración',
                    'datos' => [
                        'nombre' => $this->configuracion->where('nombre', 'tienda_nombre')->first()['valor'],
                        'rfc' => $this->configuracion->where('nombre', 'tienda_rfc')->first()['valor'],
                        'telefono' => $this->configuracion->where('nombre', 'tienda_telefono')->first()['valor'],
                        'correo' => $this->configuracion->where('nombre', 'tienda_mail')->first()['valor'],
                        'direccion' => $this->configuracion->where('nombre', 'tienda_direccion')->first()['valor'],
                        'leyenda' => $this->configuracion->where('nombre', 'ticket_leyenda')->first()['valor']
                    ],
                    'validation' => $valid
                ];
        } else {
            $data =
                [
                    'titulo' => 'Configuración',
                    'datos' => [
                        'nombre' => $this->configuracion->where('nombre', 'tienda_nombre')->first()['valor'],
                        'rfc' => $this->configuracion->where('nombre', 'tienda_rfc')->first()['valor'],
                        'telefono' => $this->configuracion->where('nombre', 'tienda_telefono')->first()['valor'],
                        'correo' => $this->configuracion->where('nombre', 'tienda_mail')->first()['valor'],
                        'direccion' => $this->configuracion->where('nombre', 'tienda_direccion')->first()['valor'],
                        'leyenda' => $this->configuracion->where('nombre', 'ticket_leyenda')->first()['valor']
                    ]
                ];
        }
        echo view('header');
        echo view('configuracion/configuracion', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $this->configuracion->whereIn('nombre', ['tienda_nombre'])->set(
                ['valor' => $this->request->getPost('nombre')]
            )->update();
            $this->configuracion->whereIn('nombre', ['tienda_rfc'])->set(
                ['valor' => $this->request->getPost('rfc')]
            )->update();
            $this->configuracion->whereIn('nombre', ['tienda_telefono'])->set(
                ['valor' => $this->request->getPost('telefono')]
            )->update();
            $this->configuracion->whereIn('nombre', ['tienda_mail'])->set(
                ['valor' => $this->request->getPost('correo')]
            )->update();
            $this->configuracion->whereIn('nombre', ['tienda_direccion'])->set(
                ['valor' => $this->request->getPost('direccion')]
            )->update();
            $this->configuracion->whereIn('nombre', ['ticket_leyenda'])->set(
                ['valor' => $this->request->getPost('ticket_leyenda')]
            )->update();

            if ($this->request->getFile('tienda_logo')->getName() != '') {
                Imagenes::guardarImagen("images/logotipo.png", 'tienda_logo', "./images", "logotipo.png");
            }

            return redirect()->to(base_url() . '/configuracion')->with('res', 'ok');
        } else {

            return $this->index($this->validator);
        }
    }

    public static function GetNombre()
    {
        $configuracion = new ConfiguracionModel();
        return $configuracion->whereIn('nombre', ['tienda_nombre'])->first()['valor'];
    }
}

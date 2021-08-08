<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\MonedasModel;
use FPDF;
use Imagenes;

class Configuracion extends BaseController
{
    protected $configuracion;
    protected $monedas;
    protected $request;
    protected $reglas;

    public function __construct()
    {
        $this->configuracion = new ConfiguracionModel();
        $this->monedas = new MonedasModel();

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
                        'direccion' => $this->configuracion->where('nombre', 'tienda_direccion')->first()['valor']
                    ]
                ];
        }
        echo view('header');
        echo view('configuracion/datos', $data);
        echo view('footer');
    }

    public static function GetNombre()
    {
        $configuracion = new ConfiguracionModel();
        return $configuracion->whereIn('nombre', ['tienda_nombre'])->first()['valor'];
    }

    public static function GetFuente()
    {
        $configuracion = new ConfiguracionModel();
        return $configuracion->whereIn('nombre', ['tamaño_fuente'])->first()['valor'];
    }

    public static function GetColorTema()
    {
        $configuracion = new ConfiguracionModel();
        return $configuracion->whereIn('nombre', ['color_tema'])->first()['valor'];
    }

    public static function GetSimboloMoneda()
    {
        $configuracion = new ConfiguracionModel();
        return $configuracion->whereIn('nombre', ['moneda'])->first()['valor'];
    }

    public function general()
    {
        $monedas = $this->monedas->findAll();

        $ticket_leyenda = $this->configuracion->whereIn('nombre', ['ticket_leyenda'])->first()['valor'];
        $simbolo = $this->configuracion->whereIn('nombre', ['moneda'])->first()['valor'];
        $nro_decimales = $this->configuracion->whereIn('nombre', ['nro_decimales'])->first()['valor'];
        $separador_miles = $this->configuracion->whereIn('nombre', ['separador_miles'])->first()['valor'];
        $separador_decimales = $this->configuracion->whereIn('nombre', ['separador_decimales'])->first()['valor'];
        $fuente = $this->configuracion->whereIn('nombre', ['tamaño_fuente'])->first()['valor'];
        $color_tema = $this->configuracion->whereIn('nombre', ['color_tema'])->first()['valor'];

        echo view('header');
        echo view('configuracion/configuracion', [
            'monedas' => $monedas,
            'simbolo' => $simbolo,
            'separador_miles' => $separador_miles,
            'separador_decimales' => $separador_decimales,
            'nro_decimales' => $nro_decimales,
            'fuente' => $fuente,
            'color_tema' => $color_tema,
            'ticket_leyenda' => $ticket_leyenda
        ]);
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

            if ($this->request->getFile('tienda_logo')->getName() != '') {
                Imagenes::guardarImagen("images/logotipo.png", 'tienda_logo', "./images", "logotipo.png");
            }

            return redirect()->to(base_url() . '/configuracion')->with('res', 'ok');
        } else {

            return $this->index($this->validator);
        }
    }

    public function actualizarConfiguracionGeneral()
    {
        if ($this->request->getMethod() == "post") {
            $this->configuracion->whereIn('nombre', ['color_tema'])->set(
                ['valor' => $this->request->getPost('tema')]
            )->update();
            $this->configuracion->whereIn('nombre', ['separador_miles'])->set(
                ['valor' => $this->request->getPost('miles')]
            )->update();
            $this->configuracion->whereIn('nombre', ['separador_decimales'])->set(
                ['valor' => $this->request->getPost('decimales')]
            )->update();
            $this->configuracion->whereIn('nombre', ['moneda'])->set(
                ['valor' => $this->request->getPost('moneda')]
            )->update();
            $this->configuracion->whereIn('nombre', ['nro_decimales'])->set(
                ['valor' => $this->request->getPost('nro_decimales')]
            )->update();
            $this->configuracion->whereIn('nombre', ['tamaño_fuente'])->set(
                ['valor' => $this->request->getPost('fuente')]
            )->update();
            $this->configuracion->whereIn('nombre', ['ticket_leyenda'])->set(
                ['valor' => $this->request->getPost('ticket_leyenda')]
            )->update();

            return redirect()->to(base_url() . '/configuracion/general')->with('res', 'ok');
        }
    }

    public function ticketVistaPrevia($direccion, $telefono, $moneda, $ticket_leyenda, $nro_decimales, $decimales, $miles)
    {
        define('EURO', chr(128));

        $datosVenta = ['fecha_alta' => '2021/08/21 22:02:10', 'folio' => '1111111', 'total' => 2400];
        $detalleVenta = [['cantidad' => 2, 'nombre' => 'Producto x', 'precio' => 1200]];
        $nombreTienda = $this->configuracion->whereIn('nombre', ['tienda_nombre'])->first()['valor'];
        $direccionTienda = $this->configuracion->whereIn('nombre', ['tienda_direccion'])->first()['valor'];
        $telefonoTienda = $this->configuracion->whereIn('nombre', ['tienda_telefono'])->first()['valor'];
        $decimales = str_replace("'", "", $decimales);
        $miles = str_replace("'", "", $miles);

        if ($moneda !== '$' && $moneda !== 'R$') {
            $moneda = EURO;
        }

        $pdf = new FPDF('P', 'mm', array(80, 200));

        $pdf->AddPage();
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetTitle('Venta');

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Image(base_url() . '/images/logotipo.png', 5, 7, 13, 13, 'png');

        $pdf->Cell(55, 5, $nombreTienda, 0, 1, 'C');

        if ($direccion == 1) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, $direccionTienda, 0, 1, 'C');
        }

        if ($telefono == 1) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, 'Telefono:' . $telefonoTienda, 0, 1, 'C');
        }

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 5, 'Fecha y hora: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 5, $datosVenta['fecha_alta'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 5, 'Ticket: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 5, $datosVenta['folio'], 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(7, 5, 'Cant.', 0, 0, 'C');
        $pdf->Cell(35, 5, 'Codigo', 0, 0, 'C');
        $pdf->Cell(15, 5, 'Precio', 0, 0, 'C');
        $pdf->Cell(15, 5, 'Importe', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 8);

        $totalImporte = 0;
        $contador = 1;

        foreach ($detalleVenta as $row) {
            $pdf->Cell(7, 5, $row['cantidad'], 0, 0, 'C');
            $pdf->Cell(35, 5, $row['nombre'], 0, 0, 'C');
            $pdf->Cell(15, 5, $moneda . number_format($row['precio'], $nro_decimales, $decimales, $miles), 0, 0, 'C');
            $totalImporte =  number_format($row['cantidad'] * $row['precio'], $nro_decimales, $decimales, $miles);
            $pdf->Cell(15, 5, $moneda . $totalImporte, 0, 1, 'R');
            $contador++;
        }

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 5, 'Total ' . $moneda . number_format($datosVenta['total'], $nro_decimales, $decimales, $miles), 0, 1, 'R');

        $pdf->Ln();

        $pdf->Cell(70, 5, $ticket_leyenda, 0, 1, 'C');
        $this->response->setContentType('application/pdf');
        $pdf->Output('ticket_vista.pdf', 'I');
    }

    public static function cambiarFormatoPrecio($aux_precio)
    {
        $configuracion = new ConfiguracionModel();
        $decimales = $configuracion->whereIn('nombre', ['separador_miles'])->first()['valor'];
        $miles = $configuracion->whereIn('nombre', ['separador_miles'])->first()['valor'];
        $nro_decimales = $configuracion->whereIn('nombre', ['nro_decimales'])->first()['valor'];
        
        return number_format(floatval($aux_precio), $nro_decimales, $decimales, $miles);
    }
}

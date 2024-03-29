<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\ProductosModel;
use App\Models\TemporalComprasModel;
use App\Models\DetalleComprasModel;
use App\Models\ConfiguracionModel;
use CodeIgniter\Config\Config;
use FPDF;

class Compras extends BaseController
{
    protected $compras;
    protected $productos;
    protected $request;
    protected $temporal_compra;
    protected $detalle_compra;
    protected $configuracion;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleComprasModel();
        $this->configuracion = new ConfiguracionModel();
        helper('form');
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $compras = $this->compras->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Compras', 'compras' => $compras];

        echo view('header');
        echo view('compras/compras', $data);
        echo view('footer');
    }

    public function eliminadas($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $compras = $this->compras->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Compras eliminadas', 'compras' => $compras];

        echo view('header');
        echo view('compras/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($id = null)
    {
        echo view('header');
        echo view('compras/nuevo');
        echo view('footer');
    }

    public function guarda()
    {
        $this->request = \Config\Services::request();

        $id_compra = $this->request->getPost('id_compra');
        $total = $this->SetFormatoPrecio($this->request->getPost('total'));
        $session = session();

        $resultadoID = $this->compras->insertaCompra($id_compra, $total, $session->id_usuario);

        $this->temporal_compra = new TemporalComprasModel();

        if ($resultadoID) {
            $resultadoCompra = $this->temporal_compra->porCompra($id_compra);

            foreach ($resultadoCompra as $row) {
                $this->detalle_compra->save([
                    'id_compra' => $resultadoID,
                    'id_producto' => $row['id_producto'],
                    'nombre' => $row['nombre'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['precio']
                ]);
                $this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
            }
            $this->temporal_compra->eliminarCompra($id_compra);
        }
        return redirect()->to(base_url() . "/compras/muestraCompraPdf/". $resultadoID);
    }

    public function SetFormatoPrecio($valor)
    {
        return preg_replace('/[\$,]/', '', $valor);
    }

    public function muestraCompraPdf($id_compra)
    {
        $data['id_compra'] = $id_compra;

        echo view('header');
        echo view('compras/ver_compra_pdf', $data);
        echo view('footer');
    }

    public function generaCompraPdf($id_compra)
    {
        define('EURO', chr(128));

        $datosCompra = $this->compras->where('id', $id_compra)->first();
        $detalleCompra = $this->detalle_compra->select('*')->where('id_compra', $id_compra)->findAll();
        $nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;

        $moneda = Configuracion::GetSimboloMoneda();

        if ($moneda !== '$' && $moneda !== 'R$') {
            $moneda = EURO;
        }

        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle('Compra');
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(195, 5, 'Entrada de productos', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 9);

        $pdf->Image(base_url() . '/images/compras.jpg', 175, 5, 25, 25, 'jpg');

        $pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');

        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 5, 'Fecha y hora: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 5, $datosCompra['fecha_alta'], 0, 1, 'L');

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(196, 5, 'Detalle de productos', 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(14, 5, 'No', 1, 0, 'C');
        $pdf->Cell(25, 5, 'Codigo', 1, 0, 'C');
        $pdf->Cell(77, 5, 'Nombre', 1, 0, 'C');
        $pdf->Cell(25, 5, 'Precio', 1, 0, 'C');
        $pdf->Cell(25, 5, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(30, 5, 'Importe', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);

        $totalImporte = 0;
        $contador = 1;

        foreach ($detalleCompra as $row) {
            $pdf->Cell(14, 5, $contador, 1, 0, 'C');
            $pdf->Cell(25, 5, $row['id_producto'], 1, 0, 'C');
            $pdf->Cell(77, 5, $row['nombre'], 1, 0, 'C');
            $pdf->Cell(25, 5, $moneda . Configuracion::cambiarFormatoPrecio($row['precio']), 1, 0, 'C');
            $pdf->Cell(25, 5, $row['cantidad'], 1, 0, 'C');
            $totalImporte =  $row['cantidad'] * $row['precio'];
            $pdf->Cell(30, 5, $moneda .  Configuracion::cambiarFormatoPrecio($totalImporte), 1, 1, 'R');
            $contador++;
        }

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 5, 'Total '. $moneda. Configuracion::cambiarFormatoPrecio($datosCompra['total']), 0, 1, 'R');

        $this->response->setContentType('application/pdf');
        $pdf->Output('compra_pdf.pdf', 'I');
    }
}

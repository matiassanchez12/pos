<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\DetalleVentasModel;
use App\Models\TemporalComprasModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use App\Models\ClientesModel;
use App\Models\CajasModel;

use FPDF;

class Ventas extends BaseController
{
    protected $ventas;
    protected $productos;
    protected $request;
    protected $temporal_compra;
    protected $detalle_venta;
    protected $configuracion;
    protected $clientes;
    protected $cajas;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->ventas = new VentasModel();
        $this->detalle_venta = new DetalleVentasModel();
        $this->temporal_compra = new TemporalComprasModel();
        $this->configuracion = new ConfiguracionModel();
        $this->cajas = new CajasModel();
        $this->clientes = new ClientesModel();

        helper('form');
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $datos = $this->ventas->buscarCajayCliente(1);

        $data = [
            'titulo' => 'Ventas',
            'datos' => $datos
        ];

        echo view('header');
        echo view('ventas/ventas', $data);
        echo view('footer');
    }

    public function venta()
    {
        echo view('header');
        echo view('ventas/caja');
        echo view('footer');
    }

    public function eliminadas($activo = 0)
    {
        $datos = $this->ventas->buscarCajayCliente(0);

        $data = [
            'titulo' => 'Ventas eliminadas',
            'datos' => $datos
        ];

        echo view('header');
        echo view('ventas/eliminadas', $data);
        echo view('footer');
    }

    public function guarda()
    {
        $this->request = \Config\Services::request();

        $id_venta = $this->request->getPost('id_venta');
        $total = $this->SetFormatoPrecio($this->request->getPost('total'));
        $forma_pago = $this->request->getPost('forma_pago');
        $id_cliente = $this->request->getPost('id_cliente');

        $session = session();

        $caja = $this->cajas->where('id', $session->id_caja)->first();

        $folio = $caja['folio'];

        $resultadoID = $this->ventas->insertaVenta($folio, $total, $session->id_usuario, $session->id_caja, $id_cliente, $forma_pago);

        if ($resultadoID) {
            $folio++;
            $this->cajas->update($session->id, ['folio' => $folio]);

            $resultadoCompra = $this->temporal_compra->porCompra($id_venta);

            foreach ($resultadoCompra as $row) {
                $this->detalle_venta->save([
                    'id_venta' => $resultadoID,
                    'id_producto' => $row['id_producto'],
                    'cantidad' => $row['cantidad'],
                    'nombre' => $row['nombre'],
                    'precio' => $row['precio']
                ]);
                $this->productos->actualizaStock($row['id_producto'], $row['cantidad'], '-');
            }
            $this->temporal_compra->eliminarCompra($id_venta);
        }

        return redirect()->to(base_url() . "/ventas/muestraTicket/" . $resultadoID);
    }

    public function SetFormatoPrecio($valor)
    {
        return preg_replace('/[\$,]/', '', $valor);
    }

    public function muestraTicket($id_venta)
    {
        $data['id_venta'] = $id_venta;

        echo view('header');
        echo view('ventas/ver_ticket', $data);
        echo view('footer');
    }

    public function generaTicket($id_venta)
    {
        define('EURO', chr(128));

        $datosVenta = $this->ventas->where('id', $id_venta)->first();
        $detalleVenta = $this->detalle_venta->select('*')->where('id_venta', $id_venta)->findAll();
        $nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
        $telefonoTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_telefono')->get()->getRow()->valor;
        $leyendaTicket = $this->configuracion->select('valor')->where('nombre', 'ticket_leyenda')->get()->getRow()->valor;
        $agregar_direc = $this->configuracion->select('valor')->where('nombre', 'agregar_direc')->get()->getRow()->valor;
        $agregar_tel = $this->configuracion->select('valor')->where('nombre', 'agregar_tel')->get()->getRow()->valor;

        $moneda = Configuracion::GetSimboloMoneda();

        if ($moneda !== '$' && $moneda !== 'R$') {
            $moneda = EURO;
        }

        $pdf = new FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetTitle('Venta');

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Image(base_url() . '/public/images/logotipo.png', 5, 7, 13, 13, 'png');

        $pdf->Cell(55, 5, $nombreTienda, 0, 1, 'C');

        if ($agregar_direc == 1) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, $direccionTienda, 0, 1, 'C');
        }

        if ($agregar_tel == 1) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, 'Telefono: ' . $telefonoTienda, 0, 1, 'C');
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
            $pdf->Cell(15, 5, $moneda . Configuracion::cambiarFormatoPrecio($row['precio']), 0, 0, 'C');
            $totalImporte =  Configuracion::cambiarFormatoPrecio($row['cantidad'] * $row['precio']);
            $pdf->Cell(15, 5, $moneda . $totalImporte, 0, 1, 'R');
            $contador++;
        }

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 5, 'Total ' . $moneda . Configuracion::cambiarFormatoPrecio($datosVenta['total']), 0, 1, 'R');

        $pdf->Ln();

        $pdf->Cell(70, 5, $leyendaTicket, 0, 1, 'C');
        $this->response->setContentType('application/pdf');
        $pdf->Output('venta_pdf.pdf', 'I');
    }

    public function eliminar($id_venta)
    {
        $productos = $this->detalle_venta->where('id_venta', $id_venta)->findAll();

        foreach ($productos as $producto) {
            $this->productos->actualizaStock($producto['id_producto'], $producto['cantidad'], '+');
        }

        $this->ventas->update($id_venta, ['activo' => 0]);

        return redirect()->to(base_url() . '/ventas')->with('res', 'ok');
    }
}

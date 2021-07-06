<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Inicio extends BaseController
{
	protected $productoModel;
	protected $ventasModel;
	protected $session;

	public function __construct()
	{
		$this->session = session();
		$this->productoModel = new ProductosModel();
		$this->ventasModel = new VentasModel();
	}

	public function index()
	{
		if (!isset($this->session->id_usuario)) {
			return redirect()->to(base_url());
		}

		$totalProductos = $this->productoModel->totalProductos();
		$totalVentas = $this->ventasModel->totalDia(date('Y-m-d'));
		$minimos = $this->productoModel->productosMinimo();

		if ($totalVentas['total'] == null) {
			$totalVentas['total'] = 0;
		}

		$datos = [
			'total' => $totalProductos,
			'totalVentas' => $totalVentas,
			'minimos' => $minimos
		];

		echo view('header');
		echo view('inicio', $datos);
		echo view('footer');
	}

	public static function validarInicio()
	{
		$session = session();
		echo $session->id_usuario;
		if (!isset($session->id_usuario)) {
			redirect()->to('google.com');
		}
	}
}

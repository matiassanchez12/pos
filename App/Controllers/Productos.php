<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\CategoriasModel;
use App\Models\UnidadesModel;
use Error;
use Imagenes;
// use PDF;
use CodeIgniter\Config\Services;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Productos extends BaseController
{
    protected $productos;
    protected $request;
    protected $unidades;
    protected $categorias;
    protected $reglas;
    protected $reglas_actualizar;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();

        helper(['form']);
        // Validaciones, Codigo por unico y los demas por requerido
        // Falta validar que si el codigo de actualizar es igual, no tire el error de codigo repetido
        $this->reglas_actualizar = [
            'codigo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_unidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'precio_venta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'precio_compra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'imagen_producto' => [
                'rules' => 'mime_in[imagen_producto,image/png]',
                'errors' => [
                    'mime_in' => 'Ingresar solo en formato PNG'
                ]
            ]
        ];
        $this->reglas = [
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'El campo {field} debe ser unico.'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_unidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'precio_venta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'precio_compra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'imagen_producto' => [
                'rules' => 'uploaded[imagen_producto]|max_size[imagen_producto,4096]|mime_in[imagen_producto,image/png]',
                'errors' => [
                    'uploaded' => 'Ingresar una imagen',
                    'max_size' => 'Ingresar solo imagenes menores a 4069 kb.',
                    'mime_in' => 'Ingresar solo en formato PNG'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos];

        echo view('header');
        echo view('productos/productos', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Productos eliminados', 'datos' => $productos];

        echo view('header');
        echo view('productos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $unidades = $this->unidades->where('activo', 1)->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        //cuando activo sea 1, osea este el prod activo, pasarlo por array
        $data = [
            'titulo' => 'Agregar producto',
            'unidades' => $unidades,
            'categorias' => $categorias
        ];

        echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            if ($this->request->getPost('inventariable') != null) {
                $this->productos->save(
                    [
                        "codigo" => $this->request->getPost('codigo'),
                        "nombre" => $this->request->getPost('nombre'),
                        "precio_venta" => $this->request->getPost('precio_venta'),
                        "precio_compra" => $this->request->getPost('precio_compra'),
                        "stock_minimo" => $this->request->getPost('stock_minimo'),
                        "inventariable" => $this->request->getPost('inventariable'),
                        "existencias" => $this->request->getPost('existencias'),
                        "id_unidad" => $this->request->getPost('id_unidad'),
                        "id_categoria" => $this->request->getPost('id_categoria'),
                    ]
                );
            } else {
                $this->productos->save(
                    [
                        "codigo" => $this->request->getPost('codigo'),
                        "nombre" => $this->request->getPost('nombre'),
                        "precio_venta" => $this->request->getPost('precio_venta'),
                        "precio_compra" => $this->request->getPost('precio_compra'),
                        "id_unidad" => $this->request->getPost('id_unidad'),
                        "id_categoria" => $this->request->getPost('id_categoria'),
                    ]
                );
            }

            $id = $this->productos->getInsertID();

            Imagenes::guardarImagen("images/productos/$id.png", 'imagen_producto', './images/productos', "$id.png");

            return redirect()->to(base_url() . '/productos')->with('res', 'ok');
        } else {

            $unidades = $this->unidades->where('activo', 1)->findAll();
            $categorias = $this->categorias->where('activo', 1)->findAll();
            $data = [
                'titulo' => 'Agregar producto',
                'unidades' => $unidades,
                'categorias' => $categorias,
                'validation' => $this->validator
            ];

            echo view('header');
            echo view('productos/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $unidades = $this->unidades->where('activo', 1)->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $producto = $this->productos->where('id', $id)->first();

        if ($valid != null) {

            $data = [
                'titulo' => 'Editar producto',
                'unidades' => $unidades,
                'categorias' => $categorias,
                'producto' => $producto,
                'validation' => $valid
            ];
        } else {

            $data = [
                'titulo' => 'Editar producto',
                'unidades' => $unidades,
                'categorias' => $categorias,
                'producto' => $producto
            ];
        }

        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->request = \Config\Services::request();

        if ($this->request->getMethod() == "post" && $this->validate($this->reglas_actualizar)) {
            $id = $this->request->getPost('id');

            if ($this->request->getPost('inventariable') != null || $this->request->getPost('inventariable') != 0) {
                $this->productos->update(
                    $id,
                    [
                        "codigo" => $this->request->getPost('codigo'),
                        "nombre" => $this->request->getPost('nombre'),
                        "precio_venta" => $this->request->getPost('precio_venta'),
                        "precio_compra" => $this->request->getPost('precio_compra'),
                        "stock_minimo" => $this->request->getPost('stock_minimo'),
                        "inventariable" => $this->request->getPost('inventariable'),
                        "existencias" => $this->request->getPost('existencias'),
                        "id_unidad" => $this->request->getPost('id_unidad'),
                        "id_categoria" => $this->request->getPost('id_categoria'),
                    ]
                );
            } else {
                $this->productos->update(
                    $id,
                    [
                        "codigo" => $this->request->getPost('codigo'),
                        "nombre" => $this->request->getPost('nombre'),
                        "precio_venta" => $this->request->getPost('precio_venta'),
                        "precio_compra" => $this->request->getPost('precio_compra'),
                        "id_unidad" => $this->request->getPost('id_unidad'),
                        "id_categoria" => $this->request->getPost('id_categoria'),
                        "stock_minimo" => 0,
                        "inventariable" => 0,
                        "existencias" => 0
                    ]
                );
            }

            if ($this->request->getFile('imagen_producto')->getName() != '') {
                Imagenes::guardarImagen("images/productos/$id.png", 'imagen_producto', './images/productos', "$id.png");
            }

            return redirect()->to(base_url() . '/productos')->with('res', 'ok');
        } else {

            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->request = \Config\Services::request();

        $this->productos->update(
            $id,
            [
                "activo" => 0
            ]
        );

        return redirect()->to(base_url() . '/productos')->with('res', 'ok');
    }

    public function reingresar($id)
    {
        $this->request = \Config\Services::request();

        $this->productos->update(
            $id,
            [
                "activo" => 1
            ]
        );

        return redirect()->to(base_url() . '/productos')->with('res', 'ok');
    }

    public function buscarPorCodigo($codigo)
    {
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', 1);
        $datos = $this->productos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if ($datos) {
            $res['datos'] = $datos;
            $res['existe'] = true;
        } else {
            $res['error'] = 'No existe el producto';
            $res['existe'] = false;
        }

        echo json_encode($res);
    }

    public function autocompleteData()
    {
        $returnData = array();

        $this->request = \Config\Services::request();

        $valor = $this->request->getGet('term');

        $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $data['id'] = $producto['id'];
                $data['value'] = $producto['codigo'];
                $data['label'] = $producto['codigo'] . ' - ' . $producto['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }

    public function mostrarCodigos()
    {
        echo view('header');
        echo view('productos/ver_codigos');
        echo view('footer');
    }

    public function generaBarras()
    {
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle('Codigos de barras');

        $productos = $this->productos->where('activo', 1)->findAll();

        foreach ($productos as $producto) {
            $codigo = $producto['codigo'];

            $generaBarcode = new \Barcode();

            $generaBarcode->barcode("images/barcode/" . $codigo . ".png", $codigo, 20, 'horizontal', 'code39', true);

            $pdf->Image("images/barcode/" . $codigo . ".png");
        }
        $this->response->setContentType('application/pdf');
        $pdf->Output('Codigo.pdf', 'I');
    }

    public function mostrarMinimos()
    {
        echo view('header');
        echo view('productos/ver_minimos');
        echo view('footer');
    }

    public function generaMinimos()
    {
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->Ln(5);
        $pdf->SetTitle('Producto con stock minimo');
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Image("http://localhost/images/logotipo.png", 10, 5, 25);

        $pdf->Cell(0, 5, utf8_decode('Reporte de productos con stock mínimo'), 0, 1, 'C');

        $pdf->Ln(20);

        $pdf->Cell(40, 5, utf8_decode('Código'), 1, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('Nombre'), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode('Existencias'), 1, 0, 'C');
        $pdf->Cell(40, 5, utf8_decode('Stock minimo'), 1, 1, 'C');

        $datosProductos = $this->productos->getProductoMinimo();

        foreach ($datosProductos as $producto) {
            $pdf->Cell(40, 5, $producto['codigo'], 1, 0, 'C');
            $pdf->Cell(80, 5, utf8_decode($producto['nombre']), 1, 0, 'C');
            $pdf->Cell(30, 5, $producto['existencias'], 1, 0, 'C');
            $pdf->Cell(40, 5, $producto['stock_minimo'], 1, 1, 'C');
        }

        $this->response->setContentType('application/pdf');
        $pdf->Output('Codigo.pdf', 'I');
    }

    public function generarExcel()
    {
        echo view('header');
        echo view('productos/generar_excel');
        echo view('footer');
    }

    public function mostrarMinimosExcel()
    {
        $phpExcel = new Spreadsheet();

        $phpExcel->getProperties()->setCreator('Matias Sanchez')->setTitle('Reporte POS');

        $hoja = $phpExcel->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setPath('images/logotipo.png');
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($hoja);


        $hoja->mergeCells('A3:D3');
        $hoja->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $hoja->getStyle('A3')->getFont()->setSize(12);
        $hoja->getStyle('A3')->getFont()->setName('Arial');
        $hoja->setCellValue('A3', 'Reporte de producto con stock minimo');

        $hoja->setCellValue('A6', 'Codigo');
        $hoja->getColumnDimension('A')->setWidth(20);
        $hoja->setCellValue('B6', 'Nombre');
        $hoja->getColumnDimension('B')->setWidth(40);
        $hoja->setCellValue('C6', 'Existencias');
        $hoja->getColumnDimension('C')->setWidth(20);
        $hoja->setCellValue('D6', 'Stock');
        $hoja->getColumnDimension('D')->setWidth(20);

        $hoja->getStyle('A6:D6')->getFont()->setBold(true);

        $datosProductos = $this->productos->getProductoMinimo();

        $fila = 7;

        foreach ($datosProductos as $producto) {
            $hoja->setCellValue('A' . $fila, $producto['codigo']);
            $hoja->setCellValue('B' . $fila, $producto['nombre']);
            $hoja->setCellValue('C' . $fila, $producto['existencias']);
            $hoja->setCellValue('D' . $fila, $producto['stock_minimo']);
            $fila++;
        }

        $ultimaFila = $fila - 1;


        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ]
            ]
        ];

        $hoja->getStyle('A6:D' . $ultimaFila)->applyFromArray($styleArray);

        // $hoja->setCellValueExplicit('C' . $fila, "=SUMA(C5:C'.$ultimaFila')", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA);
        $hoja->setCellValueExplicit(
            "C$fila",
            "=SUMA(C5:C$ultimaFila)",
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2
        );
        $writer = new Xlsx($phpExcel);
        $writer->save('reporte_minimos.xlsx');

        return redirect()->to(base_url() . '/productos/generarExcel');
    }

    function mostrarAvatars()
    {
        $imagesDirectory = "images/avatars";
        $urlbase = base_url();
        if (is_dir($imagesDirectory)) {
            $opendirectory = opendir($imagesDirectory);

            while (($image = readdir($opendirectory)) !== false) {
                if (($image == '.') || ($image == '..')) {
                    continue;
                }

                $imgFileType = pathinfo($image, PATHINFO_EXTENSION);

                if (($imgFileType == 'jpg') || ($imgFileType == 'png')) {
                    echo  "<img src= '$urlbase/images/avatars/$image' class='btn p-0 m-1 rounded-circle' id='imagen_avatar' style='max-height:80px;max-width:80px;'> ";
                }
            }

            closedir($opendirectory);
        }
    }
}

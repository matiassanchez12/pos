<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemporalComprasModel;
use App\Models\ProductosModel;

class TemporalCompras extends BaseController
{
    protected $comprasTemporales;
    protected $productos;
    protected $request;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->comprasTemporales = new TemporalComprasModel();
    }
    
    public function insertar($id_producto, $cantidad, $id_compra)
    {
        $error = '';

        $producto = $this->productos->where('id', $id_producto)->first();

        if ($producto) {
            $datosExiste = $this->comprasTemporales->porIdProductoCompra($id_producto, $id_compra);
            if ($datosExiste) {
                // $cantidad = $datosExiste->cantidad + $cantidad;
                // $subTotal = $cantidad * $datosExiste->precio;

                // $this->comprasTemporales->actualizarProductoCompra($id_producto, $id_compra, $cantidad, $subTotal);
            } else {
                $subTotal = $cantidad * $producto['precio_compra'];

                $this->comprasTemporales->save([
                    "folio" => $id_compra,
                    "id_producto" => $id_producto,
                    "codigo" => $producto['codigo'],
                    "nombre" => $producto['nombre'],
                    "precio" => $producto['precio_compra'],
                    "cantidad" => $cantidad,
                    "subtotal" => $subTotal
                ]);
            }
        } else {
            $error = 'No existe el producto';
        }
        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = Configuracion::cambiarFormatoPrecio($this->totalProductos($id_compra));
        $res['error'] = $error;

        echo json_encode($res);
    }

    public function cargaProductos($id_compra)
    {
        $resultado = $this->comprasTemporales->porCompra($id_compra);
        $fila = '';
        $numFila = 0;

        foreach ($resultado as $row) {
            $numFila++;
            $id_producto = $row['id_producto'];
            $fila .= "<tr id='fila" . $numFila . "'>";
            $fila .= "<td>" . $numFila . "</td>";
            $fila .= "<td>" . $row['codigo'] . "</td>";
            $fila .= "<td>" . $row['nombre'] . "</td>";
            $fila .= "<td>" . Configuracion::cambiarFormatoPrecio($row['precio']) . "</td>";
            $fila .= "<td>" . "<input type='number' value=" . $row['cantidad'] . " onchange=\"cambiarCantidad($id_producto, '$id_compra', this)\" name='cantidad' id='cantidad' min='1' class='form-control' style='width: 80px;'>" . "</td>";
            $fila .= "<td>" . Configuracion::cambiarFormatoPrecio($row['subtotal']) . "</td>";
            $fila .= "<td><a onclick=\"eliminarProducto(" . $row['id_producto'] . ", '" . $id_compra . "')\" class='borrar'><span class='fas fa-fw fa-trash'></span></a></td>";
            $fila .= "</tr>";
        }
        return $fila;
    }

    public function totalProductos($id_compra)
    {
        $resultado = $this->comprasTemporales->porCompra($id_compra);
        $total = 0;

        foreach ($resultado as $row) {
            $total += $row['subtotal'];
        }
        return $total;
    }

    public function eliminar($id_producto, $id_compra)
    {
        $datosExiste = $this->comprasTemporales->porIdProductoCompra($id_producto, $id_compra);

        if ($datosExiste) {
            if ($datosExiste->cantidad > 1) {
                $cantidad = $datosExiste->cantidad - 1;
                $subTotal = $cantidad * $datosExiste->precio;

                $this->comprasTemporales->actualizarProductoCompra($id_producto, $id_compra, $cantidad, $subTotal);
            } else {

                $this->comprasTemporales->eliminarProductoCompra($id_producto, $id_compra);
            }
        }

        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = number_format($this->totalProductos($id_compra), 2, '.', ',');
        $res['error'] = "";

        echo json_encode($res);
    }

    public function actualizarCantidad($id_producto, $id_compra, $nueva_cantidad)
    {
        $datosExiste = $this->comprasTemporales->porIdProductoCompra($id_producto, $id_compra);

        if ($datosExiste) {
            $subTotal = $nueva_cantidad * $datosExiste->precio;

            $this->comprasTemporales->actualizarProductoCompra($id_producto, $id_compra, $nueva_cantidad, $subTotal);
        }

        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = Configuracion::cambiarFormatoPrecio($this->totalProductos($id_compra));
        $res['error'] = "";

        echo json_encode($res);
    }
}

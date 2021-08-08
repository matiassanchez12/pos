<?php

use App\Controllers\Configuracion;

$id_compra = uniqid();

Configuracion::cambiarFormatoPrecio(123);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>/compras/guarda">

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra; ?>">
                    <input type="hidden" id="id_producto" name="id_producto">
                    <label class="text-gray-800">Código de barras</label>
                    <div class="input-group ui-widget">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-fw fa-barcode"></span>
                            </div>
                        </div>
                        <input type="text" name="codigo" id="codigo" class="form-control ui-autocomplete-input" placeholder="Ingresar codigo" autocomplete="off" autofocus>
                        <label for="codigo" id="resultado_error" class="text-danger"></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <table id="tablaProductos" width="100%" class="table table-hover table-striped table-sm table-responsive tablaProductos">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th width="1%"></th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 offset-md-6">
                <label style="font-weight: bold; font-size: 30px; text-align: center;">
                    Total <?php echo Configuracion::GetSimboloMoneda()?>
                </label>
                <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;">
                <button type="button" id="completa_compra" class="btn btn-success"><i class="fas fa-check-circle"></i> Completar compra</button>
            </div>
        </div>
    </form>
</div>
</div>
    
<script>
    $(document).ready(function() {
        $("#completa_compra").click(function() {
            let nFila = $("#tablaProductos tr").length;
            if (nFila < 2) {alert('Ingresar productos')} else {
                $("#form_compra").submit();
            }
        })
    });

    $(function() {
        $("#codigo").autocomplete({
            source: "<?php echo base_url(); ?>/productos/autocompleteData",
            minLength: 1,
            select: function(event, ui) {
                event.preventDefault();
                $("#codigo").val(ui.item.value);
                setTimeout(
                    function() {
                        e = jQuery.Event("keypress");
                        e.which = 13;
                        agregarProducto(ui.item.id, 1, '<?php echo $id_compra; ?>');
                    }
                )
            }
        })
    })

    function agregarProducto(id_producto, cantidad, id_compra) {
        if (id_producto != null && id_producto != 0 && cantidad > 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>/temporalCompras/insertar/' + id_producto + "/" + cantidad + "/" + id_compra,
                dataType: 'json',
                success: function(resultado) {
                    if (resultado == 0) {

                    } else {
                        let datos = resultado;
                        if (datos.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(datos.datos);
                            $("#total").val(datos.total);
                            $("#id_producto").val('');
                            $("#nombre").val('');
                            $("#codigo").val('');
                            $("#codigo").focus();
                            $("#precio_compra").val('');
                            $("#subtotal").val('');
                        }
                    }
                }
            })
        } else {
            if (cantidad == 0) {
                alert('La cantidad debe ser mayor a 0');
            } else {
                alert('Ingresar producto');
            }
        }
    }

    function eliminarProducto(id_producto, id_compra) {
        $.ajax({
            url: '<?php echo base_url(); ?>/temporalCompras/eliminar/' + id_producto + "/" + id_compra,
            dataType: 'json',
            success: function(resultado) {
                if (resultado == 0) {
                    $(tagCodigo).val('');
                } else {
                    var data = resultado;
                    $("#tablaProductos tbody").empty();
                    $("#tablaProductos tbody").append(data.datos);
                    $("#total").val(data.total);
                }
            }
        })
    }

    function cambiarCantidad(id_producto, id_venta, objecto) {
        $.ajax({
            url: '<?php echo base_url(); ?>/temporalCompras/actualizarCantidad/' + id_producto + "/" + id_venta + "/" + objecto.value,
            dataType: 'json',
            success: function(resultado) {
                if (resultado == 0) {
                    $(tagCodigo).val('');
                } else {
                    console.log(resultado)
                    var data = resultado;
                    $("#tablaProductos tbody").empty();
                    $("#tablaProductos tbody").append(data.datos);
                    $("#total").val(data.total);
                }
            }
        })
    }
</script>
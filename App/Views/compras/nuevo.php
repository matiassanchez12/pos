<?php
$id_compra = uniqid();
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
                    <label>Codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingresar un codigo y presionar enter..." onkeyup="buscarProducto(event, this, this.value)" autofocus>
                    <label for="codigo" id="resultado_error" class="text-danger"></label>
                </div>
                <div class="col-12 col-sm-4">
                    <label>Nombre del producto:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" disabled>
                </div>
                <div class="col-12 col-sm-4">
                    <label>Cantidad:</label>
                    <input onchange="calcularSubTotal(this.value)" type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Ingresar cantidad y presionar enter...">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <label>Precio de compra:</label>
                    <input type="text" name="precio_compra" id="precio_compra" class="form-control" disabled>
                </div>
                <div class="col-12 col-sm-4">
                    <label>Subtotal:</label>
                    <input type="text" name="subtotal" id="subtotal" class="form-control" disabled>
                </div>
                <div class="col-12 col-sm-4 align-self-end">
                    <label>&nbsp;</label>
                    <button id='agregar_producto' name="agregar_producto" type="button" onclick="agregarProducto(id_producto.value, cantidad.value, '<?php echo $id_compra ?>')" class="btn-lg btn-primary">Agregar producto</button>
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
                    Total $
                </label>
                <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;">
                <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
            </div>
        </div>
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<script src="<?php echo base_url(); ?>/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#completa_compra").click(function() {
            let nFila = $("#tablaProductos tr").length;
            console.log("asd");
            if (nFila < 2) {
                console.log("asd");
            } else {
                $("#form_compra").submit();
            }
        })
    });

    function buscarProducto(e, tagCodigo, codigo) {
        var enterKey = 13;

        if (codigo != '') {
            if (e.which == enterKey) {
                $.ajax({
                    url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo,
                    dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            $(tagCodigo).val('');
                        } else {
                            $("#resultado_error").html(resultado.error);

                            if (resultado.existe) {
                                $("#id_producto").val(resultado.datos.id);
                                $("#nombre").val(resultado.datos.nombre);
                                $("#cantidad").val(1);
                                $("#precio_compra").val(resultado.datos.precio_compra);
                                $("#subtotal").val(resultado.datos.precio_compra);
                                $("#cantidad").focus();
                            } else {
                                $("#id_producto").val('');
                                $("#nombre").val('');
                                $("#cantidad").val('');
                                $("#precio_compra").val('');
                                $("#subtotal").val('');
                            }
                        }
                    }
                })
            }
        }
    }

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
                            $("#cantidad").val('');
                            $("#precio_compra").val('');
                            $("#subtotal").val('');
                        }
                    }
                }
            })
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

    function calcularSubTotal(cantidad) {
        //Valido que sea un numero
        //Agregar un error con color rojo si no lo es
        if (cantidad != null && !isNaN(cantidad)) {

            precio = $("#precio_compra").val() * cantidad;
            $("#subtotal").val(precio);
        } else {
            console.log("ingresar solo numeros");
        }
    }

</script>
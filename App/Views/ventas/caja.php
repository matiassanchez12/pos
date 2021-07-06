    <?php 

    $idVentaTmp = uniqid();

    ?>

    <div class="container-fluid">

        <br>

        <form id="form_venta" name="form_venta" class="form_horizontal" method="POST" action="<?php echo base_url(); ?>/ventas/guarda" autocomplete="off">

            <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $idVentaTmp; ?>">

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ui-widget">
                            <label>Cliente: </label>
                            <input type="hidden" id="id_cliente" name="id_cliente" value="5">
                            <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escribe el nombre del cliente" value="Público en general" onkeyup="agregarProducto(event, this.value, 1, '<?php echo $idVentaTmp; ?>')" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Forma de pago: </label>
                        <Select id="forma_pago" name="forma_pago" class="form-control" required>
                            <option value="001">Efectivo</option>
                            <option value="002">Tarjeta</option>
                            <option value="003">Transferencia</option>
                        </Select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ui-widget">
                            <label>Código de barras: </label>
                            <input type="hidden" id="id_producto" name="id_producto" value="1">
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingresar codigo" onkeyup="agregarProducto(event, this.value, 1, '<?php echo $idVentaTmp; ?>')" autocomplete="off" autofocus required>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <label for="codigo" id="resultado_error" class="text-danger"></label>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;">
                            Total $
                        </label>
                        <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="button" id="completa_venta" class="btn btn-success">Completar venta</button>
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

        </form>
    </div>
    </div>

    <script>
        $(function() {
            $("#cliente").autocomplete({
                source: "<?php echo base_url(); ?>/clientes/autocompleteData",
                minLength: 1,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#id_cliente").val(ui.item.id);
                    $("#cliente").val(ui.item.value);
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
                            agregarProducto(e, ui.item.id, 1, '<?php echo $idVentaTmp; ?>');
                        }
                    )
                }
            })
        })

        $(function() {
            $("#completa_venta").click(function() {
                let nFilas = $("#tablaProductos tr").length;

                if (nFilas >= 2) {
                    $("#form_venta").submit();
                } else {
                    alert("Agregar un producto");
                }
            })
        });


        function agregarProducto(e, id_producto, cantidad, id_venta) {
            let enterKey = 13;

            if (codigo != '') {
                
                if (e.which == enterKey) {
                    if (id_producto != null && id_producto != 0 && cantidad > 0) {

                        $.ajax({
                            url: '<?php echo base_url(); ?>/temporalCompras/insertar/' + id_producto + "/" + cantidad + "/" + id_venta,
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
        }

        function eliminarProducto(id_producto, id_venta) {
        $.ajax({
            url: '<?php echo base_url(); ?>/temporalCompras/eliminar/' + id_producto + "/" + id_venta,
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
    </script>
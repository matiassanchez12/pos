    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <form method="POST" action="<?php echo base_url(); ?>/compras/insertar">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label>Código de barras:</label>
                        <input type="text" name="codigo_barras" id="codigo_barras" class="form-control" autofocus required>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label>Nombre producto:</label>
                        <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label>Cantidad:</label>
                        <input type="text" name="cantidad" id="cantidad" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label>Precio de compra:</label>
                        <input type="text" name="precio_compra" id="precio_compra" class="form-control" required>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label>Subtotal:</label>
                        <input type="text" name="subtotal" id="subtotal" class="form-control" required>
                    </div>
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-primary">Agregar producto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
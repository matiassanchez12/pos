    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" action="<?php echo base_url(); ?>/cajas/cerrar_caja">

            <input type="hidden" name="id_arqueo" id="id_arqueo" value="<?php echo $arqueo['id']; ?>">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Numero de caja:</label>
                        <input type="text" name="numero_caja" id="numero_caja" class="form-control" value="<?php echo $datos['numero_caja']; ?>" autofocus required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre de la caja:</label>
                        <input type="text" name="nombre_caja" id="nombre_caja" class="form-control" value="<?php echo $datos['nombre_caja']; ?>" required>
                    </div>
                </div>

            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Monto inicial:</label>
                        <input type="text" name="monto_inicial" id="monto_inicial" class="form-control" value="<?php echo $arqueo['monto_inicial']; ?>" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Monto final:</label>
                        <input type="text" name="monto_final" id="monto_final" class="form-control" value="<?php  ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Hora:</label>
                        <input type="text" name="hora" id="hora" class="form-control" value="<?php echo date('H:i:s'); ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Monto de ventas:</label>
                        <input type="text" name="monto_ventas" id="monto_ventas" class="form-control" value="<?php echo $monto_total['total']; ?>" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Total de ventas:</label>
                        <input type="text" name="total_ventas" id="total_ventas" class="form-control" required>
                    </div>
                </div>
            </div>

            <a href="<?php echo base_url(); ?>/cajas" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Agregar</button>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
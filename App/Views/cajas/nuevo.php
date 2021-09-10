    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-users"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" action="<?php echo base_url() . '/cajas/insertar'; ?>">

            <div class="form-group card p-4 shadow">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Numero de caja:</label>
                        <input type="text" name="numero_caja" id="numero_caja" class="form-control" value="<?php echo set_value('numero_caja') ?>" autofocus required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre de la caja:</label>
                        <input type="text" name="nombre_caja" id="nombre_caja" class="form-control" value="<?php echo set_value('nombre_caja') ?>" required>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-sm-6">
                        <label>Folio:</label>
                        <input type="text" name="folio" id="folio" class="form-control" value="<?php echo set_value('folio') ?>" required>
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
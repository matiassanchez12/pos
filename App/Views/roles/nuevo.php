    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-4 text-gray-800"><i class="fas fa-user-tag"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" action="<?php echo base_url(); ?>/roles/insertar">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo set_value('nombre') ?>" autofocus required>
                    </div>
                </div>
            </div>

            <a href="<?php echo base_url(); ?>/roles" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Agregar</button>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
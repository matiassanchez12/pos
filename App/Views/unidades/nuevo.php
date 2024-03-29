    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-balance-scale"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" action="<?php echo base_url(); ?>/unidades/insertar">

            <div class="form-group card shadow p-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo set_value('nombre') ?>" autofocus required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre corto</label>
                        <input type="text" name="nombre_corto" id="nombre_corto" class="form-control" value="<?php echo set_value('nombre_corto') ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
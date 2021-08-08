    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-key"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>


        <form method="POST" action="<?php echo base_url() . '/usuarios/actualizar_password/' . $usuario['id'] ;?> ">
            <input type="hidden" value="<?php echo $usuario['id']; ?>" name="id">

            <div class="form-group card shadow p-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Usuario:</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $usuario['usuario']; ?>" disabled>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" disabled>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-sm-6">
                        <label>Nueva contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Confirmar contraseña:</label>
                        <input type="password" name="repassword" id="repassword" class="form-control" required>
                    </div>
                </div>
            </div>

            <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>

            <?php if (isset($mensaje)) { ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
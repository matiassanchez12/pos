    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-edit"></i> <?php echo $titulo ?></h4>

        <form method="POST" action="<?php echo base_url(); ?>/categorias/actualizar">
            <input type="hidden" value="<?php echo $datos['id']; ?>" name="id">

            <div class="form-group card shadow p-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $datos['nombre']; ?>" autofocus require>
                    </div>
                </div>
            </div>

            <a href="<?php echo base_url(); ?>/categorias" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
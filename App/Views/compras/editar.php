    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <form method="POST" action="<?php echo base_url(); ?>/unidades/actualizar">
            <input type="hidden" value="<?php echo $datos['id']; ?>" name="id">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $datos['nombre']; ?>" autofocus require>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre corto</label>
                        <input type="text" name="nombre_corto" id="nombre_corto" class="form-control" value="<?php echo $datos['nombre_corto']; ?>" require>
                    </div>
                </div>
            </div>

            <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
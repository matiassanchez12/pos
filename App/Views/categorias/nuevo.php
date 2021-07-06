    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800 mb-4"><i class="fas fa-clipboard-list"></i> <?php echo $titulo ?></h4>

        <form method="POST" action="<?php echo base_url(); ?>/categorias/insertar">

            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" autofocus require>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <a href="<?php echo base_url(); ?>/categorias" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>

        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
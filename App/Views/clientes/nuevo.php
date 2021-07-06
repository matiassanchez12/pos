    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> <?php echo $titulo ?></h4>

        <form method="POST" action="<?php echo base_url(); ?>/clientes/insertar">

            <?php echo csrf_field(); ?>

            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label><span class="text-danger">*</span>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escribe aqui el nombre" autofocus required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-sm-12">
                        <label>Direccion</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Escribe aqui la direccion" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-sm-6">
                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Escribe aqui el telefono" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Correo Electrónico</label>
                        <input type="text" name="correo_electronico" id="correo_electronico" class="form-control" placeholder="Escribe aqui el correo electrónico" required>
                    </div>
                </div>
                <p class="text-danger mt-3">( * ) Campo obligatorio</p>
            </div>
            <div class="mt-5">
                <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>


    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    
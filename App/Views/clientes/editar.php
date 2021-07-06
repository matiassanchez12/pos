    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <form method="POST" action="<?php echo base_url(); ?>/clientes/actualizar">
            <input type="hidden" value="<?php echo $cliente['id']; ?>" name="id">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label><span class="text-danger">*</span>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $cliente["nombre"] ?>" autofocus require>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-sm-12">
                        <label>Direccion</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $cliente["direccion"] ?>" require>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-sm-6">
                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $cliente["telefono"] ?>" require>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Correo Electrónico</label>
                        <input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $cliente["correo_electronico"] ?>" require>
                    </div>
                </div>
                <p class="text-danger mt-3">( * ) Campo obligatorio</p>
            </div>

            <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>

        <input type="text" id="input-check" value="<?php echo (session()->res != null) ? session()->res : ''; ?>" hidden>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    <script>
        $(document).ready(function() {
            if ($("#input-check").val() == 'ok') {
                $(".toast").toast('show');
            }
        });
    </script>
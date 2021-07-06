<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h4 class="h3 mb-2 text-gray-800"><i class="fas fa-cogs"></i> <?php echo $titulo ?></h4>

    <?php if (isset($validation)) { ?>
        <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/configuracion/actualizar">

        <div class="row  mt-4">
            <div class="form-group col-12 col-sm-8">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre de la tienda:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $datos['nombre'] ?>" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>RFC:</label>
                        <input type="text" name="rfc" id="rfc" class="form-control" value="<?php echo $datos['rfc'] ?>" required>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-sm-6">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $datos['telefono'] ?>" required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Correo electrónico:</label>
                        <input type="text" name="correo" id="correo" class="form-control" value="<?php echo $datos['correo'] ?>" required>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-sm-6">
                        <label>Dirección:</label>
                        <textarea name="direccion" id="direccion" class="form-control" required><?php echo $datos['direccion'] ?></textarea>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Leyenda ticket:</label>
                        <textarea name="ticket_leyenda" id="ticket_leyenda" class="form-control" required><?php echo $datos['leyenda'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group col-12 col-sm-4 text-center">
                <h5 class="text-gray-800" id="titulo_imagen"><i class="fas fa-camera"></i> Logotipo de la empresa</h5>
                <input type="file" name="tienda_logo" id="tienda_logo" onchange="previewFile()" accept="image/*" hidden>

                <label for="tienda_logo" class="mt-4 mb-4 mx-auto d-block position-relative" style="width:180px; height:200px;">
                    <img src="<?php echo base_url() . "/images/logotipo.png?" . time()   ; ?>" id="imagen" class="btn img-effect img-responsive p-0 img-thumbnail" alt="img" style="max-width: 100%; height:200px">

                    <span tabindex="0" class="position-absolute ml-3" data-toggle="tooltip" title="Cargar imagen en formato png de 150x150 pixeles">
                        <button class="btn btn-dark rounded-circle btn-sm" style="pointer-events: none; width: 30px; position: relative; right: 1em;" type="button" disabled><i class="fas fa-info"></i></button>
                    </span>
                </label>

                <label for="tienda_logo" class="btn btn-outline-dark btn-sm">Subir imagen <i class="fas fa-image"></i></label>
            </div>
        </div>

        <button type="submit" class="btn btn-success" class="btnEnviar">Guardar</button>
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function previewFile() {
        var preview = document.querySelector('#imagen');
        var file = document.querySelector('#tienda_logo').files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    $(document).ready(function() {
        if ("<?php echo session()->res; ?>" == 'ok') {
            $(".toast").toast('show');
        }
    });
</script>
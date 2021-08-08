    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-box"></i> <?php echo $titulo ?></h4>
        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/insertar">

            <div class="row">
                <div class="form-group card p-4 shadow col-12 col-sm-7">
                    <h5 class="m-0 text-gray-800">Datos del producto</h5>
                    <hr class="sidebar-divider d-none d-md-block">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Código</label>
                            <div class="d-flex">
                                <input type="text" name="codigo" id="codigo" class="form-control" onblur="buscarProducto(this, this.value)" required autofocus>
                                <span class="btn btn-dark" onclick="generateCode()" title="Generar codigo random"><i class="fas fa-random"></i></span>
                            </div>
                            <div id="validacionCodigo" class="invalid-feedback">
                                El c&oacute;digo ya existe.
                            </div>
                        </div>
                        <div class="mt-3 col-12 col-sm-12">
                            <label>Descripción</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo set_value('nombre') ?>" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Unidad</label>
                            <select name="id_unidad" class="form-control" id="id_unidad" required>
                                <option value="Sin unidad">Sin unidad</option>
                                <?php foreach ($unidades as $unidad) { ?>
                                    <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Categoria</label>
                            <select name="id_categoria" class="form-control" id="id_categoria" required>
                                <option value="Sin categoria">Sin categoria</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Precio venta</label>
                            <input type="text" name="precio_venta" id="precio_venta" class="form-control" value="0.00" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Precio costo</label>
                            <input type="text" name="precio_compra" id="precio_compra" class="form-control" value="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="card p-4 ml-5 form-group col-12 col-sm-4 text-center" style="align-self: center;">
                    <h5 class="text-gray-800 " id="titulo_imagen"><i class="fas fa-camera"></i> Imagen del producto</h5>
                    <hr class="sidebar-divider d-none d-md-block">
                    <input type="file" name="imagen_producto" id="imagen_producto" onchange="previewFile()" accept="image/*" hidden>

                    <label for="imagen_producto" class="mt-4 mb-4 mx-auto d-block position-relative" style="width:180px; height:150px;">
                        <img src="<?php echo base_url() . "/images/productos/default.png"; ?>" id="imagen" class="btn img-effect p-0 img-responsive rounded-circle img-thumbnail" alt="img" style="max-width: 100%; height:150px">

                        <span tabindex="0" class="position-absolute" data-toggle="tooltip" title="Cargar imagen en formato .png de 150x150 pixeles">
                            <button class="btn btn-dark rounded-circle btn-sm" style="pointer-events: none; width: 30px;" type="button" disabled><i class="fas fa-info"></i></button>
                        </span>
                    </label>

                    <label for="imagen_producto" class="btn btn-outline-dark btn-sm">Subir imagen <i class="fas fa-image"></i></label>
                </div>
            </div>

            <div class="form-group card shadow p-4">
                <h4 class="h4 m-0 text-gray-800">Inventario</h4>
                <hr class="sidebar-divider d-none d-md-block">
                <div class="row justify-content-left">
                    <div class="col-12 col-sm-4">
                        <div class="form-check mt-3 mb-3">
                            <input type="checkbox" class="form-check-input" name="inventariable" id="inventariable">
                            <label class="form-check-label" for="inventariable">Marcar si utiliza inventario</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock minimo</label>
                        <input type="text" name="stock_minimo" id="stock_minimo" class="form-control" value="0" disabled required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Existencias actuales</label>
                        <input type="text" name="existencias" id="existencias" class="form-control" value="0" disabled required>
                    </div>
                </div>
            </div>
            <div>
                <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <div class="modal" id="modal-avatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Elegir avatar</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="avatar-section" style="display:flex; flex-wrap: wrap; justify-content: center;">

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('input[type="checkbox"]').on('change', function() {
            this.value ^= 1;
            if (this.value > 0) {
                $("#stock_minimo").prop("disabled", false);
                $("#existencias").prop("disabled", false);
            } else {
                $("#stock_minimo").prop("disabled", true);
                $("#existencias").prop("disabled", true);
            }
        });

        function buscarProducto(tagCodigo, codigo) {
            if (codigo != '') {
                $.ajax({
                    url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo,
                    dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            $(tagCodigo).val('');
                        } else {
                            if (resultado.existe) {
                                $(tagCodigo).prop('aria-describedby', 'validacionCodigo');
                                $(tagCodigo).prop('class', 'form-control is-invalid');
                                $(tagCodigo).val('');
                                $(tagCodigo).focus();
                                $('#validacionCodigo').prop('class', 'd-block invalid-feedback');
                            } else {
                                $('#validacionCodigo').prop('class', 'd-none invalid-feedback');
                                $(tagCodigo).removeProp('aria-describedby');
                                $(tagCodigo).prop('class', 'form-control');
                            }
                        }
                    }
                })
            }
        }

        function previewFile() {
            var preview = document.querySelector('#imagen');
            var file = document.querySelector('#imagen_producto').files[0];
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

        function generateCode() {
            let num = Math.floor(Math.random() * 99999) + 11111;
            $('#codigo').focus();
            $('#codigo').val(num);
        }
    </script>
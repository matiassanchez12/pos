    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="mb-4 text-gray-800"><i class="fas fa-edit"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>



        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/actualizar">
            <input type="hidden" value="<?php echo $producto['id']; ?>" name="id" id="id">
            <div class="row">
                <div class="form-group col-12 col-sm-7 card shadow p-4">
                    <h5 class="m-0 text-gray-800">Datos del producto</h5>
                    <hr class="sidebar-divider d-none d-md-block">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Código</label>
                            <div class="d-flex">
                                <input type="text" name="codigo" id="codigo" class="form-control" value="<?php echo $producto["codigo"] ?>" onblur="buscarProducto(this, this.value)" required autofocus>
                                <span class="btn btn-dark" onclick="generateCode()" title="Generar codigo random"><i class="fas fa-random"></i></span>
                            </div>
                            <div id="validacionCodigo" class="d-none invalid-feedback">
                                El c&oacute;digo ya existe.
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 mt-3">
                            <label>Descripción</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $producto["nombre"] ?>" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Unidad</label>
                            <select name="id_unidad" class="form-control" id="id_unidad">
                                <option value="">Seleccionar Unidad</option>
                                <?php foreach ($unidades as $unidad) { ?>
                                    <option value="<?php echo $unidad['id']; ?>" <?php if ($unidad["id"] == $producto["id_unidad"]) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $unidad['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Categoria</label>
                            <select name="id_categoria" class="form-control" id="id_categoria">
                                <option value="">Seleccionar Categoria</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id']; ?>" <?php if ($categoria["id"] == $producto["id_categoria"]) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $categoria['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Precio venta</label>
                            <input type="text" name="precio_venta" id="precio_venta" value="<?php echo $producto["precio_venta"] ?>" class="form-control" value="0.00" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Precio costo</label>
                            <input type="text" name="precio_compra" id="precio_compra" value="<?php echo $producto["precio_compra"] ?>" class="form-control" value="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12 col-sm-4 text-center card p-4 ml-5" style="align-self: center;">
                    <h5 class="text-gray-800 " id="titulo_imagen"><i class="fas fa-camera"></i> Imagen del producto</h5>
                    <hr class="sidebar-divider d-none d-md-block">
                    <input type="file" name="imagen_producto" id="imagen_producto" onchange="previewFile()" accept="image/*" hidden>

                    <label for="imagen_producto" class="mt-4 mb-4 mx-auto d-block position-relative" style="width:180px; height:150px;">
                        <img src="<?php echo base_url() . "/public/images/productos/" . $producto["id"] . ".png?" . time(); ?>; ?>" id="imagen" class="btn img-effect p-0 img-responsive rounded-circle img-thumbnail" alt="img" style="max-width: 100%; height:150px">

                        <span tabindex="0" class="position-absolute" data-toggle="tooltip" title="Cargar imagen en formato png de 150x150 pixeles">
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
                        <div class="form-check  mt-3 mb-3">
                            <input type="checkbox" class="form-check-input" name="inventariable" id="inventariable" onchange="cambioValue(this.value)" value="<?php echo ($producto['inventariable']) ?>" <?php echo ($producto['inventariable']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="inventariable">Marcar si utiliza inventario</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock minimo</label>
                        <input type="text" name="stock_minimo" id="stock_minimo" class="form-control" value="<?php echo $producto["stock_minimo"] ?>" <?php echo ($producto['inventariable']) ? '' : 'disabled'; ?> required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Existencias actuales</label>
                        <input type="text" name="existencias" id="existencias" class="form-control" value="<?php echo $producto["existencias"]  ?>" <?php echo ($producto['inventariable']) ? '' : 'disabled'; ?> required>
                    </div>
                </div>
            </div>
            <div>
                <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('input[type="checkbox"]').on('change', function() {
            this.value = (this.value == 1) ? 0 : 1;

            if (value == 0) {
                $("#stock_minimo").prop("disabled", false);
                $("#existencias").prop("disabled", false);
            }

            if (value == 1) {
                $("#stock_minimo").prop("disabled", true);
                $("#existencias").prop("disabled", true);
            }
        });

        function cambioValue(value) {
            if (value == 0) {
                $("#stock_minimo").prop("disabled", false);
                $("#existencias").prop("disabled", false);
            }

            if (value == 1) {
                $("#stock_minimo").prop("disabled", true);
                $("#existencias").prop("disabled", true);
            }
        }

        function buscarProducto(tagCodigo, codigo) {
            if (codigo !== '') {
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
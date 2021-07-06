    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-5 text-gray-800"><i class="fas fa-user"></i> <?php echo $titulo ?></h4>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/usuarios/insertar">
            <div class="row mb-4">
                <div class="form-group col-12 col-sm-8 mt-2">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo set_value('usuario') ?>" autofocus required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo set_value('nombre') ?>" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" value="<?php echo set_value('password') ?>" autofocus required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="repassword" id="repassword" class="form-control" value="<?php echo set_value('repassword') ?>" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Rol</label>
                            <select name="id_rol" class="form-control" id="id_rol" required>
                                <option value="">Seleccionar rol</option>
                                <?php foreach ($roles as $rol) { ?>
                                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Caja</label>
                            <select name="id_caja" class="form-control" id="id_caja" required>
                                <option value="">Seleccionar caja</option>
                                <?php foreach ($cajas as $caja) { ?>
                                    <option value="<?php echo $caja['id']; ?>"><?php echo $caja['nombre_caja']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12 col-sm-4 text-center">
                    <h5 class="text-gray-800" id="titulo_imagen"><i class="fas fa-camera"></i> Foto de perfil</h5>
                    <input type="file" name="imagen_usuario" id="imagen_usuario" onchange="previewFile()" accept="image/*" hidden>

                    <label for="imagen_usuario" class="mt-4 mb-4 mx-auto d-block position-relative" style="width:180px; height:150px;">
                        <img src="<?php echo base_url() . "/images/avatars/default.png"; ?>" id="imagen" class="btn img-effect p-0 img-responsive rounded-circle img-thumbnail" alt="img" style="max-width: 100%; height:150px">

                        <span tabindex="0" class="position-absolute" data-toggle="tooltip" title="Cargar imagen en formato png de 150x150 pixeles">
                            <button class="btn btn-dark rounded-circle btn-sm" style="pointer-events: none; width: 30px; position: relative; right: 1em;" type="button" disabled><i class="fas fa-info"></i></button>
                        </span>
                    </label>

                    <label for="imagen_usuario" class="btn btn-outline-dark btn-sm">Subir imagen <i class="fas fa-image"></i></label>

                    <label data-href="#" onclick="cargarAvatars()" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-avatar" data-placement="bottom">Elegir avatar <i class="fas fa-user-circle"></i></label>
                </div>

                <input type="text" name="src_avatar" id="src_avatar" hidden>
            </div>

            <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary ">Regresar</a>
            <button type="submit" class="btn btn-success">Agregar</button>
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

        function previewFile() {
            var preview = document.querySelector('#imagen');
            var file = document.querySelector('#imagen_usuario').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
                $('#src_avatar').attr('value', '');
            } else {
                preview.src = "";
            }
        }

        $(document).ready(function() {
            $(document).on('click', '#imagen_avatar', function(event) {
                var targest = $(event.target).attr('src');

                $('#imagen').attr('src', targest);
                $('#src_avatar').attr('value', targest);

                $('.selected').removeClass('selected');
                $(this).addClass('selected');
            })
        });

        function cargarAvatars() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . '/productos/mostrarAvatars'; ?>',
                success: function(resultado) {
                    $('#avatar-section').children().remove();
                    $('#avatar-section').append(resultado);
                }
            })
        }
    </script>
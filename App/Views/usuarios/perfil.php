<!-- Begin Page Content -->
<div class="container-fluid" style="display: flex;align-items: center;flex-direction: column;">

    <!-- Page Heading -->
    <input type="hidden" value="<?php echo $datos['id']; ?>" name="id">

    <div class="card w-75">
        <div class="row">
            <div class=" p-4 ml-5 form-group col-12 col-sm-4 text-center" style="align-self: center;">
                <label for="imagen_usuario" class="mt-4 mb-4 mx-auto d-block position-relative" style="width:180px; height:150px;">
                    <img src="<?php echo base_url() . "/images/avatars/users-upload/" .  $datos['id'] . ".png?" . time(); ?>" id="imagen" class="img-responsive rounded-circle img-thumbnail" alt="img" style="max-width: 100%; height:150px">
                </label>
            </div>

            <div class="form-group col-12 col-sm-4 p-4">
                <h4 class="m-0 text-gray-900"><?php echo $datos['nombre']; ?></h4>
                <hr class="sidebar-divider d-none d-md-block">
                <div>
                    <table width="90%" style="border-spacing: 0 10px; border-collapse: separate;">
                        <tbody>
                            <tr style="font-size: 1.1em;">
                                <td>
                                    <b class="text-gray-900">Usuario:</b>
                                </td>
                                <td class="text-gray-800"><?php echo $datos['usuario']; ?></td>
                            </tr >
                            <tr style="font-size: 1.1em;">
                                <td>
                                    <b class="text-gray-900">Rol:</b>
                                </td>
                                <td class="text-gray-800"><?php foreach ($roles as $rol) {
                                        if ($rol['id'] == $datos['id_rol']) {
                                            echo $rol['nombre'];
                                        }
                                    } ?></td>
                            </tr>
                            <tr style="font-size: 1.1em;">
                                <td>
                                    <b class="text-gray-900">Caja:</b>
                                </td>
                                <td class="text-gray-800"><?php foreach ($cajas as $caja) {
                                        if ($caja['id'] == $datos['id_caja']) {
                                            echo $caja['nombre_caja'];
                                        }
                                    } ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <input type="text" name="src_avatar" id="src_avatar" hidden>
    </div>
    <div class="w-75">
        <a href="<?php echo base_url() . "/usuarios/editar/" . $datos['id']; ?>" class="btn btn-primary mt-3">Editar mi perfil</a>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
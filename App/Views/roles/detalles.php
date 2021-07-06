    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-4 text-gray-800"><i class="fas fa-user-shield"></i> <?php echo $titulo ?></h4>

        <form id="form_permisos" name="form_permisos" method="POST" action="<?php echo base_url() . "/roles/guardaPermisos"; ?>">

            <input type="hidden" name="id_rol" value="<?php echo $id_rol; ?>">

            <?php
            foreach ($permisos as $permiso) {   ?>
                <input class="form-checkbox-input" type="checkbox" value="<?php echo $permiso['id'] . "-" . $permiso['ruta'] ?>" name="permisos[]" <?php echo (isset($permisoAsignado[$permiso['id']])) ? 'checked' : '' ?>>

                <label class="form-checkbox-input"><?php echo $permiso['nombre'] . "- Ruta : " . $permiso['ruta']; ?></label>
                <br>
            <?php }  ?>

            <button type="submit" class="btn btn-success mt-4">Guardar</button>
        </form>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
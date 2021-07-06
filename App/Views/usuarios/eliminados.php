    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <div>
            <p>
                <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-info"><i class="fas fa-arrow-left"></i> Usuarios</a>
            </p>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Caja</th>
                                <th>Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) { ?>
                                <tr>
                                <td><?php echo $dato['id']; ?></td>
                                    <td><?php echo $dato['usuario']; ?></td>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td>
                                    <?php foreach ($cajas as $caja) 
                                    {
                                        if($caja['id'] == $dato['id_caja']){
                                            echo $caja['nombre_caja'];
                                        }
                                    }?>
                                    </td>
                                    <td>
                                    <?php foreach ($roles as $rol) 
                                    {
                                        if($rol['id'] == $dato['id_rol']){
                                            echo $rol['nombre'];
                                        }
                                    }?>
                                    </td>
                                    <td class="text-center"><a href="#" data-href="<?php echo base_url() . '/usuarios/reingresar/' . $dato['id'] ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Reingresar registro" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-trash-restore-alt"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reingresar registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Desea reingresar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok">Si</a>
                </div>
            </div>
        </div>
    </div>
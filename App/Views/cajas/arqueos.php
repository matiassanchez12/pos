    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <div>
            <p>
                <a href="<?php echo base_url(); ?>/cajas/nuevo_arqueo" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
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
                                <th>Fecha apertura</th>
                                <th>Fecha cierre</th>
                                <th>Monto inicial</th>
                                <th>Monto final</th>
                                <th>Total ventas</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) { ?>
                                <tr>
                                    <td><?php echo $dato['id']; ?></td>
                                    <td><?php echo $dato['fecha_inicio']; ?></td>
                                    <td><?php echo $dato['fecha_fin']; ?></td>
                                    <td><?php echo $dato['monto_inicial']; ?></td>
                                    <td><?php echo $dato['monto_final']; ?></td>
                                    <td><?php echo $dato['total_ventas']; ?></td>
                                    <td class="text-center"><a href="<?php echo base_url() . '/cajas/cambiar_estado/' . $dato['id'] . '/' . $caja_actual ?>" class="btn <?php echo ($dato['estatus']) ? 'btn-success' : 'btn-secondary' ?>"> <?php echo ($dato['estatus']) ? 'Abierta' : 'Cerrada'; ?></a></td>
                                    <td class="text-center"><a href="<?php echo $dato['estatus'] ? base_url() . '/cajas/cerrar_caja/'. 1 : base_url() . '/cajas/mostrar_cierre' ?>" class="btn btn-sm rounded-circle <?php echo ($dato['estatus']) ? 'btn-danger' : 'btn-primary' ?>"><i class="fas <?php echo ($dato['estatus']) ? 'fa-lock' : 'fa-file-pdf' ?>"></i></a></td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok">Si</a>
                </div>
            </div>
        </div>
    </div>
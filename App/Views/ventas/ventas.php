    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php

use App\Controllers\Configuracion;

echo $titulo ?></h4>

        <div>
            <p>
                <a href="<?php echo base_url(); ?>/ventas/eliminadas" class="btn btn-info">Ver eliminadas <i class="fas fa-arrow-right"></i></a>
            </p>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Cajero</th>
                                <th class="text-center w-25">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $dato) { ?>
                                <tr>
                                    <td><?php echo $dato['folio']; ?></td>
                                    <td><?php echo $dato["cliente"]; ?></td>
                                    <td><?php echo Configuracion::GetSimboloMoneda() . Configuracion::cambiarFormatoPrecio($dato['total']); ?></td>
                                    <td><?php echo $dato['fecha_alta']; ?></td>
                                    <td><?php echo $dato["cajero"]; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url() . "/ventas/muestraTicket/" . $dato['id'] ?>" title="Editar" class="btn btn-primary btn-sm rounded-circle ml-2"><i class="fas fa-list-alt"></i></a>
                                        <a href="<?php echo base_url() . "/ventas/eliminar/" . $dato['id'] ?>" title="Editar" class="btn btn-danger btn-sm rounded-circle ml-2"><i class="fas fa-ban"></i></a>
                                    </td>
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
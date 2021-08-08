    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php

use App\Controllers\Configuracion;

echo $titulo ?></h4>

        <div>
            <p>
                <a href="<?php echo base_url(); ?>/compras/eliminadas" class="btn btn-info">Ver eliminadas <i class="fas fa-arrow-right"></i></a>
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
                                <th>Folio</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th class="text-center w-25">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($compras as $compra) { ?>
                                <tr>
                                    <td><?php echo $compra['id']; ?></td>
                                    <td><?php echo $compra['folio']; ?></td>
                                    <td><?php echo Configuracion::GetSimboloMoneda() . Configuracion::cambiarFormatoPrecio($compra['total']); ?></td>
                                    <td><?php echo $compra['fecha_alta']; ?></td>
                                    <td class="text-center"><a href="<?php echo base_url() . '/compras/muestraCompraPdf/' . $compra['id'] ?>" title="Ver registro en pdf" class="btn btn-primary btn-sm rounded-circle ml-2"><i class="fas fa-file-pdf"></i></a></td>
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
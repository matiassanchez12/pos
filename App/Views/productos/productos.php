    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

        <div>
            <p>
                <a href="<?php echo base_url(); ?>/productos/nuevo" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
                <a href="<?php echo base_url(); ?>/productos/mostrarCodigos" class="btn btn-light border border-dark"><i class="fas fa-barcode"></i> Códigos de barras</a>
                <a href="<?php echo base_url(); ?>/productos/eliminados" class="btn btn-info">Eliminados <i class="fas fa-arrow-right"></i></a>
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
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Existencias</th>
                                <th class="text-center w-25">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="t-body">
                            <?php
                            foreach ($datos as $dato) { ?>
                                <tr>
                                    <td><?php echo $dato['id']; ?></td>
                                    <td><?php echo $dato['codigo']; ?></td>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td><?php echo $dato['precio_venta']; ?></td>
                                    <td><?php echo $dato['existencias']; ?></td>
                                    <td class="text-center">
                                        <a href="#" data-href="" data-toggle="modal" data-target="#modal-imagen" data-placement="top" title="Mostrar imagen" class="btn-img btn btn-secondary btn-sm rounded-circle ml-2"><i class="fas fa-camera"></i></a>
                                        <a href="<?php echo base_url() . '/productos/editar/' . $dato['id'] ?>" title="Editar" class="btn btn-warning btn-sm rounded-circle ml-2"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="#" data-href="<?php echo base_url() . '/productos/eliminar/' . $dato['id'] ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger btn-sm rounded-circle ml-2"><i class="fas fa-trash"></i></a>
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

    <div class="modal fade" id="modal-imagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Imagen del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex align-self-center" id="imagen_modal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.t-body').on('click', '.btn-img', function() {
            var row = $(this).closest('tr');
            var id = row[0].childNodes[1].innerHTML;

            $('#modal-imagen').modal('show');
            $('#imagen_modal').append('<img src="<?php echo base_url() . "/images/productos/"; ?>' + id + '.png? <?php echo time(); ?>" id="imagen_product" class="img-responsive rounded-circle img-thumbnail" alt="img" style="max-width: 100%; height:150px">');
        })

        $('#modal-imagen').on('hidden.bs.modal', function() {
            $('#imagen_product').remove();
        })
    </script>
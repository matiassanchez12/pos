 <!-- Begin Page Content -->
 <div class="container-fluid">

     <!-- Page Heading -->
     <h4 class="h3 mb-2 text-gray-800"><?php echo $titulo ?></h4>

     <div>
         <p>
             <a href="<?php echo base_url(); ?>/clientes/nuevo" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
             <a href="<?php echo base_url(); ?>/clientes/eliminados" class="btn btn-info"> Eliminados <i class="fas fa-arrow-right"></i></a>
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
                             <th>Nombre</th>
                             <th>Direccion</th>
                             <th>Telefono</th>
                             <th>Correo Electrónico</th>
                             <th class="text-center w-25">Acciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            foreach ($datos as $dato) { ?>
                             <tr>
                                 <td><?php echo $dato['id']; ?></td>
                                 <td><?php echo $dato['nombre']; ?></td>
                                 <td><?php echo $dato['direccion']; ?></td>
                                 <td><?php echo $dato['telefono']; ?></td>
                                 <td><?php echo $dato['correo_electronico']; ?></td>
                                 <td class="text-center">
                                     <a href="<?php echo base_url() . '/clientes/editar/' . $dato['id'] ?>" class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pencil-alt"></i></a>
                                     <a href="#" data-href="<?php echo base_url() . '/clientes/eliminar/' . $dato['id'] ?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger btn-sm rounded-circle ml-2"><i class="fas fa-trash"></i></a>
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

 <script>
     $(document).ready(function() {
         if ("<?php echo session()->res; ?>" == 'ok') {
             $(".toast").toast('show');
         }
     });
 </script>
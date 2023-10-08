<?php

use App\Controllers\Configuracion;

$user_session = session();

$nombre_tienda = Configuracion::GetNombre();

$color_tema = Configuracion::GetColorTema();

$tamaño_fuente = Configuracion::GetFuente();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- 
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> -->

    <title>Sistema Punto de Venta</title>

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url(); ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>/public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/public/css/sb-admin-2.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>/public/css/styles.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>/public/js/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/public/vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top" style="font-size: <?php echo $tamaño_fuente; ?>px;">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    <div class="alert alert-success position-absolute toast" style="top: 10%; right:0;" data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true">
        <div class="toast-body">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            &#8287 Operación realizada con exito! &#8287 &#8287
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class='navbar-nav sidebar sidebar-dark accordion <?php echo $color_tema ?>' id="accordionSidebar" aria-expanded="true" aria-controls="accordionSidebar">

            <!-- Sidebar - Brand -->

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>/inicio">
                <div class="sidebar-brand-icon">
                    <img class="img-profile rounded-circle img-fluid" style="width: 38px; height: 38px;" src=<?php echo base_url() . "/public/images/logotipo.png?" . time(); ?>>
                </div>

                <div class="sidebar-brand-text mx-3"><?php echo $nombre_tienda; ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-shopping-basket"></i>
                    <span>Productos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url(); ?>/productos">Productos</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/unidades">Unidades</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/categorias">Categorias</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url(); ?>/clientes">
                    <i class="fas fa-users"></i>
                    <span>Clientes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Compras</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url(); ?>/compras/nuevo">Nueva compra</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/compras">Compras</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Ventas</span>
                </a>
                <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url(); ?>/ventas/venta">Nueva venta</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/ventas">Ventas realizadas</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url(); ?>/reportes">
                    <i class="fas fa-list"></i>
                    <span>Reportes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                    <i class="fas fa-tools"></i>
                    <span>Administración</span>
                </a>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url(); ?>/configuracion">Mi tienda</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/configuracion/general">Configuracion</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/usuarios">Usuarios</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/roles">Roles</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/cajas">Cajas</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>/logs">Logs de acceso</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user_session->nombre; ?></div>
                                <img class="img-profile rounded-circle" src="<?php echo base_url() . "/public/images/avatars/users-upload/" . $user_session->id_usuario . ".png?" . time(); ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo base_url() . '/usuarios/perfil' ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url() . '/usuarios/cambia_password/' . $user_session->id_usuario; ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
                                    Cambiar contraseña
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url() . '/logs/logs_usuario/' . $user_session->id_usuario; ?>">
                                    <i class="fas fa-list fa-sm fa-fw mr-2"></i>
                                    Registro de actividades
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Cerrar sesion
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Finalizar sesion</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Usuario : <?php echo $user_session->nombre; ?>, quiere finalizar la sesion?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                <a class="btn btn-primary" href="<?php echo base_url(); ?>/usuarios/logout">Salir</a>
                            </div>
                        </div>
                    </div>
                </div>



                <script src="<?php echo base_url(); ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

                <script src="<?php echo base_url(); ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>

                <script src="<?php echo base_url(); ?>/public/js/jquery-ui/jquery-ui.min.js"></script>

                <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>

                <link href="<?php echo base_url(); ?>/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

                <script src="<?php echo base_url(); ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="<?php echo base_url(); ?>/public/js/sb-admin-2.min.js"></script>

                <!-- Page level plugins -->

                <script src="<?php echo base_url(); ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="<?php echo base_url(); ?>/public/js/demo/datatables-demo.js"></script>

                <script src="<?php echo base_url(); ?>/public/js/Chart.min.js"></script>

                <script src="<?php echo base_url(); ?>/public/js/Chart.js"></script>
<?php
include('db/db.php');
$user_id = $_SESSION['userid'];
$query = "select username, nombres, apellidos, rol_id from user where id = '$user_id';";
$user = $db->query($query) or die($db->error . __LINE__);
$user = $user->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $nombre_pagina ?></title>
        <meta name="charset" content="UTF-8">
        <meta name="description" content="Sistema de informaciónn para la Droguería Somos Salud">
        <meta name="keywords" content="CRUD, Sistema, Información">
        <meta name="copyright" content="Copyright © 2017 gfrodriguez.online">
        <meta name="author" content="gfrodriguez">
        <meta name="designer" content="gfrodriguez">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="content-language" content="ES">
        <meta name="Rating" content="General">
        <meta name="Distribution" content="Global">
        <link rel="icon" type="image/x-icon" href="/assets/images/favicon.png">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.png"> 
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="/assets/plugins/select2/select2.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="/assets/plugins/datatables/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="/assets/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Sweet Alet -->
        <link rel="stylesheet" href="/assets/dist/css/sweetalert.css">
        <script src="/assets/dist/js/sweetalert.min.js"></script>
        <!-- jQuery 2.2.3 -->
        <script src="/assets/dist/js/moment.min.js"></script>
        <script src="/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/assets/plugins/jQueryUI/jquery-ui.min.js"></script>
        <!-- FullCalendar -->
        <link rel='stylesheet' type='text/css' href='/assets/plugins/fullcalendar/fullcalendar.min.css' />        
        <script src="/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
        <script src="/assets/plugins/fullcalendar/locale-all.js"></script>
        <script type='text/javascript' src='/assets/plugins/fullcalendar/gcal.js'></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="/" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><?php echo $logo_mini; ?></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><?php echo $logo_lg; ?></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <!-- Notifications: style can be found in dropdown.less -->
                            <!-- Tasks: style can be found in dropdown.less -->
                            <!-- User Account: style can be found in dropdown.less -->
                            <!-- Notifications: style can be found in dropdown.less -->
                            <!--<li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <!--<ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>                                            
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>-->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs"><?php echo $user['nombres'] . ' ' . $user['apellidos']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="/assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
                                        <p><?php echo $user['nombres'] . ' ' . $user['apellidos']; ?>
                                            <small>Miembro desde <?php
                                                $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
                                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                                echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
                                                ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/users/view/<?php echo $_SESSION['userid']; ?>" class="btn btn-default btn-flat">Perfil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/logout" class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li></li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <?php include('aside.php') ?>
            </aside>

<?php
$error = "<hr>";

$query = "SELECT rol.nombre as rol, user.nombres, user.id as id, user.apellidos, user.username, user.email, user.created_at FROM user, rol WHERE rol_id=rol.id and user.id='$id';";
$user = $db->query($query) or die($db->error . __LINE__);
$user = $user->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuarios
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/users/">Usuarios</a></li>
            <li class="active">Ver</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $error; ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Detalle del Usuario</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Nombres</th>
                                    <td><?php echo $user['nombres'] ?></td>
                                </tr>
                                <tr>
                                    <th>Apellidos</th>
                                    <td><?php echo $user['apellidos'] ?></td>           
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo $user['username'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Rol</th>
                                    <td><?php echo $user['rol'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Fecha de creación</th>
                                    <td><?php echo $user['created_at']; ?></td>                
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

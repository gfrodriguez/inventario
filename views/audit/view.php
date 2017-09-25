<?php
$error = "<hr>";
$query = "SELECT auditoria.id, auditoria.created_at, userbrowser, ipaddress, url, description, user.username FROM auditoria, user WHERE user.id=auditoria.user_id AND auditoria.id='$id'";
$auditoria = $db->query($query) or die($db->error . __LINE__);
$auditoria = $auditoria->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Auditoria
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/audit/">Auditoria</a></li>
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
                        <h3 class="box-title"><strong>Detalle de Auditoria</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Fecha Acceso</th>
                                    <td><?php echo $auditoria['created_at'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dirección IP</th>
                                    <td><?php echo $auditoria['ipaddress'] ?></td>           
                                </tr>
                                <tr>
                                    <th>Usuario</th>
                                    <td><?php echo $auditoria['username'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>URL</th>
                                    <td><?php echo $auditoria['url'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Navegador del Usuario</th>
                                    <td><?php echo $auditoria['userbrowser'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Descripción</th>
                                    <td><?php echo $auditoria['description'] ?></td>                 
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

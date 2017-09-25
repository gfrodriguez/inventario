<?php
$error = "<hr>";

$query = "SELECT * FROM proveedor where id='$id';";
$proveedor = $db->query($query) or die($db->error . __LINE__);
$proveedor = $proveedor->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Proveedores
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $error; ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Detalle del Proveedor</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Nombre</th>
                                    <td><?php echo $proveedor['nombre'] ?></td>
                                </tr>
                                <tr>
                                    <th>Nit</th>
                                    <td><?php echo $proveedor['nit'] ?></td>            
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td><?php echo $proveedor['direccion'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Teléfono</th>
                                    <td><?php echo $proveedor['telefono'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Correo</th>
                                    <td><?php echo $proveedor['email'] ?></td>                 
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

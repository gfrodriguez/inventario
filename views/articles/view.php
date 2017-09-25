<?php
$error = "<hr>";
$query = "SELECT articulo.id as articulo_id, articulo.nombre as articulo_nombre, presentacion.nombre as presentacion, laboratorio.nombre as laboratorio, stock, stock_minimo, valor_venta FROM articulo, presentacion, laboratorio WHERE articulo.id='$id' AND presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id;";
$articulo = $db->query($query) or die($db->error . __LINE__);
$articulo = $articulo->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Productos
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/articles/">Productos</a></li>
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
                        <h3 class="box-title"><strong>Detalle del Producto</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Nombre</th>
                                    <td><?php echo $articulo['articulo_nombre'] ?></td>
                                </tr>
                                <tr>
                                    <th>Laboratorio</th>
                                    <td><?php echo $articulo['laboratorio'] ?></td>           
                                </tr>
                                <tr>
                                    <th>Presentación</th>
                                    <td><?php echo $articulo['presentacion'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Precio de venta</th>
                                    <td><?php echo number_format($articulo['valor_venta'], 2, ',', '.'); ?></td>                 
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td><?php echo $articulo['stock'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Stock Mínimo</th>
                                    <td><?php echo $articulo['stock_minimo'] ?></td>                 
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

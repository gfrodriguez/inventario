<?php
$error = "<hr>";

$query = "SELECT compra.id as compra_id, articulo.nombre as articulo, presentacion.nombre as presentacion, laboratorio.nombre as laboratorio, factura.numero as factura, compra.cantidad as cantidad, compra.fecha_vencimiento as fecha_vencimiento, compra.valor_unitario as valor_unitario FROM compra, articulo, factura, presentacion, laboratorio WHERE articulo.id=compra.articulo_id AND compra.factura_id=factura.id AND presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id AND compra.id='$id';";
$compra = $db->query($query) or die($db->error . __LINE__);
$compra = $compra->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Compras
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/purchases/">Compra</a></li>
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
                        <h3 class="box-title"><strong>Detalle del Proveedor</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Factura</th>
                                    <td><?php echo $compra['factura'] ?></td>           
                                </tr>
                                <tr>
                                    <th>Producto</th>
                                    <td><?php echo $compra['articulo'] ?></td>
                                </tr>
                                <tr>
                                    <th>Laboratorio</th>
                                    <td><?php echo $compra['laboratorio'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Presentacion</th>
                                    <td><?php echo $compra['presentacion'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Cantidad</th>
                                    <td><?php echo $compra['cantidad'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Fecha de Vencimiento</th>
                                    <td><?php echo $compra['fecha_vencimiento'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Valor Unitario</th>
                                    <td><?php echo number_format($compra['valor_unitario'], 2, ',', '.'); ?></td>                
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

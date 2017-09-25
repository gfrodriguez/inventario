<?php
$error = "<hr>";

$query = "SELECT proveedor.nombre as proveedor, estado.nombre as estado, factura.id as id, numero, fecha_factura, fecha_vencimiento_factura, valor_iva, valor_factura
            FROM factura, proveedor, estado WHERE proveedor_id=proveedor.id and estado.id=factura.estado_id and factura.id='$id';";
$factura = $db->query($query) or die($db->error . __LINE__);
$factura = $factura->fetch(PDO::FETCH_ASSOC);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Facturas
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/bills/">Facturas</a></li>
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
                        <h3 class="box-title"><strong>Detalle de la Factura</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Proveedor</th>
                                    <td><?php echo $factura['proveedor'] ?></td>
                                </tr>
                                <tr>
                                    <th>Factura</th>
                                    <td><?php echo $factura['numero'] ?></td>           
                                </tr>
                                <tr>
                                    <th>Fecha de Factura</th>
                                    <td><?php echo $factura['fecha_factura'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Estado</th>
                                    <td><?php echo $factura['estado'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Fecha de Vencimiento</th>
                                    <td><?php echo $factura['fecha_vencimiento_factura'] ?></td>                 
                                </tr>
                                <tr>
                                    <th>Valor de IVA</th>
                                    <td><?php echo number_format($factura['valor_iva'], 2, ',', '.'); ?></td>                
                                </tr>
                                <tr>
                                    <th>Valor de la Factura</th>
                                    <td><?php echo number_format($factura['valor_factura'], 2, ',', '.'); ?></td>               
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
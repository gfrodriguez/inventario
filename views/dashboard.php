<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Principal
            <small>Panel de Control</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active fa fa-dashboard"> Principal</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Chart boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-9 col-md-9 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        Vencimiento de Facturas
                    </div>
                    <div class="box-body chart-responsive"> <!--data-widget="collapse"-->
                        <div class="chart">
                            <div id='calendar'></div>
                        </div>
                    </div>
                    <?php include 'views/charts/calendar.php'; ?>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <?php
                        $query = "SELECT sum(valor_factura) as total FROM factura WHERE estado_id='1';";
                        $factura = $db->query($query) or die($db->error . __LINE__);
                        $factura = $factura->fetch(PDO::FETCH_ASSOC);
                        $factura = $factura['total'];
                        ?>
                        <h3><?php echo number_format($factura, 2, ',', '.'); ?></h3>

                        <p>Facturas por pagar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/bills/" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <?php
                        $query = "SELECT ROUND((((SELECT SUM(factura.valor_factura) FROM factura WHERE estado_id='1')*100)/SUM(factura.valor_factura)),2) AS porcentaje FROM factura;";
                        $porcentaje = $db->query($query) or die($db->error . __LINE__);
                        $porcentaje = $porcentaje->fetch(PDO::FETCH_ASSOC);
                        $porcentaje = $porcentaje['porcentaje'];
                        ?>
                        <h3><?php echo number_format($porcentaje, 2, ',', '.'); ?><sup style="font-size: 20px">%</sup></h3>

                        <p>Facturas por pagar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php
                        $query = "SELECT sum(compra.cantidad*compra.valor_unitario) as total FROM compra, factura WHERE  WEEK(fecha_factura) = WEEK(CURDATE());";
                        $compra = $db->query($query) or die($db->error . __LINE__);
                        $compra = $compra->fetch(PDO::FETCH_ASSOC);
                        $compra = $compra['total'];
                        ?>
                        <h3><?php echo number_format($compra, 2, ',', '.'); ?></h3>

                        <p>Compras semanal</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a href="/purchases/" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <?php
                        $query = "SELECT sum(venta_detalle.cantidad*articulo.valor_venta) as total FROM venta, articulo, venta_detalle WHERE venta_detalle.articulo_id=articulo.id AND WEEK(fecha_venta) = WEEK(CURDATE());";
                        $venta = $db->query($query) or die($db->error . __LINE__);
                        $venta = $venta->fetch(PDO::FETCH_ASSOC);
                        $venta = $venta['total'];
                        ?>
                        <h3><?php echo number_format($venta, 2, ',', '.'); ?></h3>

                        <p>Ventas semanal</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a href="/sales/" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>    
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <!-- /.Small boxes (Stat box) -->
        <!-- /.row -->     
        <!-- Chart boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        Ventas
                    </div>
                    <div class="box-body chart-responsive"> <!--data-widget="collapse"-->
                        <div class="chart">
                            <div id="chartSales" style="height:250px"></div>
                        </div>
                    </div>
                    <?php include 'views/charts/sales.php'; ?>
                </div>
            </div>
            <!-- ./col -->
        </div>    
        <!-- /.row -->        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

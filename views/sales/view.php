<?php
$error = "<hr>";

$query = "SELECT venta_detalle.id as venta_detalle_id, venta_detalle.cantidad as cantidad, venta_detalle.cantidad*articulo.valor_venta as valor_vendido, articulo.nombre as articulo, laboratorio.nombre as laboratorio, presentacion.nombre as presentacion FROM venta, venta_detalle, articulo, laboratorio, presentacion WHERE venta_detalle.venta_id=venta.id and articulo.id=venta_detalle.articulo_id and presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id and venta.id=venta_detalle.venta_id AND venta_detalle.venta_id='$id';";
$sales_detail = $db->query($query) or die($db->error . __LINE__);

$query = "SELECT sum(cantidad*articulo.valor_venta) as valor_venta, fecha_venta FROM venta_detalle, venta, articulo WHERE venta_detalle.articulo_id=articulo.id AND venta.id=venta_detalle.venta_id AND venta_id='$id';";
$sales = $db->query($query) or die($db->error . __LINE__);
$sales = $sales->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $query = "DELETE FROM venta_detalle WHERE id = $delete_id;";
        $delete = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' eliminó una venta', $_SESSION['userid']);
        unset($_POST['delete_id']);
        header("location:/sales/view/$id");
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ventas
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/sales/">Ventas</a></li>
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
                        <h3 class="box-title"><strong>Detalle de la Venta</strong></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Fecha de venta</th>
                                    <td><?php echo $sales['fecha_venta'] ?></td>
                                </tr>
                                <tr>
                                    <th>Total venta</th>
                                    <td><?php echo number_format($sales['valor_venta'], 2, ',', '.'); ?></td>           
                                </tr>                               
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Productos en esta venta</h3>
                            </div>
                        </div>
                        <table id="list_sales" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Valor Venta</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while ($row = $sales_detail->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>                                
                                        <th scope="row">  <?php echo $i ?></th>
                                        <td><?php echo $row['articulo'] ?></td>
                                        <td><?php echo $row['laboratorio'] ?></td>
                                        <td><?php echo $row['presentacion'] ?></td>
                                        <td><?php echo $row['cantidad'] ?></td>
                                        <td><p><?php echo number_format($row['valor_vendido'], 2, ',', '.'); ?></p></td>
                                        <td>
                                            <form action="" method="post" id="delete_<?php echo $row['venta_detalle_id'] ?>" style="display:inline-block">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['venta_detalle_id'] ?>" />
                                                <a class='btn btn-xs btn-warning' onClick='swal({
                                                            title: "¿Está seguro de eliminar esta venta?",
                                                            text: "¡No podrá recuperar estos datos de registro!",
                                                            type: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#ff0000",
                                                            confirmButtonText: "¡Sí!",
                                                            cancelButtonText: "No",
                                                            closeOnConfirm: false, },
                                                                function () {
                                                                    var form = document.getElementById("delete_<?php echo $row['venta_detalle_id'] ?>");
                                                                    form.submit();
                                                                }
                                                        );
                                                   '><i class='fa fa-trash'></i>
                                                </a>
                                                <?php $i++; ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Valor Venta</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
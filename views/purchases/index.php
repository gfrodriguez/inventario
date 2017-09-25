<?php
$query = "SELECT presentacion.nombre as presentacion, laboratorio.nombre as laboratorio, articulo.nombre as articulo, fecha_vencimiento, cantidad, valor_unitario, articulo.valor_venta, compra.id as id FROM articulo, laboratorio, presentacion, compra WHERE laboratorio_id=laboratorio.id AND presentacion_id=presentacion.id AND articulo.id=compra.articulo_id;";
$purchases = $db->query($query) or die($db->error . __LINE__);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $delete = $db->prepare("DELETE FROM compra WHERE id = ?;");
        $delete->execute(array($id));
        //$query = "DELETE FROM compra WHERE id = $id;";
        //$delete = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' eliminó una compra', $_SESSION['userid']);
        unset($_POST['delete_id']);
        header("location:/purchases/");
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Compras
            <small>Listar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Compras</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <a class="btn btn-primary" href="create/">Registrar Compras</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><strong>Lista de Compras</strong></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_purchases" class="table table-striped table-bordered dt-responsive nowrap"  width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Fecha vencimiento</th>
                                    <th>Cantidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Valor Venta</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while ($row = $purchases->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>                                
                                        <th scope="row"><?php echo $i ?></th>
                                        <td><?php echo $row['articulo'] ?></td>
                                        <td><?php echo $row['laboratorio'] ?></td>
                                        <td><?php echo $row['presentacion'] ?></td>
                                        <td><?php echo $row['fecha_vencimiento'] ?></td>
                                        <td><?php echo $row['cantidad'] ?></td>
                                        <td><p><?php echo number_format($row['valor_unitario'], 2, ',', '.'); ?></p></td>
                                        <td><p><?php echo number_format($row['valor_unitario'], 2, ',', '.'); ?></p></td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="edit/<?php echo $row['id'] ?>"><span class="fa fa-pencil"></span></a>
                                            <a class="btn btn-xs btn-success" href="view/<?php echo $row['id'] ?>"><span class="fa fa-eye"></span></a>
                                            <form action="" method="post" id="delete_<?php echo $row['id'] ?>" style="display:inline-block">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>" />
                                                <a class='btn btn-xs btn-warning' onClick='swal({
                                                            title: "¿Está seguro de eliminar esta compra?",
                                                            text: "¡No podrá recuperar estos datos de registro!",
                                                            type: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#ff0000",
                                                            confirmButtonText: "¡Sí!",
                                                            cancelButtonText: "No",
                                                            closeOnConfirm: false, },
                                                                function () {
                                                                    var form = document.getElementById("delete_<?php echo $row['id'] ?>");
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
                                    <th>Fecha vencimiento</th>
                                    <th>Cantidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Valor Venta</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
$error = "";
$query = "SELECT venta.id as id, fecha_venta FROM venta WHERE 1";
$sales = $db->query($query) or die($db->error . __LINE__);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $query = "SELECT COUNT(*) as total FROM venta_detalle WHERE venta_id=$id;";
        $foreignkeys = $db->query($query) or die($db->error . __LINE__);
        $foreignkeys = $foreignkeys->fetch(PDO::FETCH_ASSOC);
        if ($foreignkeys['total'] == 0) {
            $query = "DELETE FROM venta WHERE id = $id;";
            $delete = $db->query($query) or die($db->error . __LINE__);
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' eliminó una presentación', $_SESSION['userid']);
            header("location:/sales/");
        } else {
            $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Esa venta esta relacionado con al menos un artículo vendido, no se puede eliminar.</div>';
        }
        unset($_POST['delete_id']);
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ventas
            <small>Listar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Ventas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <a class="btn btn-primary" href="create/">Registrar Ventas</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <?php echo $error; ?>
                    <div class="box-header">
                        <h3 class="box-title"><strong>Lista de Ventas</strong></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_sales" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de Venta</th>
                                    <th>Valor venta</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $sales->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>                                
                                        <th scope="row">  <?php echo $i ?></th>
                                        <td><?php echo $row['fecha_venta'] ?></td>
                                        <td><?php
                                            $venta_id = $row['id'];
                                            $query = "SELECT sum(cantidad*articulo.valor_venta) as total_venta FROM venta_detalle, articulo, venta WHERE venta_detalle.articulo_id=articulo.id and venta.id=venta_detalle.venta_id and venta.id='$venta_id';";
                                            $total_venta = $db->query($query) or die($db->error . __LINE__);
                                            $total_venta = $total_venta->fetch(PDO::FETCH_ASSOC);
                                            $total_venta = $total_venta['total_venta'];
                                            echo number_format($total_venta, 2, ',', '.');
                                            ?> 
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-success" href="view/<?php echo $row['id'] ?>"><span class="fa fa-eye"></span></a>
                                            <form action="" method="post" id="delete_<?php echo $row['id'] ?>" style="display:inline-block">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>" />
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
                                    <th>Fecha de Venta</th>
                                    <th>Valor venta</th>
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
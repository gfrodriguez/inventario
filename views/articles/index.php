<?php
$error = "";
$query = "SELECT presentacion.nombre as presentacion, laboratorio.nombre as laboratorio, articulo.id as id, articulo.nombre, articulo.laboratorio_id, articulo.presentacion_id, articulo.stock, articulo.stock_minimo, articulo.valor_venta FROM articulo, laboratorio, presentacion WHERE laboratorio_id=laboratorio.id AND presentacion_id=presentacion.id ORDER BY stock-stock_minimo ASC;";
$articles = $db->query($query) or die($db->error . __LINE__);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $query = "SELECT COUNT(*) as total FROM venta, compra WHERE compra.articulo_id=$id or venta.articulo_id=$id;";
        $foreignkeys = $db->query($query) or die($db->error . __LINE__);
        $foreignkeys = $foreignkeys->fetch(PDO::FETCH_ASSOC);
        if ($foreignkeys['total'] == 0) {
            $query = "DELETE FROM articulo WHERE id = $id;";
            $delete = $db->query($query) or die($db->error . __LINE__);
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' eliminó un artículo', $_SESSION['userid']);
            unset($_POST['delete_id']);
            header("location:/articles/");
        } else {
            $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Ese artículo ya ha sido comprado o vendido, no puede ser eliminado.</div>';
        }
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Productos
            <small>Listar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Productos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <a class="btn btn-primary" href="create/">Registrar Productos</a>
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
                        <h3 class="box-title"><strong>Lista de Productos</strong></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_sales" class="table table-striped table-bordered dt-responsive nowrap"  width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Laboratorio</th>                                    
                                    <th>Presentación</th>
                                    <th>Precio de Venta</th>
                                    <th>Stock</th>
                                    <th>Stock mínimo</th>       
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $articles->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr <?php
                                    if ($row['stock'] < $row['stock_minimo']) {
                                        echo 'style="background:#F78181"';
                                    } else if ($row['stock'] == $row['stock_minimo']) {
                                        echo 'style="background:#F3E2A9"';
                                    }
                                    ?>>                                
                                        <th scope="row"><?php echo $i ?></th>
                                        <td><?php echo $row['nombre'] ?></td>
                                        <td><?php echo $row['laboratorio'] ?></td>
                                        <td><?php echo $row['presentacion'] ?></td>
                                        <td><p><?php echo number_format($row['valor_venta'], 2, ',', '.'); ?></p></td>
                                        <td><?php echo $row['stock'] ?></td>
                                        <td><?php echo $row['stock_minimo'] ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="edit/<?php echo $row['id'] ?>"><span class="fa fa-pencil"></span></a>
                                            <a class="btn btn-xs btn-success" href="view/<?php echo $row['id'] ?>"><span class="fa fa-eye"></span></a>
                                            <form action="" method="post" id="delete_<?php echo $row['id'] ?>" style="display:inline-block">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>" />
                                                <a class='btn btn-xs btn-warning' onClick='swal({
                                                            title: "¿Está seguro de eliminar este artículo?",
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
                                    <th>Precio de Venta</th>
                                    <th>Stock</th>
                                    <th>Stock mínimo</th>    
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
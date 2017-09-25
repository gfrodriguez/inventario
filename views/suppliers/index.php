<?php
$error="";
$query = "SELECT id, nombre, nit, direccion, telefono, email
                FROM proveedor";
$suppliers = $db->query($query) or die($db->error . __LINE__);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $query = "SELECT COUNT(*) as total FROM factura WHERE proveedor_id=$id";
        $foreignkeys = $db->query($query) or die($db->error . __LINE__);
        $foreignkeys = $foreignkeys->fetch(PDO::FETCH_ASSOC);
        if ($foreignkeys['total'] == 0) {
            $query = "DELETE FROM proveedor WHERE id = $id;";
            $delete = $db->query($query) or die($db->error . __LINE__);
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' eliminó un proveedor', $_SESSION['userid']);
            unset($_POST['delete_id']);
            header("location:index.php");
        } else {
            $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Ese proveedor tiene facturas relacionadas, no puede ser eliminado.</div>';
        }
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Proveedores
            <small>Listar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <a class="btn btn-primary" href="create/">Registrar Proveedores</a>
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
                        <h3 class="box-title"><strong>Lista de proveedores</strong></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_suppliers" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Proveedor</th>
                                    <th>NIT</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo electrónico</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while ($row = $suppliers->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>                                
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['nombre'] ?></td>
                                        <td><?php echo $row['nit'] ?></td>
                                        <td><?php echo $row['direccion'] ?></td>
                                        <td><?php echo $row['telefono'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="edit/<?php echo $row['id'] ?>"><span class="fa fa-pencil"></span></a>
                                            <a class="btn btn-xs btn-success" href="view/<?php echo $row['id'] ?>"><span class="fa fa-eye"></span></a>
                                            <form action="" method="post" id="delete_<?php echo $row['id'] ?>" style="display:inline-block">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>" />
                                                <a class='btn btn-xs btn-warning' onClick='swal({
                                                            title: "¿Está seguro de eliminar este proveedor?",
                                                            text: "¡No podrás recuperar estos datos de registro!",
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
                                    <th>Proveedor</th>
                                    <th>NIT</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo electrónico</th>
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

<?php
$error = "<hr>";
$query = "SELECT * FROM proveedor where id='$id';";
$proveedor = $db->query($query) or die($db->error . __LINE__);
$proveedor = $proveedor->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_proveedor = str_replace("'", "&#39;",strip_tags($_POST['nombre']));
    $nit_proveedor = str_replace("'", "&#39;",strip_tags($_POST['nit']));
    $direccion_proveedor = str_replace("'", "&#39;",strip_tags($_POST['direccion']));
    $telefono_proveedor = str_replace("'", "&#39;",strip_tags($_POST['telefono']));
    $email_proveedor = str_replace("'", "&#39;",strip_tags($_POST['email']));
    $query = "SELECT count(*) as total FROM proveedor where id='$id';";
    $total = $db->query($query) or die($db->error . __LINE__);
    $total = $total->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    if ($total == 1) {
        $query = "UPDATE proveedor SET nombre='$nombre_proveedor',nit='$nit_proveedor',direccion='$direccion_proveedor',telefono='$telefono_proveedor',email='$email_proveedor' WHERE id=$id;";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' editó un proveedor', $_SESSION['userid']);
        header("location:/suppliers/");
    } else {
        $error = '<div class="alert alert-danger alert-dismissable">
              <strong>¡Atención!</strong> Ese proveedor ya esta registrado</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Proveedores
            <small>Editar</small>
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
                        <h3 class="box-title"><strong>Editar Proveedor</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Nombre</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del proveedor" value="<?php echo $proveedor['nombre'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nit" class="control-label">Nit</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nit" name="nit" placeholder="Nit del proveedor" value="<?php echo $proveedor['nit'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="direccion" class="control-label">Dirección</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del proveedor" value="<?php echo $proveedor['direccion'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="telefono" class="control-label">Teléfono</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $proveedor['telefono'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="email" class="control-label">Correo Electrónico</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $proveedor['email'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
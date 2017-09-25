<?php
$error="<hr>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_proveedor = str_replace("'", "&#39;",strip_tags($_POST['nombre']));
    $nit_proveedor = str_replace("'", "&#39;",strip_tags($_POST['nit']));
    $direccion_proveedor = str_replace("'", "&#39;",strip_tags($_POST['direccion']));
    $telefono_proveedor = str_replace("'", "&#39;",strip_tags($_POST['telefono']));
    $email_proveedor = str_replace("'", "&#39;",strip_tags($_POST['email']));
    
    $query = "SELECT count(*) as total FROM proveedor where nit='$nit_proveedor' OR nombre='$nombre_proveedor';";
    
    $total = $db->query($query) or die($db->error . __LINE__);
    
    $total = $total->fetch(PDO::FETCH_ASSOC);
    
    $total = $total['total'];
    
    if($total==0){
    
    $query = "INSERT INTO proveedor (nombre,nit,direccion,telefono,email)
                             VALUES ('$nombre_proveedor','$nit_proveedor','$direccion_proveedor','$telefono_proveedor','$email_proveedor');";
    $insert_row = $db->query($query) or die($db->error . __LINE__);
    auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' creó un proveedor', $_SESSION['userid']);
    header("location:/suppliers/");
    }else{
        $error='<div class="alert alert-danger alert-dismissable">
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
            <small>Crear</small>
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
                <?php echo $error;?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Registrar Proveedor</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Nombre</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del proveedor" required value="<?php
                                    if (isset($_POST['nombre']) != "") {
                                        echo $_POST['nombre'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nit" class="control-label">Nit</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nit" name="nit" placeholder="Nit del proveedor" required value="<?php
                                    if (isset($_POST['nit']) != "") {
                                        echo $_POST['nit'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="direccion" class="control-label">Dirección</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del proveedor" required value="<?php
                                    if (isset($_POST['direccion']) != "") {
                                        echo $_POST['direccion'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="telefono" class="control-label">Teléfono</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required value="<?php
                                    if (isset($_POST['telefono']) != "") {
                                        echo $_POST['telefono'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="email" class="control-label">Correo Electrónico</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php
                                    if (isset($_POST['email']) != "") {
                                        echo $_POST['email'];
                                    }
                                    ?>">
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
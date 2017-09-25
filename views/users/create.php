<?php
$error = "<hr>";

$query = "SELECT id as rol_id, nombre as rol_nombre FROM rol where 1";
$rol = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol_id = $_POST['rol_id'];
    $user_password = $_POST['password'];
    $user_password = password_hash($user_password, PASSWORD_BCRYPT);
    $user_nombres = $_POST['nombres'];
    $user_apellidos = $_POST['apellidos'];
    $user_email = $_POST['email'];
    $user_username = $_POST['username'];
    $user_created_at = "NOW()";
    $query = "SELECT count(*) as total FROM user where username='$user_username';";
    $total = $db->query($query) or die($db->error . __LINE__);
    $total = $total->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    if ($total == 0) {
        $query = "INSERT INTO user (nombres,apellidos,username,email,rol_id,created_at,password)
                             VALUES ('$user_nombres','$user_apellidos','$user_username','$user_email','$rol_id',$user_created_at,'$user_password');";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' creó un usuario', $_SESSION['userid']);
        header("location:/users/");
    } else {
        $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Ese usuario ya se encuentra registrado.</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Facturas
            <small>Crear</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/users/">Usuarios</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $error; ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Registrar Usuario</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="user_nombre" class="control-label">Nombres</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres del Usuario" required value="<?php
                                    if (isset($_POST['nombres']) != "") {
                                        echo $_POST['nombres'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="user_apellidos" class="control-label">Apellidos</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos del Usuario" required value="<?php
                                    if (isset($_POST['apellidos']) != "") {
                                        echo $_POST['apellidos'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="user_username" class="control-label">Username</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required value="<?php
                                    if (isset($_POST['username']) != "") {
                                        echo $_POST['username'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="user_password" class="control-label">Contraseña</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="email" name="password" placeholder="Contraseña" required value="<?php
                                    if (isset($_POST['password']) != "") {
                                        echo $_POST['password'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="user_email" class="control-label">Email</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required value="<?php
                                    if (isset($_POST['email']) != "") {
                                        echo $_POST['email'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="rol_id" class="control-label">Rol</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='rol_id' class='form-control select2' required>
                                        <option name='rol_id' value=''>Seleccione un rol</option>
                                        <?php while ($rol_item = $rol->fetch(PDO::FETCH_ASSOC)): { ?>
                                                <option name='rol_id' value='<?php echo $rol_item["rol_id"]; ?>'>
                                                    <?php echo $rol_item["rol_nombre"] ?>
                                                </option>   
                                                <?php
                                            }
                                        endwhile;
                                        ?>
                                    </select>
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

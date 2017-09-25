<?php
ob_start();
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] == "") {
    $_SESSION['rol'] = "Sin registrar";
}else if($_SESSION['rol'] == "Sin registrar"){
include('../db/db.php');
function auditoria($ipaddress, $a_url, $a_descrition, $a_user_id) {
        include('../db/db.php');
        $created_at = "NOW()";
        $userbrowser = $_SERVER['HTTP_USER_AGENT'];
        $query = "INSERT INTO auditoria (created_at,ipaddress,userbrowser,url,description,user_id)
                             VALUES ($created_at,'$ipaddress','$userbrowser','$a_url','$a_descrition','$a_user_id');";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
    }
$errorlogin = "";

if (isset($_COOKIE['id']) && isset($_COOKIE['marca'])) {
    if ($_COOKIE['id'] != "" || $_COOKIE['marca'] != "") {
        $query = "SELECT rol.nombre as rol, user.username, user.password FROM user, rol
					WHERE id='" . $_COOKIE["id"] . "'
					AND cookie='" . $_COOKIE["marca"] . "'
					AND cookie<>'';";

        $row = $db->query($query) or die($db->error . __LINE__);
        $row = $row->fetch(PDO::FETCH_ASSOC);
        $username = $row['username'];
        $password = $row['password'];
        $rol = $row['rol'];
        $_SESSION['login_user'] = $username;
        $_SESSION['loggedin'] = true;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
        $_SESSION['rol'] = $rol;
        $_SESSION['userid'] = $userid;
        header("location: /");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    if (!isset($_POST['rememberme'])) {
        $_POST['rememberme'] = false;
    }
    // If result matched $myusername and $mypassword, table row must be 1 row

    $query = "SELECT count(*) as total FROM user WHERE username = '$username'";
    $results = $db->query($query) or die($db->error . __LINE__);
    $results = $results->fetch(PDO::FETCH_ASSOC);
    $results = $results['total'];

    $count = $results;

    if ($count == 1) {

        $query = "SELECT * FROM user
          WHERE username = '$username'";
        $result = $db->query($query) or die($db->error . __LINE__);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $passHash = $row['password'];

        if (password_verify($password, $passHash)) {

            $query = "SELECT * FROM user
            WHERE username = '$username'";
            $result = $db->query($query) or die($db->error . __LINE__);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $rol = $row['rol_id'];
            $userid = $row['id'];

            $_SESSION['login_user'] = $username;
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
            $_SESSION['rol'] = $rol;
            $_SESSION['userid'] = $userid;

            if ($_POST['rememberme'] == true) {
                mt_srand(time());
                $rand = mt_rand(1000000, 9999999);
                $query = "UPDATE user
				SET cookie='$rand' WHERE id='$userid'";
                $result = $db->query($query) or die($db->error . __LINE__);
                setcookie("id", $userid, time() + (60 * 60 * 24 * 365));
                setcookie("marca", $rand, time() + (60 * 60 * 24 * 365));
            }
            auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$username.' inició sesión', $userid);
            header("location:/");
        } else {
            $errorlogin = "Su contraseña es incorrecta";
        }
    } else {
        $errorlogin = "Su usuario no esta registrado";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Droguería Somos Salud</title>
        <meta name="charset" content="UTF-8">
        <meta name="description" content="Sistema de informaciónn para la Droguería Somos Salud">
        <meta name="keywords" content="CRUD, Sistema, Información">
        <meta name="copyright" content="Copyright © 2017 gfrodriguez.online">
        <meta name="author" content="gfrodriguez">
        <meta name="designer" content="gfrodriguez">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="content-language" content="ES">
        <meta name="Rating" content="General">
        <meta name="Distribution" content="Global">
        <link rel="icon" type="image/x-icon" href="/assets/images/favicon.png">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.png">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="/assets/plugins/select2/select2.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/assets/plugins/iCheck/square/blue.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page" style="height: auto;">
        <div class="login-box">
            <div class="login-logo">
                <a href="/"><b>Somos</b> Salud</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Para entrar ingrese su usuario y contraseña</p>
                <?php if ($errorlogin !== "") { ?>
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <h4>¡Atención!</h4>
                        <p><?php echo $errorlogin; ?></p>
                    </div>
                <?php } ?>

                <form action="login" method="post" role="form">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" placeholder="Usuario" value="<?php
                        if (isset($_POST['username']) != "") {
                            echo $_POST['username'];
                        }
                        ?>" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="rememberme"> Recordarme
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="/assets/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
<?php }else if ($_SESSION['rol'] != "Sin registrar") {
  header('location:/');
}?>

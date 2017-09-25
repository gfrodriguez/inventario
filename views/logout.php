<?php
session_start();
auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' cerró sesión', $_SESSION['userid']);
unset($_SESSION['login_user']);
unset($_SESSION['loggedin']);
unset($_SESSION['start']);
unset($_SESSION['expire']);
unset($_SESSION['rol']);
unset($_COOKIE['id']);
unset($_COOKIE['marca']);
unset($_SESSION);
unset($_COOKIE);
session_unset();
session_destroy();
session_regenerate_id(true);
setcookie("id", "", time() + (60 * 60 * 24 * 365));
setcookie("marca", "", time() + (60 * 60 * 24 * 365));
ob_start();
session_start();
$_SESSION['rol'] = "Sin registrar";
header('Location: /login');
?>

<?php

if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = "Sin registrar";
}
if (!isset($_SESSION['login_user'])) {
    header("location:views/login");
} else {
    include('db/db.php');

    $user_check = $_SESSION['login_user'];

    $query = "select username, id, rol from users where username = '$user_check'";

    $result = $db->query($query) or die($db->error . __LINE__);

    $row = $result->fetch(PDO::FETCH_ASSOC);

    $login_session = $row['username'];

    //$query = "SELECT * FROM users
    // WHERE username = '$user_check'";
    //$result = $db->query($query) or die($db->error . __LINE__);
    //$row = $result->fetch(PDO::FETCH_ASSOC);
    $users_rol = $row['id'];
    $_SESSION['rol'] = $row['rol'];
}
?>
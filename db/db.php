<?php
$url = $_SERVER['REQUEST_URI'];
if (stripos($url, "db.php")) {
    header("location:/");
} else {
    $_user = 'user';
    $_pass = 'pass';
    $e = "";
    try {
        $db = new PDO('mysql:host=localhost;dbname=drogueria', $_user, $_pass);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $utf8 = $db->query("SET NAMES 'utf8'");
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
?>

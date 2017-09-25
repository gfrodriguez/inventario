<?php

$url = $_SERVER['REQUEST_URI'];
if (stripos($url, "functions.php")) {
    header("location:/");
} else {

    function format_number($number) {
        $number = str_replace(".", "", $number);
        $number = str_replace(",", ".", $number);
        return $number;
    }

    function auditoria($ipaddress, $a_url, $a_descrition, $a_user_id) {
        include('db/db.php');
        $created_at = "NOW()";
        $userbrowser = $_SERVER['HTTP_USER_AGENT'];
        $query = "INSERT INTO auditoria (created_at,ipaddress,userbrowser,url,description,user_id)
                             VALUES ($created_at,'$ipaddress','$userbrowser','$a_url','$a_descrition','$a_user_id');";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
    }
    
    $nombre_pagina="Droguería Somos Salud";
    $logo_mini = "<b>D</b>SS";
    $logo_lg = "<b>Droguería</b> Somos Salud";
    $version = "2.0";
}
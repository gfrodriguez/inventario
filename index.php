<?php

ob_start();
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] == "" || $_SESSION['rol'] == "Sin registrar") {
    $_SESSION['rol'] = "Sin registrar";
    header('location:/login');
}

if ($_SESSION['rol'] == "1") {
    include 'functions/functions.php';
    include 'views/layouts/header.php';
    $url = $_SERVER['REQUEST_URI'];
    if ($url == "/") {
        include 'views/dashboard.php';
    } else if (stripos($url, "bills/create")) {
        include('views/bills/create.php');
    } else if (stripos($url, "bills/edit")) {
        $id = substr($url, 12);
        require 'views/bills/edit.php';
    } else if (stripos($url, "bills/view")) {
        $id = substr($url, 12);
        require 'views/bills/view.php';
    } else if (stripos($url, "bills")) {
        include('views/bills/index.php');
    } else if (stripos($url, "articles/create")) {
        include('views/articles/create.php');
    } else if (stripos($url, "articles/edit")) {
        $id = substr($url, 15);
        require 'views/articles/edit.php';
    } else if (stripos($url, "articles/view")) {
        $id = substr($url, 15);
        require 'views/articles/view.php';
    } else if (stripos($url, "articles")) {
        include('views/articles/index.php');
    } else if (stripos($url, "laboratories/create")) {
        include('views/laboratories/create.php');
    } else if (stripos($url, "laboratories/edit")) {
        $id = substr($url, 19);
        require 'views/laboratories/edit.php';
    } else if (stripos($url, "laboratories/view")) {
        $id = substr($url, 19);
        require 'views/laboratories/view.php';
    } else if (stripos($url, "laboratories")) {
        include('views/laboratories/index.php');
    } else if (stripos($url, "presentations/create")) {
        include('views/presentations/create.php');
    } else if (stripos($url, "presentations/edit")) {
        $id = substr($url, 20);
        require 'views/presentations/edit.php';
    } else if (stripos($url, "presentations/view")) {
        $id = substr($url, 20);
        require 'views/presentations/view.php';
    } else if (stripos($url, "presentations")) {
        include('views/presentations/index.php');
    } else if (stripos($url, "purchases/create")) {
        include('views/purchases/create.php');
    } else if (stripos($url, "purchases/edit")) {
        $id = substr($url, 16);
        require 'views/purchases/edit.php';
    } else if (stripos($url, "purchases/view")) {
        $id = substr($url, 16);
        require 'views/purchases/view.php';
    } else if (stripos($url, "purchases")) {
        include('views/purchases/index.php');
    } else if (stripos($url, "sales/create")) {
        include('views/sales/create.php');
    } else if (stripos($url, "sales/edit")) {
        $id = substr($url, 12);
        require 'views/sales/edit.php';
    } else if (stripos($url, "sales/view")) {
        $id = substr($url, 12);
        require 'views/sales/view.php';
    } else if (stripos($url, "sales")) {
        include('views/sales/index.php');
    } else if (stripos($url, "suppliers/create")) {
        include('views/suppliers/create.php');
    } else if (stripos($url, "suppliers/edit")) {
        $id = substr($url, 16);
        require 'views/suppliers/edit.php';
    } else if (stripos($url, "suppliers/view")) {
        $id = substr($url, 16);
        require 'views/suppliers/view.php';
    } else if (stripos($url, "suppliers")) {
        include('views/suppliers/index.php');
    } else if (stripos($url, "users/create")) {
        include('views/users/create.php');
    } else if (stripos($url, "users/edit")) {
        $id = substr($url, 12);
        require 'views/users/edit.php';
    } else if (stripos($url, "users/view")) {
        $id = substr($url, 12);
        require 'views/users/view.php';
    } else if (stripos($url, "users")) {
        include('views/users/index.php');
    } else if (stripos($url, "audit/view")) {
        $id = substr($url, 12);
        include('views/audit/view.php');
    } else if (stripos($url, "audit")) {
        include('views/audit/index.php');
    } else if ($url == "/logout") {
        include('views/logout.php');
    } else if (stripos($url, "login")) {
        include('views/dashboard.php');
    }
    include 'views/layouts/footer.php';
} else if ($_SESSION['rol'] == "2") {
    include 'functions/functions.php';
    include 'views/layouts/header.php';
    $url = $_SERVER['REQUEST_URI'];
    if ($url == "/") {
        include 'views/dashboard.php';
    } else if (stripos($url, "bills/create")) {
        include('views/bills/create.php');
    } else if (stripos($url, "bills/edit")) {
        $id = substr($url, 12);
        require 'views/bills/edit.php';
    } else if (stripos($url, "bills/view")) {
        $id = substr($url, 12);
        require 'views/bills/view.php';
    } else if (stripos($url, "bills")) {
        include('views/bills/index.php');
    } else if (stripos($url, "articles/create")) {
        include('views/articles/create.php');
    } else if (stripos($url, "articles/edit")) {
        $id = substr($url, 15);
        require 'views/articles/edit.php';
    } else if (stripos($url, "articles/view")) {
        $id = substr($url, 15);
        require 'views/articles/view.php';
    } else if (stripos($url, "articles")) {
        include('views/articles/index.php');
    } else if (stripos($url, "laboratories/create")) {
        include('views/laboratories/create.php');
    } else if (stripos($url, "laboratories/edit")) {
        $id = substr($url, 19);
        require 'views/laboratories/edit.php';
    } else if (stripos($url, "laboratories/view")) {
        $id = substr($url, 19);
        require 'views/laboratories/view.php';
    } else if (stripos($url, "laboratories")) {
        include('views/laboratories/index.php');
    } else if (stripos($url, "presentations/create")) {
        include('views/presentations/create.php');
    } else if (stripos($url, "presentations/edit")) {
        $id = substr($url, 20);
        require 'views/presentations/edit.php';
    } else if (stripos($url, "presentations/view")) {
        $id = substr($url, 20);
        require 'views/presentations/view.php';
    } else if (stripos($url, "presentations")) {
        include('views/presentations/index.php');
    } else if (stripos($url, "purchases/create")) {
        include('views/purchases/create.php');
    } else if (stripos($url, "purchases/edit")) {
        $id = substr($url, 16);
        require 'views/purchases/edit.php';
    } else if (stripos($url, "purchases/view")) {
        $id = substr($url, 16);
        require 'views/purchases/view.php';
    } else if (stripos($url, "purchases")) {
        include('views/purchases/index.php');
    } else if (stripos($url, "sales/create")) {
        include('views/sales/create.php');
    } else if (stripos($url, "sales/edit")) {
        $id = substr($url, 12);
        require 'views/sales/edit.php';
    } else if (stripos($url, "sales/view")) {
        $id = substr($url, 12);
        require 'views/sales/view.php';
    } else if (stripos($url, "sales")) {
        include('views/sales/index.php');
    } else if (stripos($url, "suppliers/create")) {
        include('views/suppliers/create.php');
    } else if (stripos($url, "suppliers/edit")) {
        $id = substr($url, 16);
        require 'views/suppliers/edit.php';
    } else if (stripos($url, "suppliers/view")) {
        $id = substr($url, 16);
        require 'views/suppliers/view.php';
    } else if (stripos($url, "suppliers")) {
        include('views/suppliers/index.php');
    } else if (stripos($url, "users/create")) {
        include('views/users/create.php');
    } else if (stripos($url, "users/edit")) {
        $id = substr($url, 12);
        require 'views/users/edit.php';
    } else if (stripos($url, "users/view")) {
        $id = substr($url, 12);
        require 'views/users/view.php';
    } else if (stripos($url, "users")) {
        include('views/users/index.php');
    } else if (stripos($url, "audit/view")) {
        $id = substr($url, 12);
        include('views/audit/view.php');
    } else if (stripos($url, "audit")) {
        include('views/audit/index.php');
    } else if ($url == "/logout") {
        include('views/logout.php');
    } else if (stripos($url, "login")) {
        include('views/dashboard.php');
    }
    include 'views/layouts/footer.php';
} else if ($_SESSION['rol'] == "3") {
    include 'functions/functions.php';
    include 'views/layouts/header.php';
    $url = $_SERVER['REQUEST_URI'];
    if ($url == "/") {
        include 'views/dashboard.php';
    } else if (stripos($url, "bills/create")) {
        include('views/bills/create.php');
    } else if (stripos($url, "bills/edit")) {
        $id = substr($url, 12);
        require 'views/bills/edit.php';
    } else if (stripos($url, "bills/view")) {
        $id = substr($url, 12);
        require 'views/bills/view.php';
    } else if (stripos($url, "bills")) {
        include('views/bills/index.php');
    } else if (stripos($url, "articles/create")) {
        include('views/articles/create.php');
    } else if (stripos($url, "articles/edit")) {
        $id = substr($url, 15);
        require 'views/articles/edit.php';
    } else if (stripos($url, "articles/view")) {
        $id = substr($url, 15);
        require 'views/articles/view.php';
    } else if (stripos($url, "articles")) {
        include('views/articles/index.php');
    } else if (stripos($url, "laboratories/create")) {
        include('views/laboratories/create.php');
    } else if (stripos($url, "laboratories/edit")) {
        $id = substr($url, 19);
        require 'views/laboratories/edit.php';
    } else if (stripos($url, "laboratories/view")) {
        $id = substr($url, 19);
        require 'views/laboratories/view.php';
    } else if (stripos($url, "laboratories")) {
        include('views/laboratories/index.php');
    } else if (stripos($url, "presentations/create")) {
        include('views/presentations/create.php');
    } else if (stripos($url, "presentations/edit")) {
        $id = substr($url, 20);
        require 'views/presentations/edit.php';
    } else if (stripos($url, "presentations/view")) {
        $id = substr($url, 20);
        require 'views/presentations/view.php';
    } else if (stripos($url, "presentations")) {
        include('views/presentations/index.php');
    } else if (stripos($url, "purchases/create")) {
        include('views/purchases/create.php');
    } else if (stripos($url, "purchases/edit")) {
        $id = substr($url, 16);
        require 'views/purchases/edit.php';
    } else if (stripos($url, "purchases/view")) {
        $id = substr($url, 16);
        require 'views/purchases/view.php';
    } else if (stripos($url, "purchases")) {
        include('views/purchases/index.php');
    } else if (stripos($url, "sales/create")) {
        include('views/sales/create.php');
    } else if (stripos($url, "sales/edit")) {
        $id = substr($url, 12);
        require 'views/sales/edit.php';
    } else if (stripos($url, "sales/view")) {
        $id = substr($url, 12);
        require 'views/sales/view.php';
    } else if (stripos($url, "sales")) {
        include('views/sales/index.php');
    } else if (stripos($url, "suppliers/create")) {
        include('views/suppliers/create.php');
    } else if (stripos($url, "suppliers/edit")) {
        $id = substr($url, 16);
        require 'views/suppliers/edit.php';
    } else if (stripos($url, "suppliers/view")) {
        $id = substr($url, 16);
        require 'views/suppliers/view.php';
    } else if (stripos($url, "suppliers")) {
        include('views/suppliers/index.php');
    } else if (stripos($url, "users/view")) {
        $id = substr($url, 12);
        require 'views/users/view.php';
    } else if (stripos($url, "users")) {
        include('views/layouts/withoutauthorization.php');
    } else if (stripos($url, "audit")) {
        include('views/layouts/withoutauthorization.php');
    } else if ($url == "/logout") {
        include('views/logout.php');
    } else if (stripos($url, "login")) {
        include('views/dashboard.php');
    }
    include 'views/layouts/footer.php';
}
ob_end_flush();
?>

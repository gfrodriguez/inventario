<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php
                $nombre = explode(" ", $user['nombres']);
                $apellido = explode(" ", $user['apellidos']);
                echo $nombre[0] . ' ' . $apellido[0];
                ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">Panel de Navegación</li>

        <?php if ($_SESSION['rol'] == "1") { ?>
            <li <?php
            if ($_SERVER['REQUEST_URI'] == "/") {
                echo ' class="active"';
            }
            ?>>
                <a href="/">
                    <i class="fa fa-dashboard"></i><span>Principal</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "suppliers") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/suppliers/">
                    <i class="fa ion-person-stalker"></i><span>Proveedores</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "bills") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/bills/">
                    <i class="fa ion-card"></i><span>Facturas</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "articles") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/articles/">
                    <i class="fa ion-medkit"></i><span>Productos</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "laboratories") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/laboratories/">
                    <i class="fa ion-ios-flask-outline"></i><span>Laboratorios</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "presentations") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/presentations/">
                    <i class="fa ion-pricetags"></i><span>Presentaciones</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "purchases") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/purchases/">
                    <i class="fa ion-ios-cart"></i><span>Compras</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "sales") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/sales/">
                    <i class="fa ion-ios-cart-outline"></i><span>Ventas</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "users") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/users/">
                    <i class="fa ion-person"></i><span>Usuarios</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "audit") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/audit/">
                    <i class="fa ion-flag"></i><span>Auditoria</span>
                </a>
            </li>
        <?php } else if ($_SESSION['rol'] == "2") { ?>
            <li <?php
            if ($_SERVER['REQUEST_URI'] == "/") {
                echo ' class="active"';
            }
            ?>>
                <a href="/">
                    <i class="fa fa-dashboard"></i><span>Principal</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "suppliers") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/suppliers/">
                    <i class="fa ion-person-stalker"></i><span>Proveedores</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "bills") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/bills/">
                    <i class="fa ion-card"></i><span>Facturas</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "articles") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/articles/">
                    <i class="fa ion-medkit"></i><span>Productos</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "laboratories") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/laboratories/">
                    <i class="fa ion-ios-flask-outline"></i><span>Laboratorios</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "presentations") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/presentations/">
                    <i class="fa ion-pricetags"></i><span>Presentaciones</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "purchases") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/purchases/">
                    <i class="fa ion-ios-cart"></i><span>Compras</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "sales") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/sales/">
                    <i class="fa ion-ios-cart-outline"></i><span>Ventas</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "users") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/users/">
                    <i class="fa ion-person"></i><span>Usuarios</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "audit") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/audit/">
                    <i class="fa ion-flag"></i><span>Auditoria</span>
                </a>
            </li>
        <?php } else if ($_SESSION['rol'] == "3") { ?>
            <li <?php
            if ($_SERVER['REQUEST_URI'] == "/") {
                echo ' class="active"';
            }
            ?>>
                <a href="/">
                    <i class="fa fa-dashboard"></i><span>Principal</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "suppliers") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/suppliers/">
                    <i class="fa ion-person-stalker"></i><span>Proveedores</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "bills") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/bills/">
                    <i class="fa ion-card"></i><span>Facturas</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "articles") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/articles/">
                    <i class="fa ion-medkit"></i><span>Productos</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "laboratories") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/laboratories/">
                    <i class="fa ion-ios-flask-outline"></i><span>Laboratorios</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "presentations") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/presentations/">
                    <i class="fa ion-pricetags"></i><span>Presentaciones</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "purchases") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/purchases/">
                    <i class="fa ion-ios-cart"></i><span>Compras</span>
                </a>
            </li>
            <li <?php
            if (stripos($_SERVER['REQUEST_URI'], "sales") !== false) {
                echo ' class="active"';
            }
            ?>>
                <a href="/sales/">
                    <i class="fa ion-ios-cart-outline"></i><span>Ventas</span>
                </a>
            </li>            
        <?php } ?>


    </ul>
</section>
<!-- /.sidebar -->

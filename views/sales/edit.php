<?php
$error = "<hr>";
$query = "SELECT venta.id as venta_id, venta.articulo_id as venta_articulo_id, venta.cantidad as venta_cantidad_edit, venta.fecha_venta as venta_fecha_venta_edit FROM venta where id='$id';";
$venta = $db->query($query) or die($db->error . __LINE__);
$venta = $venta->fetch(PDO::FETCH_ASSOC);
$query = "SELECT articulo.id as articulo_id, articulo.nombre as articulo_nombre, articulo.stock as articulo_stock, articulo.stock_minimo as articulo_stock_minimo, laboratorio.id as laboratorio_id, laboratorio.nombre as laboratorio_nombre, presentacion.id as presentacion_id, presentacion.nombre as presentacion_nombre FROM articulo, presentacion, laboratorio WHERE presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id ORDER BY laboratorio_nombre;";
$articulo = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articulo_id = $_POST['articulo_id'];
    $cantidad = $_POST['venta_cantidad'];
    $venta_articulo_id = $venta['venta_articulo_id'];
    $venta_cantidad_edit = $venta['venta_cantidad_edit'];
    $query = "SELECT stock FROM articulo WHERE id='$articulo_id';";
    $stock = $db->query($query) or die($db->error . __LINE__);
    $stock = $stock->fetch(PDO::FETCH_ASSOC);
    if ($venta_articulo_id == $articulo_id) {
        if ($venta_cantidad_edit+$stock['stock'] >= $cantidad) {
            $query = "UPDATE articulo SET stock=stock-$cantidad+$venta_cantidad_edit WHERE articulo.id=$articulo_id";
            $update_row = $db->query($query) or die($db->error . __LINE__);
            $query = "UPDATE venta SET articulo_id='$articulo_id',cantidad='$cantidad' where id='$id';";
            $update_row = $db->query($query) or die($db->error . __LINE__);
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' editó una venta', $_SESSION['userid']);
            if ($cantidad != $compra_cantidad_edit) {
                auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' cambió el stock de un producto', $_SESSION['userid']);
            }
            header("location:/sales/");
        } else {
            $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Intenta vender cantidades que exceden el Stock actual del producto.</div>';
        }
    } else {
        $query = "SELECT stock FROM articulo WHERE id='$articulo_id';";
        $stock = $db->query($query) or die($db->error . __LINE__);
        $stock = $stock->fetch(PDO::FETCH_ASSOC);
        if ($cantidad <= $stock['stock']) {
            $query = "UPDATE articulo SET stock=stock+$venta_cantidad_edit WHERE articulo.id=$venta_articulo_id";
            $update_row = $db->query($query) or die($db->error . __LINE__);
            $query = "UPDATE articulo SET stock=stock-$cantidad WHERE articulo.id=$articulo_id";
            $update_row = $db->query($query) or die($db->error . __LINE__);
            $query = "UPDATE venta SET articulo_id='$articulo_id',cantidad='$cantidad' where id='$id';";
            $update_row = $db->query($query) or die($db->error . __LINE__);
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' cambió el stock de dos productos', $_SESSION['userid']);
            header("location:/sales/");
        } else {
            $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Intenta vender cantidades que exceden el Stock actual del producto.</div>';
        }
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ventas
            <small>Editar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/sales/">Ventas</a></li>
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
                        <h3 class="box-title"><strong>Registrar Venta</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Producto</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='articulo_id' class='form-control select2' required>
                                        <option name='articulo_id' value=''>Seleccione un producto</option>
                                        <?php
                                        $optgroup = "";
                                        while ($articulo_item = $articulo->fetch(PDO::FETCH_ASSOC)): {
                                                if ($optgroup != $articulo_item["laboratorio_nombre"] . $articulo_item['presentacion_nombre']) {
                                                    echo "<optgroup label='" . $articulo_item['laboratorio_nombre'] . " - " . $articulo_item['presentacion_nombre'] . "'>";
                                                }
                                                ?>
                                                <option name='articulo_id' value='<?php echo $articulo_item["articulo_id"]; ?>'<?php
                                                if ($articulo_item['articulo_id'] == $venta['venta_articulo_id']) {
                                                    echo "selected";
                                                };
                                                ?>><?php echo $articulo_item["articulo_nombre"] . " (Stock " . $articulo_item['articulo_stock'] . " Unidades)" ?></option>;
                                                        <?php
                                                        if ($optgroup != $articulo_item["laboratorio_nombre"] . $articulo_item['presentacion_nombre']) {
                                                            echo "</optgroup>";
                                                        }
                                                        $optgroup = $articulo_item["laboratorio_nombre"] . $articulo_item['presentacion_nombre'];
                                                    }
                                                endwhile;
                                                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="venta_cantidad" class="control-label">Cantidad</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="venta_cantidad" name="venta_cantidad"  value="<?php echo $venta['venta_cantidad_edit']; ?>" placeholder="Cantidad vendida" data-mask-integer required>
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
<?php
$error = "<hr>";
$query = "SELECT articulo.id as articulo_id, articulo.nombre as articulo_nombre, laboratorio.id as laboratorio_id, laboratorio.nombre as laboratorio_nombre, presentacion.id as presentacion_id, presentacion.nombre as presentacion_nombre FROM articulo, presentacion, laboratorio WHERE presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id ORDER BY laboratorio_nombre;";
$articulo = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT factura.id as factura_id, proveedor.nombre as proveedor_nombre, factura.fecha_factura as factura_fecha, factura.numero as factura_numero FROM factura, proveedor where proveedor.id=factura.proveedor_id ORDER BY proveedor_nombre;";
$factura = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['guardar'])) {
        $guardar = 1;
    } else {
        $guardar = 0;
    }
    $articulo_id = $_POST['articulo_id'];
    $factura_id = $_POST['factura_id'];
    $cantidad = $_POST['compra_cantidad'];
    $fecha_vencimiento = $_POST['compra_fecha_vencimiento'];
    $valor_unitario = $_POST['compra_valor_unitario'];
    $valor_unitario = format_number($valor_unitario);

    $query = "INSERT INTO compra (articulo_id,factura_id,cantidad,fecha_vencimiento,valor_unitario)
                             VALUES ('$articulo_id','$factura_id','$cantidad','$fecha_vencimiento','$valor_unitario');";
    auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' creó una compra', $_SESSION['userid']);
    $insert_row = $db->query($query) or die($db->error . __LINE__);
    $query = "UPDATE articulo SET stock=stock+$cantidad WHERE articulo.id=$articulo_id";
    auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' cambió el stock de un artículo', $_SESSION['userid']);
    $update_row = $db->query($query) or die($db->error . __LINE__);
    if ($guardar == 1) {
        header("location:/purchases/create/");
    } elseif ($guardar == 0) {
        header("location:/purchases/");
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Compras
            <small>Crear</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/purchases/">Compras</a></li>
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
                        <h3 class="box-title"><strong>Registrar Compra</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_factura" class="control-label">Factura</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='factura_id' class='form-control select2' required>
                                        <option name='factura_id' value=''>Seleccione una factura</option>
<?php
$optgroup = "";
while ($factura_item = $factura->fetch(PDO::FETCH_ASSOC)): {
        if ($optgroup != $factura_item["proveedor_nombre"]) {
            echo "<optgroup label='" . $factura_item["proveedor_nombre"] . "'>";
        }
        echo "<option name='factura_id' value='" . $factura_item["factura_id"] . "'>" . $factura_item["factura_numero"] . "</option>";
        if ($optgroup != $factura_item["proveedor_nombre"]) {
            echo "</optgroup>";
        }
        $optgroup = $factura_item["proveedor_nombre"];
    }
endwhile;
?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Producto</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='articulo_id' class='form-control select2' required>
                                        <option name='articulo_id' value=''>Seleccione un artículo</option>
<?php
$optgroup = "";
while ($articulo_item = $articulo->fetch(PDO::FETCH_ASSOC)): {
        if ($optgroup != $articulo_item["laboratorio_nombre"] . $articulo_item['presentacion_nombre']) {
            echo "<optgroup label='" . $articulo_item['laboratorio_nombre'] . " - " . $articulo_item['presentacion_nombre'] . "'>";
        }
        echo "<option name='articulo_id' value='" . $articulo_item["articulo_id"] . "'>" . $articulo_item["articulo_nombre"] . "</option>";
        if ($optgroup != $articulo_item["laboratorio_nombre"]) {
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
                                    <label for="compra_cantidad" class="control-label">Cantidad</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_cantidad" name="compra_cantidad" placeholder="Cantidad comprada" data-mask-integer required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_fecha_vencimiento" class="control-label">Fecha de Vencimiento</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_fecha_vencimiento" name="compra_fecha_vencimiento" placeholder="Fecha de Vencimiento" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_valor_unitario" class="control-label">Valor Unitario</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_valor_unitario" name="compra_valor_unitario" placeholder="Valor unitario" data-mask required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="guardar_mas">Añadir otro producto a la compra</button>
                                    <button type="submit" class="btn btn-primary" name="guardar">Finalizar compra</button>
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
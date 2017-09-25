<?php
$error = "<hr>";
$query = "SELECT compra.id as compra_id, compra.articulo_id as compra_articulo_id, compra.factura_id as compra_factura_id, compra.cantidad as compra_cantidad_edit, compra.fecha_vencimiento as compra_fecha_vencimiento_edit, compra.valor_unitario as compra_valor_unitario_edit FROM compra where id='$id';";
$compra = $db->query($query) or die($db->error . __LINE__);
$compra = $compra->fetch(PDO::FETCH_ASSOC);
$query = "SELECT articulo.id as articulo_id, articulo.nombre as articulo_nombre, laboratorio.id as laboratorio_id, laboratorio.nombre as laboratorio_nombre, presentacion.id as presentacion_id, presentacion.nombre as presentacion_nombre FROM articulo, presentacion, laboratorio WHERE presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id ORDER BY laboratorio_nombre;";
$articulo = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT factura.id as factura_id, proveedor.nombre as proveedor_nombre, factura.fecha_factura as factura_fecha, factura.numero as factura_numero FROM factura, proveedor where proveedor.id=factura.proveedor_id ORDER BY proveedor_nombre;";
$factura = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articulo_id = $_POST['articulo_id'];
    $factura_id = $_POST['factura_id'];
    $cantidad = $_POST['compra_cantidad'];
    $fecha_vencimiento = $_POST['compra_fecha_vencimiento'];
    $valor_unitario = $_POST['compra_valor_unitario'];
    $valor_unitario = format_number($valor_unitario);
    $compra_articulo_id = $compra['compra_articulo_id'];
    $compra_cantidad_edit = $compra['compra_cantidad_edit'];

    if ($compra_articulo_id == $articulo_id) {
        $query = "UPDATE articulo SET stock=stock+$cantidad-$compra_cantidad_edit WHERE articulo.id=$articulo_id";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        if ($cantidad != $compra_cantidad_edit) {
            auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' cambió el stock de un artículo', $_SESSION['userid']);
        }
    } else {
        $query = "UPDATE articulo SET stock=stock-$compra_cantidad_edit WHERE articulo.id=$compra_articulo_id";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        $query = "UPDATE articulo SET stock=stock+$cantidad WHERE articulo.id=$articulo_id";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' cambió el stock de dos artículos', $_SESSION['userid']);
    }
    $query = "UPDATE compra SET articulo_id='$articulo_id',factura_id='$factura_id',cantidad='$cantidad',fecha_vencimiento='$fecha_vencimiento',valor_unitario='$valor_unitario' where id='$id';";
    $update_row = $db->query($query) or die($db->error . __LINE__);
    auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' editó una compra', $_SESSION['userid']);

    header("location:/purchases/");
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
                                                ?>
                                                <option name='factura_id' value='<?php echo $factura_item["factura_id"]; ?>'<?php
                                                if ($factura_item['factura_id'] == $compra['compra_factura_id']) {
                                                    echo "selected";
                                                };
                                                ?>><?php echo $factura_item["factura_numero"]; ?></option>";
                                                        <?php
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
                                                ?>
                                                <option name='articulo_id' value='<?php echo $articulo_item["articulo_id"]; ?>'<?php
                                                if ($articulo_item['articulo_id'] == $compra['compra_articulo_id']) {
                                                    echo "selected";
                                                };
                                                ?>><?php echo $articulo_item["articulo_nombre"]; ?></option>";
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
                                    <label for="compra_cantidad" class="control-label">Cantidad</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_cantidad" name="compra_cantidad"  value="<?php echo $compra['compra_cantidad_edit']; ?>" placeholder="Cantidad comprada" data-mask-integer required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_fecha_vencimiento" class="control-label">Fecha de Vencimiento</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_fecha_vencimiento" name="compra_fecha_vencimiento" value="<?php echo $compra['compra_fecha_vencimiento_edit']; ?>" placeholder="Fecha de Vencimiento" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_valor_unitario" class="control-label">Valor Unitario</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compra_valor_unitario" name="compra_valor_unitario" value="<?php echo number_format($compra['compra_valor_unitario_edit'], 2, ',', '.'); ?>" placeholder="Valor unitario" data-mask required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="compra_valor_venta" class="control-label">Valor Unitario</label>
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
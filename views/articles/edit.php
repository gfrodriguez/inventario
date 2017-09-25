<?php
$error = "<hr>";

$query = "SELECT id as laboratorio_id, nombre as laboratorio_nombre FROM laboratorio where 1";
$laboratorio = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT id as presentacion_id, nombre as presentacion_nombre FROM presentacion where 1";
$presentacion = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT id as articulo_id, nombre as articulo_nombre_edit, presentacion_id as presentacion_id_edit, laboratorio_id as laboratorio_id_edit, stock as stock_edit, stock_minimo as stock_minimo_edit, valor_venta FROM articulo WHERE id='$id';";
$articulo = $db->query($query) or die($db->error . __LINE__);
$articulo = $articulo->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $laboratorio_id = $_POST['laboratorio_id'];
    $presentacion_id = $_POST['presentacion_id'];
    $articulo_nombre = str_replace("'", "&#39;",strip_tags($_POST['articulo_nombre']));
    $stock = $_POST['articulo_stock'];
    $stock_minimo = $_POST['articulo_stock_minimo'];
    $articulo_nombre_edit = $articulo['articulo_nombre_edit'];
    $presentacion_id_edit = $articulo['presentacion_id_edit'];
    $laboratorio_id_edit = $articulo['laboratorio_id_edit'];
    $valor_venta = $_POST['articulo_valor_venta'];
    $valor_venta = format_number($valor_venta);

    $query = "SELECT count(*) as total FROM articulo where nombre='$articulo_nombre' AND presentacion_id='$presentacion_id' AND laboratorio_id='$laboratorio_id';";

    $total = $db->query($query) or die($db->error . __LINE__);
    $total = $total->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    
    $query = "SELECT count(*) as total FROM articulo where nombre='$articulo_nombre_edit' AND presentacion_id='$presentacion_id_edit' AND laboratorio_id='$laboratorio_id_edit';";

    $edit= $db->query($query) or die($db->error . __LINE__);
    $edit = $edit->fetch(PDO::FETCH_ASSOC);
    $edit = $edit['total'];

    if ($total == 0) {
        $query = "UPDATE articulo SET nombre='$articulo_nombre',laboratorio_id='$laboratorio_id',presentacion_id='$presentacion_id',stock='$stock',stock_minimo='$stock_minimo', valor_venta='$valor_venta' WHERE id=$id;";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' editó un artículo', $_SESSION['userid']);
        header("location:/articles/");
    }else if ($edit==1) {
        $query = "UPDATE articulo SET nombre='$articulo_nombre',laboratorio_id='$laboratorio_id',presentacion_id='$presentacion_id',stock='$stock',stock_minimo='$stock_minimo', valor_venta='$valor_venta' WHERE id=$id;";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' editó un artículo', $_SESSION['userid']);
        header("location:/articles/");
    } else {
        $error = '<div class="alert alert-warning alert-dismissable">
              <strong>¡Atención!</strong> El artículo ' . $articulo_nombre . ' con esa presentación y laboratorio ya se encuentra registrado, por favor editelo.</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Productos
            <small>Crear</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/articles/">Productos</a></li>
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
                        <h3 class="box-title"><strong>Registrar Producto</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_nombre" class="control-label">Nombre Producto</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_nombre" name="articulo_nombre" placeholder="Nombre del Producto" required value="<?php echo $articulo['articulo_nombre_edit']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="laboratorio_id" class="control-label">Laboratorio</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='laboratorio_id' class='form-control select2' required>
                                        <option name='laboratorio_id' value=''>Seleccione un Laboratorio</option>
                                        <?php while ($laboratorio_item = $laboratorio->fetch(PDO::FETCH_ASSOC)): { ?>
                                                <option name='laboratorio_id' value='<?php echo $laboratorio_item["laboratorio_id"]; ?>' <?php
                                        if ($laboratorio_item['laboratorio_id'] == $articulo['laboratorio_id_edit']) {
                                            echo "selected";
                                        };
                                                ?> >
                                                        <?php echo $laboratorio_item["laboratorio_nombre"] ?>
                                                </option>   
                                            <?php
                                            }
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="presentacion_id" class="control-label">Presentación</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='presentacion_id' class='form-control select2' required>
                                        <option name='presentacion_id' value=''>Seleccione un presentacion</option>
                                        <?php while ($presentacion_item = $presentacion->fetch(PDO::FETCH_ASSOC)): { ?>
                                                <option name='presentacion_id' value='<?php echo $presentacion_item["presentacion_id"]; ?>' <?php
                                        if ($presentacion_item['presentacion_id'] == $articulo['presentacion_id_edit']) {
                                            echo "selected";
                                        };
                                                ?> >
                                                        <?php echo $presentacion_item["presentacion_nombre"] ?>
                                                </option>   
                                            <?php
                                            }
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_valor_venta" class="control-label">Valor Venta</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock" name="articulo_valor_venta" placeholder="Precio de Venta" data-mask required value="<?php echo number_format($articulo['valor_venta'], 2, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_stock" class="control-label">Stock</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock" name="articulo_stock" placeholder="Cantidad en el inventario" data-mask-integer required value="<?php echo $articulo['stock_edit']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_stock_minimo" class="control-label">Stock mínimo</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock_minimo" name="articulo_stock_minimo" placeholder="Cantidad mínima" data-mask-integer required value="<?php echo $articulo['stock_minimo_edit']; ?>">
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
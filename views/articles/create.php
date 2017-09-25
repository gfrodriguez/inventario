<?php
$error = "<hr>";

$query = "SELECT id as laboratorio_id, nombre as laboratorio_nombre FROM laboratorio where 1";
$laboratorio = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT id as presentacion_id, nombre as presentacion_nombre FROM presentacion where 1";
$presentacion = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $laboratorio_id = $_POST['laboratorio_id'];
    $presentacion_id = $_POST['presentacion_id'];
    $articulo_nombre = str_replace("'", "&#39;",strip_tags($_POST['articulo_nombre']));
    $stock = $_POST['articulo_stock'];
    $stock_minimo = $_POST['articulo_stock_minimo'];
    $valor_venta = $_POST['articulo_venta'];
    $valor_venta = format_number($valor_venta);

    $query = "SELECT count(*) as total FROM articulo where nombre='$articulo_nombre' AND presentacion_id='$presentacion_id' AND laboratorio_id='$laboratorio_id';";

    $total = $db->query($query) or die($db->error . __LINE__);

    $total = $total->fetch(PDO::FETCH_ASSOC);

    $total = $total['total'];

    if ($total == 0) {
        $query = "INSERT INTO articulo (nombre,laboratorio_id,presentacion_id,stock,stock_minimo,valor_venta)
                             VALUES ('$articulo_nombre','$laboratorio_id','$presentacion_id','$stock','$stock_minimo','$valor_venta');";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' creó un artículo', $_SESSION['userid']);
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
                                    <label for="articulo_nombre" class="control-label">Nombre del Producto</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_nombre" name="articulo_nombre" placeholder="Nombre del Artículo" required value="<?php
                                    if (isset($_POST['articulo_nombre']) != "") {
                                        echo $_POST['articulo_nombre'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="laboratorio_id" class="control-label">Laboratorio</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='laboratorio_id' class='form-control select2' required>
                                        <option name='laboratorio_id' value=''>Seleccione un Laboratorio</option>
                                        <?php
                                        while ($laboratorio_item = $laboratorio->fetch(PDO::FETCH_ASSOC)): {
                                                echo "<option name='proveedor_id' value='" . $laboratorio_item["laboratorio_id"] . "'>" . $laboratorio_item["laboratorio_nombre"] . "</option>";
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
                                        <option name='presentacion_id' value=''>Seleccione una Presentación</option>
                                        <?php
                                        while ($presentacion_item = $presentacion->fetch(PDO::FETCH_ASSOC)): {
                                                echo "<option name='proveedor_id' value='" . $presentacion_item["presentacion_id"] . "'>" . $presentacion_item["presentacion_nombre"] . "</option>";
                                            }
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_venta" class="control-label">Valor Venta</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock" name="articulo_venta" placeholder="Precio de Venta" data-mask required value="<?php
                                    if (isset($_POST['articulo_venta']) != "") {
                                        echo number_format($_POST['articulo_venta'], 2, ',', '.');
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_stock" class="control-label">Stock</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock" name="articulo_stock" placeholder="Cantidad en el inventario" data-mask-integer required value="<?php
                                    if (isset($_POST['articulo_stock']) != "") {
                                        echo $_POST['articulo_stock'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="articulo_stock_minimo" class="control-label">Stock mínimo</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="articulo_stock_minimo" name="articulo_stock_minimo" placeholder="Cantidad mínima" data-mask-integer required value="<?php
                                    if (isset($_POST['articulo_stock_minimo']) != "") {
                                        echo $_POST['articulo_stock_minimo'];
                                    }
                                    ?>">
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

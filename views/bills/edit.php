<?php
$error = "<hr>";

$query = "SELECT proveedor.nombre as proveedor, proveedor_id, estado_id, factura.id as id, numero, fecha_factura, fecha_vencimiento_factura, valor_iva, valor_factura
            FROM factura, proveedor WHERE proveedor_id=proveedor.id and factura.id='$id';";
$factura = $db->query($query) or die($db->error . __LINE__);
$factura = $factura->fetch(PDO::FETCH_ASSOC);
$query = "SELECT id, nombre FROM estado where 1";
$estado = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT id, nombre FROM proveedor where 1";
$proveedor = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proveedor_id = $_POST['proveedor_id'];
    $numero = $_POST['numero'];
    $fecha_factura = $_POST['fecha_factura'];
    $estado= $_POST['estado_id'];
    $fecha_vencimiento_factura = $_POST['fecha_vencimiento_factura'];
    $valor_iva = $_POST['valor_iva'];
    $valor_iva = format_number($valor_iva);
    $valor_factura = $_POST['valor_factura'];
    $valor_factura = format_number($valor_factura);
    $query = "SELECT count(*) as total FROM factura where numero='$numero';";
    $total = $db->query($query) or die($db->error . __LINE__);
    $total = $total->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    if ($total == 1) {
        $query = "UPDATE factura SET numero='$numero',fecha_factura='$fecha_factura',fecha_vencimiento_factura='$fecha_vencimiento_factura',valor_iva='$valor_iva',valor_factura='$valor_factura', estado_id='$estado' WHERE id=$id;";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' editó una factura', $_SESSION['userid']);
        header("location:/bills/");
    } else {
        $error = '<div class="alert alert-danger alert-dismissable">
              <strong>¡Atención!</strong> Esa factura ya fue registrada</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Facturas
            <small>Editar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/bills/">Facturas</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $error; ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Registrar Factura</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Proveedor</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='proveedor_id' class='form-control select2' style="width: 100%;" required>
                                        <option name='proveedor_id' value=''>Seleccione un proveedor</option>
                                        <?php while ($proveedor_item = $proveedor->fetch(PDO::FETCH_ASSOC)): { ?>
                                                <option name='proveedor_id' value='<?php echo $proveedor_item["id"]; ?>' <?php
                                                if ($proveedor_item['id'] == $factura['proveedor_id']) {
                                                    echo "selected";
                                                };
                                                ?> >
                                                <?php echo $proveedor_item["nombre"] ?>
                                                </option>                                            
                                        <?php } endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="numero" class="control-label">Número</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número de la Factura" value="<?php echo $factura['numero'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="fecha_factura" class="control-label">Fecha de Factura</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fecha_factura" name="fecha_factura" placeholder="Fecha de Factura" value="<?php echo $factura['fecha_factura'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="fecha_vencimiento_factura" class="control-label">Fecha de Vencimiento</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fecha_vencimiento_factura" name="fecha_vencimiento_factura" placeholder="Fecha de Vencimiento"  value="<?php echo $factura['fecha_vencimiento_factura'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="valor_factura" class="control-label">Estado</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name='estado_id' class='form-control select2' style="width: 100%;" required>
                                        <option name='estado_id' value=''>Seleccione un estado</option>
                                        <?php while ($estado_item = $estado->fetch(PDO::FETCH_ASSOC)): { ?>
                                                <option name='estado_id' value='<?php echo $estado_item["id"]; ?>' <?php
                                                if ($estado_item['id'] == $factura['estado_id']) {
                                                    echo "selected";
                                                };
                                                ?> >
                                                <?php echo $estado_item["nombre"] ?>
                                                </option>                                            
                                        <?php } endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="valor_iva" class="control-label">Valor de IVA</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="valor_iva" name="valor_iva" placeholder="Valor de IVA" data-mask  value="<?php echo number_format($factura['valor_iva'], 2, ',', '.'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="valor_factura" class="control-label">Valor de Factura</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="valor_factura" name="valor_factura" placeholder="Valor de la factura" data-mask value="<?php echo number_format($factura['valor_factura'], 2, ',', '.'); ?>" required>
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

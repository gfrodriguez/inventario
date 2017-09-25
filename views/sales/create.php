<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$error = "<hr>";
$query = "SELECT articulo.id as articulo_id, articulo.nombre as articulo_nombre, laboratorio.id as laboratorio_id, laboratorio.nombre as laboratorio_nombre, presentacion.id as presentacion_id, presentacion.nombre as presentacion_nombre, articulo.stock FROM articulo, presentacion, laboratorio WHERE presentacion.id=articulo.presentacion_id AND laboratorio.id=articulo.laboratorio_id and articulo.stock>0 ORDER BY laboratorio_nombre;";
$articulo = $db->query($query) or die($db->error . __LINE__);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['venta_id'])) {
        $fecha_venta = "NOW()";
        $query = "INSERT INTO venta (fecha_venta)
                     VALUES (NOW());";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        $query = "Select id from venta order by ID desc limit 1";
        $result = $db->query($query) or die($db->error . __LINE__);
        $ultimo_venta_id = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['venta_id'] = $ultimo_venta_id['id'];
    }
    $venta_id = $_SESSION['venta_id'];
    if (!isset($_POST['guardar'])) {
        $guardar = 1;
    } else {
        $guardar = 0;
    }
    $articulo_id = $_POST['articulo_id'];
    $cantidad = $_POST['venta_cantidad'];
    $query = "SELECT stock FROM articulo WHERE id='$articulo_id';";
    $stock = $db->query($query) or die($db->error . __LINE__);
    $stock = $stock->fetch(PDO::FETCH_ASSOC);
    if ($cantidad <= $stock['stock']) {
        $query = "INSERT INTO venta_detalle (articulo_id,cantidad,venta_id)
                             VALUES ('$articulo_id','$cantidad','$venta_id');";
        $insert_row = $db->query($query) or die($db->error . __LINE__);
        $query = "UPDATE articulo SET stock=stock-$cantidad WHERE articulo.id=$articulo_id";
        $update_row = $db->query($query) or die($db->error . __LINE__);
        auditoria($_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI'], 'El usuario ' . $_SESSION['login_user'] . ' creó una venta', $_SESSION['userid']);
        if ($guardar == 1) {
            header("location:/sales/create");
        } elseif ($guardar == 0) {
            unset($_SESSION['venta_id']);
            echo "<style>
        .modal {
        text-align: center;
        padding: 0!important;
        }
        .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
        }
        .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
        }
        </style>";
            echo "<script>
            $(document).ready(function(){
            $('#total').modal('show');
            });
        </script>";
        }
    } else {
        $error = '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i>¡Atención!</h4>  Intenta vender cantidades que exceden el Stock actual del artículo.</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ventas
            <small>Crear</small>
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
                                        <option name='articulo_id' value=''>Seleccione un artículo</option>
                                        <?php
                                        $optgroup = "";
                                        while ($articulo_item = $articulo->fetch(PDO::FETCH_ASSOC)): {
                                                if ($optgroup != $articulo_item["laboratorio_nombre"] . $articulo_item['presentacion_nombre']) {
                                                    echo "<optgroup label='" . $articulo_item['laboratorio_nombre'] . " - " . $articulo_item['presentacion_nombre'] . "'>";
                                                }
                                                echo "<option name='articulo_id' value='" . $articulo_item["articulo_id"] . "'>" . $articulo_item["articulo_nombre"] . " (Stock " . $articulo_item['stock'] . " Unidades)</option>";
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
                                    <label for="venta_cantidad" class="control-label">Cantidad</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="venta_cantidad" name="venta_cantidad" placeholder="Cantidad vendida" data-mask-integer required>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="guardar_mas">Añadir otro producto a la venta</button>
                                    <button type="submit" class="btn btn-primary" name="guardar">Finalizar venta</button>
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
<!-- Modal -->
<div class="modal fade" id="total" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Venta</h4>
            </div>
            <div class="modal-body">
                <?php
                $query = "SELECT sum(cantidad*articulo.valor_venta) as total_venta FROM venta_detalle, articulo WHERE venta_id='$venta_id' AND venta_detalle.articulo_id=articulo.id;";
                $total_venta = $db->query($query) or die($db->error . __LINE__);
                $total_venta = $total_venta->fetch(PDO::FETCH_ASSOC);
                $total_venta = $total_venta['total_venta'];
                ?>
                El total de la venta es: <?php echo number_format($total_venta, 2, ',', '.'); ?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="/sales/">Cerrar</a>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
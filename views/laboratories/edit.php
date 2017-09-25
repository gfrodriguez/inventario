<?php
$error="<hr>";

$query = "SELECT * FROM laboratorio where id='$id';";
$laboratorio = $db->query($query) or die($db->error . __LINE__);
$laboratorio = $laboratorio->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_laboratorio = str_replace("'", "&#39;",strip_tags($_POST['nombre_laboratorio'])); 
    $query = "SELECT count(*) as total FROM laboratorio where id='$id';";
    $total = $db->query($query) or die($db->error . __LINE__);    
    $total = $total->fetch(PDO::FETCH_ASSOC);    
    $total = $total['total'];
    
    if($total==1){    
    $query = "UPDATE laboratorio SET nombre='$nombre_laboratorio' where id='$id';";
    $update_row = $db->query($query) or die($db->error . __LINE__);
    auditoria($_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], 'El usuario '.$_SESSION['login_user'].' editó un laboratorio', $_SESSION['userid']);
    header("location:/laboratories/");
    }else{
        $error='<div class="alert alert-danger alert-dismissable">
              <strong>¡Atención!</strong> Ese laboratorio ya esta registrado</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorios
            <small>Crear</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/laboratories/">Laboratorio</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $error;?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Registrar Laborarorio</strong></h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" id="form" name="form" action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="nombre" class="control-label">Nombre</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre_laboratorio" name="nombre_laboratorio" placeholder="Nombre del Laboratorio" value="<?php echo $laboratorio['nombre'] ?>" required>
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
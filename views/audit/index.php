<?php
$error = "";
$query = "SELECT auditoria.id, auditoria.created_at, userbrowser, ipaddress, url, description, user.username FROM auditoria, user WHERE user.id=auditoria.user_id ORDER BY auditoria.created_at DESC";
$audit = $db->query($query) or die($db->error . __LINE__);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Auditoria
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active">Auditoria</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_sales" class="table table-striped table-bordered dt-responsive nowrap"  width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha Acceso</th>
                                    <th>Dirección IP</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>       
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $audit->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>                                
                                        <th scope="row"><?php echo $i ?></th>
                                        <td><?php echo $row['created_at'] ?></td>                                        
                                        <td><?php echo $row['ipaddress'] ?></td>
                                        <td><?php echo $row['username'] ?></td>
                                        <td><?php echo $row['description'] ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-success" href="view/<?php echo $row['id'] ?>"><span class="fa fa-eye"></span></a>
                                                <?php $i++; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha Acceso</th>
                                    <th>Dirección IP</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>       
                                    <th></th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
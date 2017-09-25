<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Versión</b> <?php echo $version; ?>
    </div>
    <strong>Copyright &copy; 2017 <a href="http://gfrodriguez.online">Gabriel Rodríguez</a>.</strong> Todos los derechos reservados
</footer>


<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);</script>
<!-- Bootstrap 3.3.6 -->
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/assets/plugins/select2/select2.full.min.js"></script>
<!-- DataTables -->
<script src="/assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script src="/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="/assets/plugins/input-mask/jquery.inputmask.numeric.extensions.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
        $('#fecha_factura').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        });
        $('#fecha_vencimiento_factura').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        });
        $('#compra_fecha_vencimiento').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        });
        $("[data-mask]").inputmask("decimal", {radixPoint: ",", autoGroup: true, groupSeparator: ".", groupSize: 3, removeMaskOnSubmit: true});
        $("[data-mask-integer]").inputmask("integer");
    });
    $(document).ready(function () {
        $('table.dt-responsive').DataTable({
            destroy: true,
            autoWitdh: false,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles para ' + data[1];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            "language": {
                "decimal": ",",
                "thousands": ".",
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                buttons: {
                    copyTitle: 'Añadido al portapapeles',
                    copyKeys: 'Pulse <i> Ctrl </i> o <i> \u2318 </i> <i> C </i> para copiar los datos de la tabla en el portapapeles. <br> cancelar, haga clic en este mensaje o pulse Esc.',
                    copySuccess: {
                        _: '%d líneas copiadas',
                        1: '1 línea copiada'
                    }
                },
            },
            "dom": 'Bfrtip',
            lengthChange: false,
            buttons: [{extend: 'copy', text: 'Copiar'},
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        orthogonal: 'sort',
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                            }
                        }
                    },
                    <?php if (stripos($url, "suppliers")) {?>
                    title: '<?php echo "Proveedores " . date("d") . "-" . date("m") . "-" . date("Y"); ?>',
                    <?php }?>
                    <?php if (stripos($url, "articles")) {?>
                    title: '<?php echo "Inventario " . date("d") . "-" . date("m") . "-" . date("Y"); ?>',
                    <?php }?>
                    <?php if (stripos($url, "bills")) {?>
                    title: '<?php echo "Facturas " . date("d") . "-" . date("m") . "-" . date("Y"); ?>',
                    <?php }?>
                    <?php if (stripos($url, "purchases")) {?>
                    title: '<?php echo "Compras " . date("d") . "-" . date("m") . "-" . date("Y"); ?>',
                    <?php }?>
                    <?php if (stripos($url, "sales")) {?>
                    title: '<?php echo "Ventas " . date("d") . "-" . date("m") . "-" . date("Y"); ?>',
                    <?php }?>
                }
                , 'pdf'],
        });
    });</script>
<!-- Sparkline -->
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/app.min.js"></script>
</body>
</html>
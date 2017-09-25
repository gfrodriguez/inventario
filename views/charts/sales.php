<?php
$query = "SELECT sum(compra.cantidad*compra.valor_unitario) as compra, date(fecha_factura) as label FROM factura, compra, articulo WHERE compra.articulo_id=articulo.id and compra.factura_id=factura.id and year(fecha_factura) = YEAR(CURDATE()) group by label;";
$compra = $db->query($query) or die($db->error . __LINE__);
$query = "SELECT sum(venta_detalle.cantidad*articulo.valor_venta) as venta, DATE_FORMAT(fecha_venta,'%Y-%m-%d') as label FROM venta, articulo, venta_detalle WHERE venta_detalle.articulo_id=articulo.id and year(fecha_venta) = YEAR(CURDATE()) and venta.id=venta_detalle.venta_id group by label;";
$venta = $db->query($query) or die($db->error . __LINE__);
$graph_compra = $compra->fetchAll(PDO::FETCH_ASSOC);
$graph_venta = $venta->fetchAll(PDO::FETCH_ASSOC);
$graph = array_merge_recursive($graph_venta, $graph_compra);
$label = array_column($graph, 'label');
$label = array_unique($label);
$venta = array_column($graph, 'venta');
$compra = array_column($graph, 'compra');
?>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/assets/plugins/morris/morris.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="/assets/plugins/chartjs/Chart.min.js"></script>
<script>
    $(function () {
        Morris.Line({
            element: 'chartSales',
            resize: true,
            data: <?php echo json_encode($graph); ?>,
            xkey: 'label',
            ykeys: ['venta', 'compra'],
            stacked: true,
            labels: ['Ventas diarias', 'Compras diarias'],
            hideHover: 'auto',
            xLabels:"day"
        });
    });
</script>
<!--<script>
    $(function () {
        // This will get the first returned node in the jQuery collection.
        var Data = {
            labels: < ?php echo json_encode($label); ?>,
            datasets: [
                {
                    label: "Electronics",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "rgba(210, 214, 222, 1)",
                    pointColor: "rgba(210, 214, 222, 1)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [28, 48, 40, 19, 86, 27, 90]
                }
            ]
        };
        var Options = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $("#chartSales").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        Options.datasetFill = false;
        lineChart.Line(Data, Options);
    });
</script>-->

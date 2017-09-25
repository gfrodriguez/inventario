<?php
$query = "SELECT fecha_vencimiento_factura as start, CONCAT( CONCAT('Vence la factura No. ',factura.numero,' del proveedor '), proveedor.nombre) as title FROM factura, proveedor WHERE estado_id='1' AND proveedor_id=proveedor.id AND year(fecha_factura) = YEAR(CURDATE());";
$calendar = $db->query($query) or die($db->error . __LINE__);
$calendar = $calendar->fetchAll(PDO::FETCH_ASSOC);
?>
<script>

    $(document).ready(function () {
        var initialLocaleCode = 'es';
        $('#calendar').fullCalendar({
            locale: initialLocaleCode,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listYear'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mensual',
                week: 'Semanal',
                day: 'Diario'
            },
            defaultView: 'month',
            views: {
                listMonth: {buttonText: 'Lista de eventos'}
            },
            height: 510,
            width: 650,
            events: <?php echo json_encode($calendar) ?>,
            eventClick: function (event) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        })
    });
</script>
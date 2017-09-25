<?php
$query;
?>

<script>
Notification.requestPermission();
function spawnNotification(theBody,theIcon,theTitle) {
  var options = {
      body: theBody,
      icon: theIcon
  }
  var n = new Notification(theTitle,options);
  setTimeout(n.close.bind(n), 5000); 
}
spawnNotification("Esto es el cuerpo", undefined, "Título");
</script>
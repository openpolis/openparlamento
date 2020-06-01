<?php
// create a new cURL resource
$ch = "https://www.camera.it/leg18/207";

// grab URL and pass it to the browser
$testo=shell_exec("curl ".$ch);
echo $testo;


?>
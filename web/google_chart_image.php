<?php
  // Create some random text-encoded data for a line chart.
  header('content-type: image/png');
  $url = 'http://chart.apis.google.com/chart?chid=' . md5(uniqid(rand(), true));

  $chart_img_path = realpath(dirname(__FILE__).'/../data/serialized_chart_parameters');
  $chart_img_name = $_GET['chart_img_name'];

  // lettura parametri del chart da file temporaneo con hash utente
  $chart_params = unserialize(file_get_contents($chart_img_path . "/" . $chart_img_name));

  // Send the request, and print out the returned bytes.
  $context = stream_context_create(
    array('http' => array(
      'method' => 'POST',
      'content' => http_build_query($chart_params),
      'header' => 'Content-type: application/x-www-form-urlencoded')));
  fpassthru(fopen($url, 'r', false, $context));
?>
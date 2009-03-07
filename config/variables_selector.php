<?php
if (array_key_exists('SERVER_NAME', $_SERVER))
{
  if ($_SERVER['SERVER_NAME'] == 'op_openparlamento.openpolis.it') {
    $site_url = 'op_openparlamento.openpolis.it';
    $remote_guard_host = 'op_accesso.openpolis.it';
    $op_openpolis_host = 'op_openpolis.openpolis.it';
  } else if ($_SERVER['SERVER_NAME'] == 'parlamentodev.openpolis.it') {
    $site_url = 'parlamentodev.openpolis.it';
    $remote_guard_host = 'accessodev.openpolis.it';
    $op_openpolis_host = 'dev.openpolis.it';
  } else if ($_SERVER['SERVER_NAME'] == 'parlamento.openpolis.it') {
    $site_url = 'parlamento.openpolis.it';
    $remote_guard_host = 'accesso.openpolis.it';  
    $op_openpolis_host = 'www.openpolis.it';
  }
} else {
  // cli or task fallback
  $site_url = 'op_openparlamento.openpolis.it';
  $remote_guard_host = 'op_accesso.openpolis.it';
  $op_openpolis_host = 'op_openpolis.openpolis.it';
}
$api_key = '3114a2d106054d26c364c4cfff85910f97f7e29a';
?>

<?php
if (array_key_exists('SERVER_NAME', $_SERVER))
{
  if ($_SERVER['SERVER_NAME'] == 'op_openparlamento.openpolis.it') {
    $site_url = 'op_openparlamento.openpolis.it';
    $remote_guard_host = 'op_accesso.openpolis.it';
  } else if ($_SERVER['SERVER_NAME'] == 'parlamentodev.openpolis.it') {
    $site_url = 'parlamentodev.openpolis.it';
    $remote_guard_host = 'accessodev.openpolis.it';
  } else if ($_SERVER['SERVER_NAME'] == 'parlamento.openpolis.it') {
    $site_url = 'parlamento.openpolis.it';
    $remote_guard_host = 'accesso.openpolis.it';  
  }
} else {
  $site_url = '';
  $remote_guard_host = '';
}
?>

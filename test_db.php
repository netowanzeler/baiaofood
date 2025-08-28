<?php
$mysqli = new mysqli("212.85.3.19", "u468421729_netowanzeler", "4>iP!]#dT]zU", "u468421729_baiaofood");
if ($mysqli->connect_errno) {
  die("ERRO MySQLi: " . $mysqli->connect_error);
}
echo "OK! Conectou ao banco. Versão: " . $mysqli->server_info;
?>

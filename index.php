<?php 

require_once("config.php");

$init = new Config();

$usuario = $init->select("SELECT * FROM cad_usuario");

echo json_encode($usuario);
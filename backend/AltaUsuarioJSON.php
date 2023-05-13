<?php

require_once "./clases/Usuario.php";

use PDO\Usuario;

$correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "" ;

$us = new Usuario();

$us->correo = $correo;
$us->nombre = $nombre;
$us->clave = $clave;

echo $us->GuardarEnArchivo();
?>
<?php
require_once "./clases/Usuario.php";

use PDO\Usuario;

$nombre = $_POST["nombre"];
$clave = $_POST["clave"];
$correo = $_POST["correo"];
$id_perfil = $_POST["id_perfil"];

$us = new Usuario();
$us->nombre = $nombre;
$us->clave = $clave;
$us->correo = $correo;
$us->id_perfil = $id_perfil;

$rtObj = new stdClass;
$rtObj->mensaje = "Ocurrio un error, No se pudo agregar el usuario";

if($rtObj->exito = $us->Agregar())
{
    $rtObj->mensaje = "Registro agregado con exito!";
}

echo json_encode($rtObj);

?>
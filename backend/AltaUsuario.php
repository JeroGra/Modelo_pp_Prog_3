<?php
require_once "./clases/Usuario.php";

use PDO\Usuario;

$us = new Usuario();
$us->nombre = $_POST["nombre"];
$us->clave = $_POST["clave"];
$us->correo = $_POST["correo"];
$us->id_perfil = $_POST["id_perfil"];

$rtObj = new stdClass;
$rtObj->mensaje = "Ocurrio un error, No se pudo agregar el usuario";

if($rtObj->exito = $us->Agregar())
{
    $rtObj->mensaje = "Registro agregado con exito!";
}

echo json_encode($rtObj);

?>
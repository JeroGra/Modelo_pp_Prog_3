<?php

require_once "./clases/Usuario.php";

use PDO\Usuario;
$usuario = new Usuario();
$usuarioJSON = $_POST["usuario_json"];
$usStd = new stdClass;
$usStd = json_decode($usuarioJSON);
$objRt = new stdClass;
$objRt->exito = false;
$objRt->mensaje = "No se pudo modificar el usuario";

$usuario->id = $usStd->id;
$usuario->nombre = $usStd->nombre;
$usuario->correo = $usStd->correo;
$usuario->clave = $usStd->clave;
$usuario->id_perfil = $usStd->id_perfil;

if($usuario->Modificar())
{
    $objRt->exito = true;
    $objRt->mensaje = "Usuario modificado!";
}

echo json_encode($objRt);
?>
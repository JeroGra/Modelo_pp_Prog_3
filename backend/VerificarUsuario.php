<?php

require_once "./clases/Usuario.php";

use PDO\Usuario;

$usuarioJSON = $_POST["usuario_json"];
$usStd = new stdClass;
$usStd = json_decode($usuarioJSON);

$Usuario = Usuario::TraerUno($usStd->clave,$usStd->correo);

$objRt = new stdClass;
$objRt->exito = false;
$objRt->mensaje = "No se econtro el usuario";

if(($usStd->clave == $Usuario->clave)&&($usStd->correo == $Usuario->correo))
{
    $objRt->exito = true;
    $objRt->mensaje = "El usuario se encuentra registrado";
}

echo json_encode($objRt);
?>
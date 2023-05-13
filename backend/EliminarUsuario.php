<?php
require_once "./clases/Usuario.php";

use PDO\Usuario;

$objRt = new stdClass;
$objRt->exito = false;
$objRt->mensaje = "No se pudo elimiar el usuario";

if(Usuario::Eliminar($_POST["id"]))
{
    $objRt->exito = true;
    $objRt->mensaje = "Usuario eliminado!";
}

echo json_encode($objRt);
?>
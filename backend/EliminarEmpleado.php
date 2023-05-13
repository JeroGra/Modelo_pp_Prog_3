<?php
require_once "./clases/Empleado.php";

use PDO\Empleado;

$objRt = new stdClass;
$objRt->exito = false;
$objRt->mensaje = "No se pudo elimiar el empleado/a";

if(Empleado::Eliminar($_POST["id"]))
{
    $objRt->exito = true;
    $objRt->mensaje = "Empleado/a eliminado/a!";
}

echo json_encode($objRt);
?>
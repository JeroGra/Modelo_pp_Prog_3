<?php

require_once "./clases/Empleado.php";

use PDO\Empleado;

$tabla = "<table><tr><td>ID</td></tr><tr><td>NOMBRE</td></tr><tr><td>CORREO</td></tr><tr><td>PERFIL</td></tr><tr><td>SUELDO</td></tr><tr><td>FOTO</td></tr>";

$array = Empleado::TraerTodos();

foreach($array as $e)
{
    $tabla .= "<tr><td>{$e->id}</td></tr><tr><td>{$e->nombre}</td></tr><tr><td>{$e->correo}</td></tr><tr><td>{$e->perfil}</td></tr><tr><td>{$e->sueldo}</td></tr><tr><td><img src={$e->foto} width=50 height=50 /></td></tr></br>";
}

$tabla.="</table>";

echo $tabla;



?>
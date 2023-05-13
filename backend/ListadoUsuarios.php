<?php
require_once "./clases/Usuario.php";

use PDO\Usuario;

$tabla = "<table><tr><td>ID</td></tr><tr><td>NOMBRE</td></tr><tr><td>CORREO</td></tr><tr><td>PERFIL</td></tr>";

$array = Usuario::TraerTodos();

foreach($array as $us)
{
    $tabla .= "<tr><td>{$us->id}</td></tr><tr><td>{$us->nombre}</td></tr><tr><td>{$us->correo}</td></tr><tr><td>{$us->perfil}</td></tr>";
}

$tabla.="</table>";

echo $tabla;
?>
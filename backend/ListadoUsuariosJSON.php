<?php
require_once "./clases/Usuario.php";

use PDO\Usuario;

$array = Usuario::TraerTodosJSON();

foreach($array as $obj)
{
   echo json_encode($obj);
}

?>
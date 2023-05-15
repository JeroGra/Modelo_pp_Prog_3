<?php

require_once "./clases/Empleado.php";

use PDO\Empleado;

$empleado = new Empleado();
$empleadoJSON = $_POST["empleado_json"];
$eStd = new stdClass;
$eStd = json_decode($empleadoJSON);
$objRt = new stdClass;
$objRt->exito = false;
$objRt->mensaje = "No se pudo modificar el/la empleado/a";


$destino = "./empleados/fotos/" . date("ymd_His")."_". $_POST["nombre"]. pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);

function AgregarImagen($destino):bool
{

$uploadOk = TRUE;

//PATHINFO RETORNA UN ARRAY CON INFORMACION DEL PATH
//RETORNA : NOMBRE DEL DIRECTORIO; NOMBRE DEL ARCHIVO; EXTENSION DEL ARCHIVO

//PATHINFO_DIRNAME - retorna solo nombre del directorio
//PATHINFO_BASENAME - retorna solo el nombre del archivo (con la extension)
//PATHINFO_EXTENSION - retorna solo extension
//PATHINFO_FILENAME - retorna solo el nombre del archivo (sin la extension)
$tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);

if (file_exists($destino)) {
    echo "El archivo ya existe. Verifique!!!";
    $uploadOk = FALSE;
}
if ($_FILES["foto"]["size"] > 5000000 ) {
    echo "El archivo es demasiado grande. Verifique!!!";
    $uploadOk = FALSE;
}
$esImagen = getimagesize($_FILES["foto"]["tmp_name"]);

if($esImagen === FALSE) {

	if($tipoArchivo != "doc" && $tipoArchivo != "txt" && $tipoArchivo != "rar") {
		echo "Solo son permitidos archivos con extension DOC, TXT o RAR.";
		$uploadOk = FALSE;
	}
}
else {

	if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
		&& $tipoArchivo != "png") {
		echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
		$uploadOk = FALSE;
	}

}

if ($uploadOk === FALSE) {

    echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";

} 
else {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
        echo "<br/>El archivo ". basename( $_FILES["foto"]["name"]). " ha sido subido exitosamente.";
    } else {
        echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
    }
}

return $uploadOk;

}

if(AgregarImagen($destino))
{

$empleado->id = $eStd->id;
$empleado->nombre = $eStd->nombre;
$empleado->correo = $eStd->correo;
$empleado->clave = $eStd->clave;
$empleado->id_perfil = $eStd->id_perfil;
$empleado->sueldo = $eStd->sueldo;
$empleado->foto = $destino;

if($empleado->Modificar())
{
    $objRt->exito = true;
    $objRt->mensaje = "Empleado/a modificado!";
}

}

echo json_encode($objRt);

?>
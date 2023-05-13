<?php

namespace PDO
{
    require_once "Usuario.php";
    require_once "ICRUD.php";
    require_once "accesoDatos.php";
    require_once "IBM.php";

    use PDO\Usuario;
    use PDO\ICRUD;
    use POO\AccesoDatos;
    use PDO;
    use PDO\IBM;

    class Empleado extends Usuario implements ICRUD, IBM
    {
        public $foto;
        public $sueldo;

        public function __construct($foto = "", $sueldo = "")
        {
            parent::__construct();
            $this->foto = $foto;
            $this->sueldo = intval($sueldo);
        }

        public static function TraerTodos():array
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $arr = array();
        
            $consultaUs = $objetoAccesoDato->retornarConsulta("SELECT id, nombre AS nombre, correo AS correo, clave AS clave, id_perfil AS id_perfil, foto AS foto, sueldo AS sueldo "
                                                            . "FROM empleados");        
            $consultaUs->execute();
            
            $consultaUs->setFetchMode(PDO::FETCH_INTO, new Empleado());

            foreach($consultaUs as $e)
            {
                $rtObj = new Empleado();
                $perf = Usuario::DescripcionPerfil($e->id_perfil);
                $rtObj->id =  $e->id;
                $rtObj->nombre = $e->nombre;
                $rtObj->correo = $e->correo;
                $rtObj->clave = $e->clave;
                $rtObj->id_perfil = $e->id_perfil;
                $rtObj->foto = $e->foto;
                $rtObj->sueldo = $e->sueldo;
                $rtObj->perfil = $perf;
                array_push($arr,$rtObj);
            }
    
            return $arr; 
        }

        public function Agregar(): bool
        {
            $rt = false;
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO empleados (nombre, correo, clave, id_perfil, foto, sueldo)"
                                                        . "VALUES(:nombre, :correo, :clave, :id_perfil, :foto, :sueldo)");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
    
            if($consulta->execute() == 1)   
            {
                $rt = true;
            }
            
            return $rt;
            
        }

        public function Modificar(): bool
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->retornarConsulta("UPDATE empleados SET nombre = :nombre, correo = :correo, clave = :clave, 
                                                            id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);

            $rt = false;
    
    
            if($consulta->execute() == 1)
            {
                $rt = true;
            }

            return $rt;
            
        }

        public static function Eliminar(int $id):bool
        {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM empleados WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $usExiste = false;

            $ar = Empleado::TraerTodos();
    
            foreach($ar as $us)
            {
                if($us->id == $id)
                {
                    $usExiste = true;
                    break;
                }
            }

            if($usExiste)
            {
                $usExiste = false;
                if($consulta->execute())
                {
                    $usExiste = true;
                }
            }
    
            return $usExiste;

        }

        public static function TraerUnEmpleado(int $id)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consultaUS = $objetoAccesoDato->retornarConsulta("SELECT id, nombre AS nombre, correo AS correo, clave AS clave, id_perfil AS id_perfil 
             FROM usuarios WHERE id = :id ");

            $consultaUS->bindValue(':clave',$id,PDO::PARAM_INT);

            $consultaUS->execute();
            
            $consultaUS->setFetchMode(PDO::FETCH_INTO, new Empleado());

            $usRt = new Empleado();

            foreach($consultaUS as $e)
            {
                if($e->id == $id)
                {
                    $usRt = $e;
                }
            }

            return $usRt;
        }
    }

}

?>
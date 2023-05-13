<?php
 namespace PDO 
 {
    require_once "accesoDatos.php";
    require_once "IBM.php";
    use POO\AccesoDatos;
    use stdClass;
    use pdo;


     class Usuario implements IBM
    {

        public $id;
        public $nombre;
        public $correo;
        public $clave;
        public $id_perfil;
        public $perfil;

        public function __construct($id= "", $nombre = "", $correo = "", $clave = "", $id_perfil = "", $perfil = "")
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->correo = $correo;
            $this->clave = $clave;
            $this->$id_perfil = intval($id_perfil);
            $this->perfil = $perfil;
        }

        public function ToJSON() : string
        {
            return json_encode(get_object_vars($this));
        }

        public function GuardarEnArchivo() : string
        {
            $objRespuesta = new stdClass();
            $objRespuesta->exito = false;
            $objRespuesta->mensaje = "Ocurrio un error. No se pudo guardar el archivo";

            $ar = fopen("./archivos/usuarios.json","a");

            $cant = fwrite($ar,$this->ToJSON()."\r\n");

            if($cant > 0)
            {
                $objRespuesta->exito = true;
                $objRespuesta->mensaje = "Registro guardado con exito!";
            }

            fclose($ar);

            return json_encode(get_object_vars($objRespuesta));
        }

        public static function TraerTodosJSON()
        {
            
            $retorno = array();
            $str ="";
            $ar = fopen("./archivos/usuarios.json", "r");
    
            while(!feof($ar))
            {
                $str = fgets($ar);
                if($str != "")
                {
                    array_push($retorno,json_decode($str));	 
                }        	
            }
    
            fclose($ar);
    
            return $retorno;
        }

        public function Agregar():bool
        {      
            $rt = false;
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO usuarios (nombre, correo, clave, id_perfil)"
                                                        . "VALUES(:nombre, :correo, :clave, :id_perfil)");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
    
            if($consulta->execute() == 1)   
            {
                $rt = true;
            }
            
            return $rt;
        }

        public static function TraerTodos()
        {            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $arr = array();
        
            $consultaUs = $objetoAccesoDato->retornarConsulta("SELECT id, nombre AS nombre, correo AS correo, clave AS clave, id_perfil AS id_perfil "
                                                            . "FROM usuarios");        
            $consultaUs->execute();
            
            $consultaUs->setFetchMode(PDO::FETCH_INTO, new Usuario());

            foreach($consultaUs as $us)
            {
                $rtObj = new Usuario();
                $perf = Usuario::DescripcionPerfil($us->id_perfil);
                $rtObj->id =  $us->id;
                $rtObj->nombre = $us->nombre;
                $rtObj->correo = $us->correo;
                $rtObj->clave = $us->clave;
                $rtObj->id_perfil = $us->id_perfil;
                $rtObj->perfil = $perf;
                array_push($arr,$rtObj);
            }
    
            return $arr; 
        }

        protected static function DescripcionPerfil(int $id)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta = $objetoAccesoDato->retornarConsulta("SELECT id, descripcion AS perfil FROM perfiles WHERE id = :id");
                                                            
            $consulta->bindValue(':id',$id,PDO::PARAM_INT);

            $consulta->execute();
            
            $consulta->setFetchMode(PDO::FETCH_INTO, new stdClass); 
            
            foreach($consulta as $obj)
            {
               $str = $obj->perfil;
            }
            
            return $str;
        }

        public static function TraerUno(int $clave, string $correo)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consultaUS = $objetoAccesoDato->retornarConsulta("SELECT id, nombre AS nombre, correo AS correo, clave AS clave, id_perfil AS id_perfil 
             FROM usuarios WHERE clave = :clave AND correo = :correo");

            $consultaUS->bindValue(':clave',$clave,PDO::PARAM_STR);
            $consultaUS->bindValue(':correo',$correo,PDO::PARAM_STR);

            $consultaUS->execute();
            
            $consultaUS->setFetchMode(PDO::FETCH_INTO, new Usuario());

            $usRt = new Usuario();

            /// EL CONDICIONAL EVITA GENERAR UN USUARIO CON CAMPOS NULOS EN CASO DE NO ENCONTRAR EL USUARIO
            foreach($consultaUS as $us)
            {
                if($us->clave == $clave && $us->correo == $correo)
                {
                    $usRt = $us;
                }
            }


            return $usRt;
        }

        public function Modificar():bool
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->retornarConsulta("UPDATE usuarios SET nombre = :nombre, correo = :correo, clave = :clave, 
                                                            id_perfil = :id_perfil WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

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
            
            $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $usExiste = false;

            $ar = Usuario::TraerTodos();
    
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

    }

 }




?>
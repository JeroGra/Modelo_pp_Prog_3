<?php

namespace PDO
{

 /// MIMPORTANTE SOBRE METDOSO COMENTADOS ///
 /// Generan Inconsistencias al tener mismo nombre que los metodos de IBM implementados en Usuario, que es padre de Empleado ///
 /// LA SOLUCION FUE IMPLEMENTAR TAMBIEN IBM EN EMPLEADO ///


    interface ICRUD
    {
        //public static function TraerTodos():array; 
        public function Agregar():bool;

        public function Modificar():bool;

        //public static function Eliminar($id):bool;
    }

}
    
?>
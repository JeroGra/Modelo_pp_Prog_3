namespace Entidades
{
    export class Persona
   {
     nombre : string;
     correo :string;
     clave : string;

     constructor (nombre:string,correo:string)
     {
        this.nombre = nombre;
        this.correo = correo;
        this.clave = "";
     }

     ToString():string 
     {
        let str = "nombre:"+this.nombre+","+"correo:"+this.correo+","+"clave:"+this.clave;
        return str;
     }
   }

    export class Usuario extends Persona
   {
     id:Number;
     idPerfil:Number;
     perfil:string;

     constructor(nombre:string,correo:string,id:Number,idPefil:Number,perfil:string)
     {
        super(nombre,correo);
        this.id = id;
        this.idPerfil = idPefil;
        this.perfil = perfil;
     }

     ToJSON():JSON
     {
        let obj:JSON = JSON.parse(super.ToString()+",id:"+this.id+",idPerfil:"+this.idPerfil+",perfil:"+this.perfil);
        return obj;
     }
   }

   export class Empleado extends Usuario
   {
    sueldo: Number;
    foto:string;

    constructor(nombre:string,correo:string,idUs:Number,idPerfil:Number,perfil:string,sueldo:Number,foto:string)
    {
        super(nombre,correo,idUs,idPerfil,perfil);
        this.sueldo = sueldo;
        this.foto = foto;
    }

   }

}

namespace ModeloParcial
{
    export class Manejadora
    {
      /// CRUD USUARIO ///
        AgregarUsuarioJSON(nombre:string,correo:string,clave:string)
        {

        }

        MostrarUsuariosJSON()
        {

        }

        VerificarUsuarioJSON()
        {

        }

        AgregarUsuario(nombre:string,correo:string,clave:string,idPerfil:string)
        {

        }

        MostrarUsuarios()
        {

        }

        ModificarUsuario(obj:JSON)
        {

        }

        EliminarUsuario(obj:JSON)
        {

        }


        /// CRUD EMPELADO ///


        AgregarEmpleado(id:Number, sueldo:Number, foto:string)
        {

        }

        ModificarEmpleado(obj:JSON)
        {

        }

        EliminarEmpleado(obj:JSON)
        {
         
        }

 

    }
}
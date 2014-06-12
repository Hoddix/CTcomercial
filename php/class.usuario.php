<?php
/*
CTC 1.0 - Comercial Tablet Control

Creado por Javier Cabello Ortega
http://www.javiercabello.com
contactar@javiercabello.com

Licencia de Creative Commons
CTC 1.0 - Comercial Tablet Control by Javier cabello Ortega 
is licensed under a Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional License.
Creado a partir de la obra en http://javiercabello.com.
Puede hallar permisos más allá de los concedidos con esta licencia en http://javiercabello.com
*/

include_once('class.persona.php');

class Usuario extends Persona{

	//VARIABLES QUE USAREMOS EN ESTA CLASE
	protected $jsonPHP;

	//CONSTRUCTOR
	function __construct($jsonStr){

		parent::__construct();
		//INICIALIZAMOS LA VARIABLE CON LOS DATOS QUE OBTENEMOS DE CONSTRUCTOR
		$this->jsonPHP = json_decode($jsonStr,true);

	}

	//GENERAMOS EL SAL CON QUE CREAREMOS EL HASH PARA CODIFICAR EL PASS DEL USUARIO
	function generarSal(){ // Revidada

		//DECLARAMOS LAS VARIABLES CON LAS CUALES GENERAREMOS EL SAL PARA CODIFICAR EL PASSWORD
		$salAleatorio 		= "";
		$length 			= 64; //INDICAMOS QUE EL TAMAÑO ES DE 64 CHARS
		$indice 			= "";
		$charElegido 		= "";
		$listaCaracteres 	= "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; //LISTA DE CARACTERES PARA HACER EL SAL
		
		settype($length 		, "integer");
		settype($salAleatorio	, "string");
		settype($indice			, "integer");
		settype($charElegido	, "integer");
		
		//GENERAMOS EL SAL CHAR A CHAR
		for ($indice = 0; $indice <= $length; $indice++) {
			
			$charElegido   = rand(0, strlen($listaCaracteres) - 1);
			$salAleatorio .= $listaCaracteres[$charElegido];
		
		}
		
		//RETORNAMOS EL SAL PARA GENERAR EL PASS, CADA USUARIO TIENE UN SAL DIFERENTE		
		return $salAleatorio;

	}

	//GENERAMOS EL PASS HASEADO CON EL SAL
	function generarPassword(){ // Revidada

		//LLAMAMOS A LA FUNCION QUE GENERAR EL SAL
		$salAleatorio 			= $this->generarsal();
		//GENERAMOS EL PASS CIFRADO CON EL SAL
		$passwordHaseado 		= hash('SHA256', "-".$salAleatorio."-".$this->jsonPHP['password']."-");
		//RETORNAMOS EL HASH Y PASS HASEADO PARA GUARDARLOS EN LA BD 
		return $packEncriptado 	= array('0' => $salAleatorio,'1' => $passwordHaseado);
	
	}

	//FUNCION PARA AÑADIR UN NUEVO EMPLEADO A LA DB
	function newUser(){ // Revidada
		
		//OBTENEMOS LOS DATOS GENERADO A PARTIR DEL PASS DEL USUARIO
		$pack 		= $this->generarPassword();
		$sal 		= $pack[0];
		$password 	= $pack[1];

		//CONSULA CON LA QUE AÑADIMOS NUEVO USER
		$query 		= "SELECT id_usuario from usuarios where dni = '".$this->jsonPHP['dni']."'";
		
		if($consulta = $this->conectar->query($query)){

			if($consulta->num_rows == 0){
		
				$query = "INSERT INTO usuarios (id_usuario,dni,nombre,apellidos,direccion,cp,localidad,telefono,movil,email,password,user_hash,tipo) VALUES 
				(
					NULL , 
					'".$this->jsonPHP['dni']."',
					'".$this->jsonPHP['nombre']."',
					'".$this->jsonPHP['apellidos']."',
					'".$this->jsonPHP['direccion']."',
					'".$this->jsonPHP['cp']."',
					'".$this->jsonPHP['localidad']."',
					'".$this->jsonPHP['telefono']."',
					'".$this->jsonPHP['movil']."',
					'".$this->jsonPHP['email']."', 
					'".$password."',
					'".$sal."', 
					'".$this->jsonPHP['tipo']."'
				)";

				if($this->setPersona($query)) return true;
				else throw new UsuarioException( "Problema al añadir usuario. Consulta mal realizada" );

			}else return false;

		}else throw new UsuarioException( "Problema al añadir usuario. Consulta mal realizada" );

	}

	//FUNCION DE INICIO DE SESION
	function loginUsuario($dni,$password){ // Revidada

    	//OBTENEMOS EL HASH DEL USUARIO QUE QUIERE INICIAR SESION
    	$query = 'select id_usuario,user_hash,dni,password,nombre,tipo from usuarios where dni="'.$dni.'"';

		if($consulta = $this->conectar->query($query)){
			//SI NO OBTENEMOS HASH, ES QUE EL USUARIO NO EXISTE, ASI QUE DESCARTAMOS Y NOS AHORRAMOS EL RESTO DL PROCESO
			if($consulta->num_rows == 1){

				//SACAMOS EL RESULTADO DE LA CONSULTA ANTERIOR
				$resultado 	 = $consulta->fetch_row();
				$id_usuario  = $resultado[0];
				$hash_db 	 = $resultado[1];
				$dni_db 	 = $resultado[2];
				$password_db = $resultado[3];
				$nombre_db 	 = $resultado[4];
				$tipo_db	 = $resultado[5];

				//REHASEHAMOS EL PASSWORD DEL USUARIO PARA VER SI ES IGUAL QUE EL DE LA BASE DE DATOS
				$password_check = hash('SHA256', "-".$hash_db."-".$password."-");

				//COMPARAMOS DATOS Y SI TODO ES CORRECTO, OBTENEOS NUESTROS PARAMETROS Y SEGUIEMOS
				if(strtolower($dni_db) === strtolower($dni) && $password_db === $password_check){

					if($tipo_db == 1){

						return [
							'id_usuario'=>$id_usuario, 	//RETORNAMOS LA ID_USUARIO
							'nombre'=>$nombre_db,		//RETORNAMOS EL NOMBRE DEL USUARIO
							'temper'=>time()+23000,		//RETORNAMOS 23 MINUTOS DE SESION (24MIN NOS DEJA EL SERVER)
							'inAdmin'=>true,			//RETORNAMOS ES ADMIN (PANEL DE CONTROL ADMIN)
							'inComercial'=>false 		//RETORNAMOS ES COMERCIAL (PANEL DE CONTROL COMERCIAL)
						];

					}else if($tipo_db == 2){

						return [
							'id_usuario'=>$id_usuario,	//RETORNAMOS LA ID_USUARIO
							'nombre'=>$nombre_db,		//RETORNAMOS EL NOMBRE DEL USUARIO
							'temper'=>time()+23000,		//RETORNAMOS 23 MINUTOS DE SESION (24MIN NOS DEJA EL SERVER)
							'inAdmin'=>false,			//RETORNAMOS ES ADMIN (PANEL DE CONTROL ADMIN)
							'inComercial'=>true 		//RETORNAMOS ES COMERCIAL (PANEL DE CONTROL COMERCIAL)
						];

					}

				}else return false;

			}else return false;

		}else throw new UsuarioException( "Problema al hacer login. Consulta mal realizada" );

	}

	//OBTENEMOS TODOS LOS EMPLEADOS
	function getUsuarios(){ // Revidada

		$usuarios = null;

		//CONSULTA PARA OBTENER A TODOS LOS USUARIOS
		$query = "SELECT * from usuarios";

		//HACEMOS LA CONSULTA A LA DB
		if($consulta = $this->conectar->query($query)){
			
			//LEEMOS LINEA A LINEA Y GUARDAMOS LOS DATOS
			while ($row = $consulta->fetch_assoc()) {
	
				$usuarios[] = $row;
	
			}
			//RETORNAMOS LOS USUARIOS
			return $usuarios;

		}else throw new UsuarioException( "Problema al importar usuarios. Consulta mal realizada" );
		
	}

}

?>
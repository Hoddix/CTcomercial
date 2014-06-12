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

include_once ('class.conexion.php');

class Documento extends Conexion{

	//DECLARAMOS EL CONSTRUCTOR
	function __construct(){
		//OBTENEMOS EL VALOR DEL CONSTRUCTOR PADRE	
		parent::__construct();
	
	}

	//OBTENEMOS EL NUMERO SIGUIENTE EN LA DB PARA EL DOCUMENTO QUE VAMOS A CREAR
	function getNumber($query){

		if($consulta = $this->conectar->query($query)){
			//NUMERO SACADO DE LA DB
			$number = $consulta->fetch_assoc();

			return $number;	

		}else
			return false;
	
	}

	//OBTENEMOS EL NUMERO DE DOCUMENTO POR CLIENTE
	function getNumberByClient($query){

		if($consulta = $this->conectar->query($query)){
			//SACAMOS EL NUMERO DE LA DB	
			$number = $consulta->fetch_assoc();
			return $number;

		}else
			return false;
	
	}

	//AÑADIMOS EL NUEVO DOCUMENTO A LA DB
	function setNewDocument($query){

		//REALIZAMOS LA CONSULTA
		if($this->conectar->query($query))
			return true;
			
		else
			return false;

	}

	//ACTUALIZAMOS EL DOCUMENTO
	function updateDocument($query){

		//REALIZAMOS LA CONSULTA
		if($this->conectar->query($query))
			return true;
			
		else
			return false;

	}

	//AÑADIMOS PRODUCTOS AL DOCUMENTO
	function setProductsDocument($query){

		//REALIZAMOS LA CONSULTA
		if($this->conectar->query($query))	
			return true;			

		else
			return false;		

	}

}

?>
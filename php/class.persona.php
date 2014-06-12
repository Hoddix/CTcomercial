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

class Persona extends Conexion{

	//DECLARAMOS EL CONSTRUCTOR
	function __construct(){
		//OBTENEMOS LOS VALORES DEL CONSTRUCTOR PADRE
		parent::__construct();
	
	}

	//AÑADIMOS UNA NUEVA PERSONA
	function setPersona($query){
		//REALIZAMOS LA CONSULTA
		if($this->conectar->query($query))
			return true;

		else
			return false;

	}



}

?>
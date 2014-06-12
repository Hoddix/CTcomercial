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

class Categoria extends Conexion{

	//DECLARAMOS EL CONSTRUCTOR
	function __construct(){
		//OBTENEMOS LOS VALORES DEL CONSTRUCTOR PADRE
		parent::__construct();

	}

	//FUNCION QUE NOS RETORNA TODAS LAS CATEGORIAS
	function getCategorias(){

		$categorias = null;

		//CONSULTA CON LAS QUE OBTENEMOS LAS CATEGORIAS
		$query = "SELECT * from categorias";
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			//LEEMOS LIENA A LINEA Y OBTENEMOS LOS DATOS
			while ($row = $consulta->fetch_assoc()) {
			
				$categorias[] = $row;
			
			}
			//RETORNAMOS LAS CATEGORIAS
			return $categorias;
		
		}else
			throw new DBException( "Problema al obtener las categorias. Consulta mal realizada" );
		
	}


}

?>
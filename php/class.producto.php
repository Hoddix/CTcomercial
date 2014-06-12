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

class Producto extends Conexion{

	//DECLARAMOS EL CONSTRUCTOR
	function __construct(){
		//RECOGEMOS LOA PARAMETROS DEL PADRE
		parent::__construct();
		
	}


	//OBTENEMOS LOS PRODUCTOS SEGUN EL TIPO DE CONSULTA
	function getProductos($query){ // Revisada
		$productos= null;
		
		//REALIZAMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			//EN CASO DE HABER PRODUCTOS
			if($consulta->num_rows != 0){
				//LEEMOS LINEA A LINEA Y OBTENEMOS LOS DATOS
				while ($row = $consulta->fetch_assoc()) {
			
					$productos[] = $row;				
			
				}
				//RETORNAMOS PRODUCTOS
				return $productos;

			}else
				return $productos;
		
		}else
			throw new DBException( "Problema al obtener los productos. Consulta mal realizada" );

	}

	//FUNCION PARA ESTABLECER EL NUEVO STOCK DEL PRODUCTO
	function setNewStock($query){

		//HACEMOS LA CONSULTA CON LA QUERY QUE OBTENEMOS COMO PARAMETRO
		if($this->conectar->query($query))
			return true;
	
		else
			throw new DBException( "Problema al añadir nuevo stock. Consulta mal realizada" );

	}

	//FUNCION PARA OBTENER EL STOCK DEL PRODUCTO
	function getStock($query){
		
		$stock = null;
		//HACEMOS LA CONSULTA CON EL PARAMETRO QUE OBTENEMOS
		//RECOGEMOS LA CONSULTA
		if($consulta = $this->conectar->query($query)){
			//RECOGEMOS LOS RESULTADOS DE LA CONSULTA
			$stock = $consulta->fetch_assoc();
			
			return $stock;
		
		}else
			throw new DBException( "Problema al obtener el stock. Consulta mal realizada" );

	}

}


?>
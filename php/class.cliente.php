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

class Cliente extends Persona{

	//DECLARAMOS LA VARIABLE DONDE SE CARGAN LOS DATOS DEL CLIENTE
	protected $jsonPHP;
	//DECLARAMOS EL CONSTRUCTOR
	function __construct($jsonStr){
		//OBTENEMOS EL CONSTRUCTOR PADRE
		parent::__construct();
		//PARSEAMOS EL JSON Y LO PASAMOS A LA VARIABLE
		$this->jsonPHP = json_decode($jsonStr,true);

	}

	//FUNCION PARA AÑADIR UN NUEVO CLIENTE
	function newClient(){ // Revisada
		//CONSULTA CON LA QUE AÑADIMOS EL NUEVO CLIENTE
		$query = "INSERT INTO clientes (num_cliente,nombre,direccion,cp,localidad,nombre_contacto,telefono,movil,email,cod_fp,cif,recargo,plataforma) VALUES 
		(
			NULL , 
			'".$this->jsonPHP['nombre']."', 
			'".$this->jsonPHP['direccion']."', 
			'".$this->jsonPHP['cp']."', 
			'".$this->jsonPHP['localidad']."', 
			'".$this->jsonPHP['nombre_contacto']."', 
			'".$this->jsonPHP['telefono']."', 
			'".$this->jsonPHP['movil']."', 
			'".$this->jsonPHP['email']."', 
			'".$this->jsonPHP['formapago']."', 
			'".$this->jsonPHP['cif']."', 
			'".$this->jsonPHP['recargo']."',
			'".$this->jsonPHP['plataforma']."'
		)";
		//AÑADIMOS EL CLIENTE
		if($this->setPersona($query)) return true;
		
		else throw new DBException( "Problema al añadir un usuario. Consulta mal realizada" );

	}

	//OBTENEMOS LOS CLIENTES A LOS QUE SE LES GENERA ALBARAN
	function getClientesAlbaran(){ // Revisada
		
		$clientes = null;
		
		//CONSULTA QUE REALIZA LA PETICION DE LOS CLIENTES A LOS QUE SE LES HACEN ALBARANES
		$query = "SELECT * from clientes c join formasPago f on c.cod_fp=f.cod_fp where f.dias>0";
		//SE REALIZA LA CONSULTA
		if($consulta = $this->conectar->query($query)){
			//LEEMOS LINEA A LINEA Y ALAMCENAMOS LOS DATOS
			while ($row = $consulta->fetch_assoc()) {
		
				$clientes[] = $row;
		
			}
			//RETORNAMOS LOS CLIENTES
			return $clientes;

		}else
			throw new DBException( "Problema al obtener clientes para albaranes. Consulta mal realizada" );

	}

	//OBTENEMOS LOS CLIENTES A LOS QUE SE LES HACE FACTURA EN EL MOMENTO
	function getClientesFactura(){ // Revisada

		$clientes = null;

		//CONSULTA PARA OBTENER ESOS CLIENTES
		$query = "SELECT * from clientes c join formasPago f on c.cod_fp=f.cod_fp where f.dias=0";

		//HACEMOS LA CONSULTA A LA DB
		if($consulta = $this->conectar->query($query)){
			
			//LEEMOS LINEA A LINEA Y GUARDAMOS LOS DATOS
			while ($row = $consulta->fetch_assoc()) {
	
				$clientes[] = $row;
	
			}
			//RETORNAMOS LOS CLIENTES
			return $clientes;

		}else
			throw new DBException( "Problema al obtener clientes para facturas. Consulta mal realizada" );
		
	}

	//OBTENEMOS LA TARIFA PARA LA GENTE DE LA PLATAFORMA
	function getTarifaPlataforma(){ // Revisada

		$tarifaP = null;

		$query = "SELECT valor from tarifaPlataforma";
		//REALIZAMOS LA CONSULTA
		if($consulta = $this->conectar->query($query)){
			
			$tarifaP = $consulta->fetch_assoc();
			//RETORNAMOS EL VALOR DE LA TARIFA
			return $tarifaP;
		
		}else
			throw new DBException( "Problema al obtener la tarifa de la plataforma. Consulta mal realizada" );
		
	}

}

?>
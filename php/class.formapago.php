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

include_once('class.conexion.php');

class FormaPago extends Conexion{

	//DECLARAMOS LA VARIABLE
	protected $jsonPHP;

	//DECLARAMOS EL CONSTRUCTOR
	function __construct($jsonStr){
		//OBTENEMOS LOS CONSTRUCTORES PADRES
		parent::__construct();
		//INICIALIZAMOS LA VARIABLE
		$this->jsonPHP = json_decode($jsonStr,true);

	}

	//AÑADIMOS UNA NUEVA FORMA DE PAGO
	function newFormaPago(){ // Revisada

		//CONSULTA QUE SE SE ENCARGA DE AÑADIR UNA NUEVA FORMA DE PAGO
		$query = "INSERT INTO formasPago (cod_fp,forma_pago,dias,mesvencido) VALUES 
		(
			NULL , 
			'".$this->jsonPHP['forma_pago']."', 
			'".$this->jsonPHP['dias']."', 
			'".$this->jsonPHP['mesvencido']."'
		)";
		//HACEMOS LA CONSULTA
		if($this->conectar->query($query))
			return true;
		
		else
			throw new DBException( "Problema al añadir una forma de pago. Consulta mal realizada" );

	}

	//OBTENEMOS LAS FORMAS DE PAGO
	function getFormasPago(){ // Revisada

		$formaspago = null;

		//CONSULTA QUE OBTIENE TODAS LAS FORMAS DE PAGO
		$query = "SELECT * from formasPago";

		if($consulta = $this->conectar->query($query)){
			//LEEMOS LINEA A LINEA Y OBKTENEMOS LOS DATOS
			while ($row = $consulta->fetch_assoc()) {
		
				$formaspago[] = $row;
		
			}
			//RETORNAMOS FORMAS DE PAGO
			return $formaspago;

		}else
			throw new DBException( "Problema al obtener las formas de pago. Consulta mal realizada" );
		
	}

	function updateFormaPago(){


	}

	function delFormaPago(){

		
	}

}

?>
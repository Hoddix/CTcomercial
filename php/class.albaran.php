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

include_once ('class.doc.php');

class Albaran extends Documento{

	//Cremos las variables que usaremos en esta clase
	private $jsonPHP; 	//JSON QUE RECIBIMOS DEL JQUERY
	private $cliente; 	//SE GUARDA LA INFO DEL CLIENTE
	private $documento; //SE GUARDA LA INFO DEL DOCUMENTO
	private $productos; //SE GUARDAN LOS PRODUCTOS DEL DOCUMENTO

	//CREAMOS EL CONSTRUCTOR QUE INICIALIZARA LAS VARIABLES NECESARIAS
	//Y A SU VEZ OBTENEMOS LOS PARAMENTROS SUPERIORES
	function __construct($jsonFull){

		parent::__construct();

		//INICIALIZAMOS LAS VARIABLES ANTERIORES
		$this->jsonPHP 		= json_decode($jsonFull,true); //PARSEAMOS EL JSON Y LO CONVERTIMOS EN ARRAY
		$this->cliente 		= $this->jsonPHP[0];
		$this->productos 	= $this->jsonPHP[1];
		$this->documento 	= $this->jsonPHP[2];
		
	}

	function getNumeroAlbaran($id_usuario){

		$query = "SELECT id_albaran from albaranes where id_usuario='".$id_usuario."' order by id_albaran desc limit 1";
		
		if($number = $this->getNumber($query)){

			$num_albaran = date('Y')."-".$number['id_albaran'];

			$query = "UPDATE albaranes SET num_albaran='".$num_albaran."' WHERE id_albaran='".$number['id_albaran']."'";
			
			if($this->conectar->query($query)) return $num_albaran;
			else return false;
	
		}
		else return false;
		
	}

	//FUNCION PARA AÑADIR UN NUEVO ALBARAN
	function setAlbaran($id_usuario){
		
		$fecha = date("Y-n-j"); //RECOGEMOS LA FECHA ACTUAL PARA AÑADIRSELA AL ALBARAN, DADO QUE SE CREA AL MOMENTO

		//CONSULTA QUE SE ENCARGA DE RECOGER LOS VALORES DEL ALBARAN PARA SU POSTERIOR INSERCION EN LA DB
		$query 	= "INSERT INTO albaranes (id_albaran, num_albaran, fecha_exp, total_p, total_i, total_r, total_a, num_cliente, id_usuario) VALUES
		(
			NULL, 
			'', 
			'".$fecha."', 
			'".$this->documento['total_p']."', 
			'".$this->documento['total_i']."', 
			'".$this->documento['total_r']."', 
			'".$this->documento['total']."', 
			'".$this->cliente['numcliente']."',
			'".$id_usuario."'
		)";

		//LLAMAMOS A LA FUNCION DE LA CLASE HEREDADA CON LA QUE AÑADIRMOS UN NUEVO DOCUMENTO
		if($this->setNewDocument($query)){

			if($num_albaran = $this->getNumeroAlbaran($id_usuario)){
				//CONTADORES DE PRODUCTOS
				$contOk = 0;
				$contEr = 0;
				
				//FOR QUE SE ENCARGA DE RECORRER TODOS LOS PRODUCTOS
				for($x=0;$x<count($this->productos);$x++){

					//CONSULTA PARA RECOGER LOS DATOS DEL PRODUCTO ACTUAL
					$query = "INSERT INTO albaranesProductos (id, num_albaran, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(
						NULL,
						'".$num_albaran."',
						'".$this->productos[$x]['cod_producto']."', 
						'".$this->productos[$x]['cantidad']."', 
						'".$this->productos[$x]['precioUnitario']."', 
						'".$this->productos[$x]['dto']."', 
						'".$this->productos[$x]['totalUnitario']."', 
						'".$this->cliente['numcliente']."'
					)";	
					
					//INTRODUCIMOS EL NUEVO PRODUCTO EN LA DB CON LA FUNCION DE LA CLASE PADRE
					if($this->setProductsDocument($query))
						$contOk++;
						
					else
						$contEr++;

				}	

				return ['ok_a'=>'1','error_a'=>'0','ok_p_a'=>$contOk,'error_p_a'=>$contEr,'num_albaran'=>$num_albaran];
		
			}else
				return ['ok_a'=>'0','error_a'=>'1','ok_p_a'=>$contOk,'error_p_a'=>$contEr,'num_albaran'=>'0'];

		}else
			return ['ok_a'=>'0','error_a'=>'1','ok_p_a'=>$contOk,'error_p_a'=>$contEr,'num_albaran'=>'0'];

	}		

}

?>
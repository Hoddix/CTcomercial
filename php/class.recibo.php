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

class Recibo extends Documento{

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

	function getNumeroRecibo($id_usuario){
		
		$query = "SELECT id_recibo from recibos where id_usuario='".$id_usuario."' order by id_recibo desc limit 1";
		
		if($number = $this->getNumber($query)){

			$num_recibo = date('Y')."-".$number['id_recibo'];

			$query = "UPDATE recibos SET num_recibo='".$num_recibo."' WHERE id_recibo='".$number['id_recibo']."'";
			
			if($this->conectar->query($query)){
				
				return $num_recibo;

			}else
				return false;
	
		}
		else
			return false;
	
	}

	//FUNCION PARA AÑADIR UN NUEVO RECIBO
	function setRecibo($id_usuario){
		
		$fecha = date("Y-n-j"); //RECOGEMOS LA FECHA ACTUAL PARA AÑADIRSELA AL RECIBO, DADO QUE SE CREA AL MOMENTO

		//CONSULTA QUE SE ENCARGA DE RECOGER LOS VALORES DEL RECIBO PARA SU POSTERIOR INSERCION EN LA DB
		$query 	= "INSERT INTO recibos (id_recibo, num_recibo, fecha, total_p, total_i, total_r, total_re, num_cliente, id_usuario) VALUES
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

			if($num_recibo = $this->getNumeroRecibo($id_usuario)){
				//CONTADORES DE PRODUCTOS
				$contOk = 0;
				$contEr = 0;
				$stockOk = 0;
				$stockEr = 0;
				//FOR QUE SE ENCARGA DE RECORRER TODOS LOS PRODUCTOS
				for($x=0;$x<count($this->productos);$x++){

					//CONSULTA PARA RECOGER LOS DATOS DEL PRODUCTO ACTUAL
					$query = "INSERT INTO recibosProductos (id, num_recibo, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(
						NULL,
						'".$num_recibo."',
						'".$this->productos[$x]['cod_producto']."', 
						'".$this->productos[$x]['cantidad']."', 
						'".$this->productos[$x]['precioUnitario']."', 
						'".$this->productos[$x]['dto']."', 
						'".$this->productos[$x]['totalUnitario']."', 
						'".$this->cliente['numcliente']."'
					)";	
					
					//LLAMAMOS A LA FUNCION DE LA CLASE HEREDADA PARA QUE NOS INTRODUZCA LOS PRODUCTOS
					if($this->setProductsDocument($query)){

						//GENERAMOS UNA CONSULTA PARA LA NUEVA ACTUALIZACION DEL STOCK
						$query = "SELECT stock FROM productos WHERE cod_producto = '".$this->productos[$x]['cod_producto']."'";
						
						//CREAMOS UN NUEVO OBJETO DE LA CLASE PRODUCTO
						$producto = new Producto();

						//OBTENEMOS EL STOCK DEL PRODUCTO
						if($stock = $producto->getStock($query)){
						
							//RESTAMOS LA CANTIDAD DE PRODUCTO QUE VAMOS A VENDER CON LA QUE YA TENEMOS
							$stockRestante = (intval($stock['stock']) - intval($this->productos[$x]['cantidad']));

							//GENERAMOS LA CONSULTA PARA ALMACENAR LA NUEVA CANTIDAD
							$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$this->productos[$x]['cod_producto']."'";
						
							//ACTUALIZAMOS LA DB CON EL NUEVO STOCK
							if($producto->setNewStock($query))
								$contOk++;

							else
								$contEr++;

							$stockOk++;
					
						}else
							$stockEr++;

					}else
						$contEr++;

				}

				//RETORNAMOS EL NUMERO DE RECIBO
				return ['ok_r'=>'1','error_r'=>'0','ok_p_r'=>$contOk,'error_p_r'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_recibo'=>$num_recibo];

			}else
				return ['ok_r'=>'0','error_r'=>'1','ok_p_r'=>$contOk,'error_p_r'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_recibo'=>'0'];

		}else
			return ['ok_r'=>'0','error_r'=>'1','ok_p_r'=>$contOk,'error_p_r'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_recibo'=>'0'];

	}		

}

?>
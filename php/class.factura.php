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

include_once('class.doc.php');
include_once ('class.producto.php');

class Factura extends Documento{

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

	//
	function getNumeroFactura($id_usuario){
		
		$query = "SELECT id_factura from facturas where id_usuario='".$id_usuario."' order by id_factura desc limit 1";
		
		if($number = $this->getNumber($query)){

			$num_factura = date('Y')."-".$number['id_factura'];

			$query = "UPDATE facturas SET num_factura='".$num_factura."' WHERE id_factura='".$number['id_factura']."'";
			
			if($this->conectar->query($query)){
				
				return $num_factura;

			}else
				return false;
	
		}else
			return false;
	
	}

	//FUNCION PARA CREAR UNA FACTURA NUEVA
	//RECIBE UN PARAMETRO FECHA, QUE SERA CUANDO SE EMITE LA FACTURA
	function setFactura($fecha_ven,$id_usuario){

		if(isset($this->documento['num_albaran']))
			$num_albaran = $this->documento['num_albaran'];
		
		else
			$num_albaran = NULL;


		//CONSULTA PARA INFGRESAR LOS DATOS EN LA DB, TABLA FACTURAS
		$query = "INSERT INTO facturas (id_factura, num_factura, fecha, total_p, total_i, total_r, total_f, num_cliente, num_albaran, id_usuario) VALUES 
		(
			NULL, 
			'', 
			'".$fecha_ven."', 
			'".$this->documento['total_p']."', 
			'".$this->documento['total_i']."', 
			'".$this->documento['total_r']."', 
			'".$this->documento['total']."', 
			'".$this->cliente['numcliente']."', 
			'".$num_albaran."',
			'".$id_usuario."'
		)";

		//LLAMAMOS A LA FUNCION HEREDADA DE DOCUMENTO PARA INSERTAR UN NUEVO DOCUMENTO
		if($this->setNewDocument($query)){

			if($num_factura = $this->getNumeroFactura($id_usuario)){

				//CONTADORES DE PRODUCTOS INSERTADOS EXITO/ERROR
				$contOk = 0;
				$contEr = 0;
				$stockOk = 0;
				$stockEr = 0;
				//FOR QUE RECORRE $PRODUCTOS 
				for($x=0;$x<count($this->productos);$x++){

					//GENERAMOS UNA CONSULTA POR VUELTA, HASTA ACABAR LOS PRODUCTOS
					$query = "INSERT INTO facturasProductos (id, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(
						NULL,
						'".$num_factura."',
						'".$this->productos[$x]['cod_producto']."', 
						'".$this->productos[$x]['cantidad']."', 
						'".$this->productos[$x]['precioUnitario']."', 
						'".$this->productos[$x]['dto']."', 
						'".$this->productos[$x]['totalUnitario']."', 
						'".$this->cliente['numcliente']."'
					)";	
					
					//INSERTAMOS LOS PRODUCTOS CON LA FUNCION HEREDADA DE LA CLASE PADRE
					//Y COMPROBAMOS QUE SE INTRODUCEN CORRECTAMENTE				
					if($this->setProductsDocument($query)){

						//CONSULTA PARA OBTENER EL STOCK ALTUAL DEL PRODUCTO INDEXADO
						$query = "SELECT stock FROM productos WHERE cod_producto = '".$this->productos[$x]['cod_producto']."'";

						//GENERAMOS UN NUEVO OBJETO PRODUCTO
						$producto = new Producto();

						//PEDIMOS SU STOCK
						if($stock = $producto->getStock($query)){
							
							//DESCONTAMOS LA CANTIDAD  NUEVA DE LA GLOBAL Y OBTENEMOS EL RESTO
							$stockRestante = (intval($stock['stock']) - intval($this->productos[$x]['cantidad']));

							//CONSULTA PARA ACTUALIZAR EL STOCK DEL PRODUCTO ACTUAL
							$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$this->productos[$x]['cod_producto']."'";
							
							//ACTUALIZAMOS Y SI ES CORRECTO PROSEGUIMOS CON EL SIGUIENTE HASTA SALIR DEL LOOP
							if($producto->setNewStock($query))
								$stockOk++;

							else
								$stockEr++;
					
						}else
							$stockEr++;

						$contOk++;

					}else
						$contEr++;
				}

				return ['ok_f'=>'1','error_f'=>'0','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_factura' => $num_factura];		
			
			}else
				return ['ok_f'=>'0','error_f'=>'1','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_factura' => '0'];

		}else
			return ['ok_f'=>'0','error_f'=>'1','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr,'num_factura' => '0'];
	
	}

	//FUNCION PARA ACTUALIZAR EL CONTENIDO DE UNA FACTURA
	//CREADO PARA CLIENTES QUE PAGAN A MES VENCIDO
	function updateFactura($num_factura){
		
		//GENERAMOS UNA CONSULTA QUE NOS RECOGE LOS DATOS DE LA DB PARA SU POSTERIOR ACTUALIZACION
		$query = "SELECT total_p, total_i, total_r, total_f FROM facturas where num_factura='".$num_factura."'";

		//OBTENEMOS LOS DATOS 
		if($consulta = $this->conectar->query($query)){
			$oldData = $consulta->fetch_assoc();
			//SUMAMOS LOS DATOS VIEJOS CON LOS NUEVOS PARA OBTENER EL TOTAL ACTUAL
			$total_p = $oldData['total_p'] + $this->documento['total_p'];
			$total_i = $oldData['total_i'] + $this->documento['total_i'];
			$total_r = $oldData['total_r'] + $this->documento['total_r'];
			$total_f = $oldData['total_f'] + $this->documento['total'];

			//GENERAMOS LA CONSULTA QUE NOS ACTUALZIA LA FACTURA
			$query = "UPDATE facturas SET total_p=$total_p,total_i=$total_i,total_r=$total_r,total_f=$total_f WHERE num_factura='".$num_factura."'";
			
			//LLAMAMOS A LA FUNCION DE LA CLASE PADRE
			if($this->updateDocument($query)){
				
				//CONTADORES DE PRODUCTOS ALMACCENADOS EN LA DB
				$contOk = 0;
				$contEr = 0;
				$stockOk = 0;
				$stockEr = 0;
				//FOR QUE SE ENCARGA DE RECORRER TODOS LOS PRODUCTOS
				for($x=0;$x<count($this->productos);$x++){

					//CONSULTA QUE SE ENCARGA DE AÑADIR NUEVOS PRODUCTOS A LA FACTURA QUE ESTAMOS ACTUALIZANDO
					$query = "INSERT INTO facturasProductos (id, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(
						NULL, 
						'".$num_factura."',
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

				return ['ok_f'=>'1','error_f'=>'0','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr];		

			}else
				return ['ok_f'=>'1','error_f'=>'0','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr];
		
		}else
			return ['ok_f'=>'1','error_f'=>'0','ok_p_f'=>$contOk,'error_p_f'=>$contEr,'ok_s'=>$stockOk,'error_s'=>$stockEr];
	}

}

?>
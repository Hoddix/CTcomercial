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

// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

class PHPException extends Exception { }

class DBException extends Exception { }

class UsuarioException extends Exception { }

set_error_handler('myErrorHandler');

function myErrorHandler($code, $error, $file = NULL, $line = NULL) {
  throw new PHPException($error . ' encontrado en '. $file.', línea '.$line);

  throw new DBException($error . ' encontrado en '. $file.', línea '.$line);

  throw new UsuarioException($error . ' encontrado en '. $file.', línea '.$line);
}

try {
	session_start();

	include_once ('../php/class.albaran.php');
	include_once ('../php/class.factura.php');
	include_once ('../php/class.recibo.php');
	include_once ('../php/class.cliente.php');
	include_once ('../php/class.usuario.php');
	include_once ('../php/class.formapago.php');
	include_once ('../php/class.categoria.php');
	include_once ('../php/class.producto.php');
	include_once ('../php/class.mensaje.php');
	include_once('../php/class.estadistica.php');

	// Todo el código que queramos instanciando N clases, con herencias y todo lo que queráis
 	if(isset($_POST['login'])){ // Revidada

		$dni = $_POST['dni'];
		$password = $_POST['password'];

		$usuario = new Usuario(Null);

		if($status = $usuario->loginUsuario($dni,$password)){

			$_SESSION['id_usuario']  = $status['id_usuario'];
			$_SESSION['nombre'] 	 = $status['nombre'];
			$_SESSION['temper'] 	 = $status['temper'];
			$_SESSION['inAdmin'] 	 = $status['inAdmin'];
			$_SESSION['inComercial'] = $status['inComercial'];
			
			if($_SESSION['inAdmin'] == true){

				header("Location: ../portada/control.php");
			
			}else if($_SESSION['inComercial'] == true){
			
				header("Location: ../comercial/controlComercial.php");
			
			}else{
			
				$_SESSION['usuarioerror'] = "ok";
				header("Location: ../login.php");
			
			}
		
		}else{
			
			$_SESSION['usuarioerror'] = "ok";
			header("Location: ../login.php");
			
		}
	
	}

	//if($_SESSION['temper'] > time()){
		if(isset($_POST['peClientes'])){ // Revisada
	
			$efectivo = new Cliente(Null);

			$clientesE = $efectivo->getClientesFactura();
				
			echo json_encode($clientesE);
	
		}
		elseif(isset($_POST['paClientes'])){ // Revisada

			$albaran = new Cliente(Null);
			
			$clientesA = $albaran->getClientesAlbaran();
			
			echo json_encode($clientesA);

		}
		elseif(isset($_POST['getUsuarios'])){ // Revidada
	
			$lista = new Usuario(Null);

			$usuarios = $lista->getUsuarios();
			
			echo json_encode($usuarios);
	
		}		
		elseif(isset($_POST['categorias'])){ // Revidada
	
			$lista = new Categoria(Null);

			$categorias = $lista->getCategorias();
			
			echo json_encode($categorias);

		}
		elseif(isset($_POST['tarifaP'])){ // Revisada
		
			$plataforma = new Cliente(Null);

			$tarifa = $plataforma->getTarifaPlataforma();
			
			echo json_encode($tarifa);

		}	
		elseif(isset($_POST['formaPago'])){ // Revisada
			
			$lista = new FormaPago(Null);

			$formasP = $lista->getFormasPago();
			
			echo json_encode($formasP);

		}
		elseif(isset($_POST['selCategoria'])){ // Revisada
			
			$cliente = $_POST['num_cliente'];
			$cod_categoria = $_POST['cod_categoria'];

			$query1 = "SELECT p.cod_producto,p.nom_producto,p.precio,p.stock,p.peso_gramos,p.unidades_caja,t.nom_tarifa,t.tarifa,t.especial,a.nom_categoria,a.cod_categoria,c.num_cliente,c.nombre 
			from productos p join tarifas t on 
			t.cod_producto = p.cod_producto join clientes c on 
			t.num_cliente = c.num_cliente join categorias a on 
			p.cod_categoria = a.cod_categoria 
			where c.num_cliente = $cliente and a.cod_categoria = $cod_categoria";	

			$query2 = "SELECT DISTINCT * FROM productos p WHERE NOT EXISTS (select * from tarifas t where p.cod_producto = t.cod_producto and t.num_cliente = $cliente) and p.cod_categoria = $cod_categoria";
			
			$productos = new Producto();
			
			$lista[] = $productos->getProductos($query1);
			$lista[] = $productos->getProductos($query2);

			echo json_encode($lista);

		}
		elseif(isset($_POST['numeroAlbaran'])){ // Revisada
			
			$numero = new Albaran(Null);
			
			if($numAlbaran = $numero->getNumeroAlbaran()) echo json_encode($numAlbaran);	
		
		}
		elseif(isset($_POST['numeroFactura'])){ // Revisada
		
			$factura = new Factura(Null);
		
			if($numFactura = $factura->getNumeroFactura()) echo json_encode($numFactura);
		
		}
		elseif(isset($_POST['numeroRecibo'])){ // Revisada
		
			$recibo = new Recibo(Null);
		
			if($numRecibo = $recibo->getNumeroRecibo()) echo json_encode($numRecibo);	
		
		}
		elseif(isset($_POST['addAlbaran'])){
			
			$jsonFull 		= $_POST['jsonFull'];
			$nuevoAlbaran 	= new Albaran($jsonFull);
			$nuevaFactura 	= new Factura($jsonFull);

			$json_data = json_decode($jsonFull,true);

			if($datosAlbaran = $nuevoAlbaran->setAlbaran($_SESSION['id_usuario'])){

				$query 	= "select f.dias,f.mesvencido from formasPago f join clientes c on f.cod_fp=c.cod_fp where num_cliente='".$json_data[0]['numcliente']."'";
				$con 	= new Conexion();

				if($consulta = $con->conectar->query($query)) $tipo = $consulta->fetch_assoc();
				
				if($tipo['dias'] != 0 && $tipo['mesvencido'] == "no") $mesvencido = false;
				elseif($tipo['dias'] != 0 && $tipo['mesvencido'] == "si") $mesvencido = true;

				if($mesvencido){

					$fecha_act 	= date("Y-n-j");
					$fecha_ven 	= date("Y-n-j",mktime(0,0,0,date('n'),date($tipo['dias']),date('Y')));
					$fecha1 	= new DateTime($fecha_act);
					$fecha2 	= new DateTime($fecha_ven);

					if($fecha1 >= $fecha2)
						$fecha_ven = date("Y-n-j",mktime(0,0,0,date('n')+1,date($tipo['dias']),date('Y')));
					
					$query 		= "SELECT num_factura from facturas where fecha='".$fecha_ven."' and num_cliente='".$json_data[0]['numcliente']."'";
					$consulta 	= $con->conectar->query($query);
					$factura 	= $consulta->fetch_assoc();
					$result 	= $consulta->num_rows;

					if($result == 0){
						
						if($datos = $nuevaFactura->setFactura($fecha_ven,$_SESSION['id_usuario'])){
				
							$_SESSION['json'] = json_decode($jsonFull,true);
							$_SESSION['json'][2]['num_albaran'] = $datosAlbaran['num_albaran'];
							
							if($datos['ok_f'] == '1'){
								$_SESSION['ok_f'] = "Factura creada correctamente.<br/>";
								$_SESSION['ok_p_f'] = $datos['ok_p_f'].' productos guardados correctamente.<br/>';
								$_SESSION['error_p_f'] = $datos['error_p_f'].' productos no se han podido guardar.<br/>';
								$_SESSION['ok_s'] = $datos['ok_s'].' productos actualizados correctamente.<br/>';
								$_SESSION['error_s'] = $datos['error_s'].' productos no se han podido actualizar.<br/>';
							}
							else $_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';
				
						}
						else $_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';

					}else{
					
						if($datos = $nuevaFactura->updateFactura($factura['num_factura'])){
					
							$_SESSION['json'] = json_decode($jsonFull,true);
							$_SESSION['json'][2]['num_albaran'] = $datosAlbaran['num_albaran'];
							
							if($datos['ok_f'] == '1'){
								$_SESSION['ok_f'] = "Factura actualizada correctamente.<br/>";
								$_SESSION['ok_p_f'] = $datos['ok_p_f'].' productos guardados correctamente.<br/>';
								$_SESSION['error_p_f'] = $datos['error_p_f'].' productos no se han podido guardar.<br/>';
								$_SESSION['ok_s'] = $datos['ok_s'].' productos actualizados correctamente.<br/>';
								$_SESSION['error_s'] = $datos['error_s'].' productos no se han podido actualizar.<br/>';
							}
							else $_SESSION['error_f'] = 'No se ha podido actualizar la factura.<br/>';

						}
						else $_SESSION['error_f'] = 'No se ha podido actualizar la factura.<br/>';

					}
				
				}else{

					$fecha_ven 	= date("Y-n-j",mktime(0,0,0,date('n'),date('j')+$tipo['dias'],date('Y')));

					if($datos = $nuevaFactura->setFactura($fecha_ven,$_SESSION['id_usuario'])){
						
						$_SESSION['json'] = json_decode($jsonFull,true);
						$_SESSION['json'][2]['num_albaran'] = $datosAlbaran['num_albaran'];
						
						if($datos['ok_f'] == '1'){
							$_SESSION['ok_f'] = "Factura creada correctamente.<br/>";
							$_SESSION['ok_p_f'] = $datos['ok_p_f'].' productos guardados correctamente.<br/>';
							$_SESSION['error_p_f'] = $datos['error_p_f'].' productos no se han podido guardar.<br/>';
							$_SESSION['ok_s'] = $datos['ok_s'].' productos actualizados correctamente.<br/>';
							$_SESSION['error_s'] = $datos['error_s'].' productos no se han podido actualizar.<br/>';
						}
						else $_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';
					
					}
					else $_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';

				}

				if($datosAlbaran['ok_a'] == '1'){
					$_SESSION['ok_a'] = 'Albaran creado correctamente.<br/>';
					$_SESSION['ok_p_a'] = $datosAlbaran['ok_p_a'].' productos guardados correctamente.<br/>';
					$_SESSION['error_p_a'] = $datosAlbaran['error_p_a'].' productos no se han podido guardar.<br/>';
					echo 1;
				}else{
					$_SESSION['error_a'] = 'No se ha podido crear el albaran.<br/>';	
					echo 0;
				}

			}else{
				$_SESSION['error_a'] = 'No se ha podido crear el albaran.<br/>';
				echo 0;
			}
		
		}				
		elseif(isset($_POST['addFactura'])){
			
			$jsonFull 	  = $_POST['jsonFull'];
			$fecha 		  = date("Y-n-j");
			$nuevaFactura = new Factura($jsonFull);
			
			if($datos = $nuevaFactura->setFactura($fecha,$_SESSION['id_usuario'])){
				
				$_SESSION['json'] = json_decode($jsonFull,true);
				$_SESSION['json'][2]['num_factura'] = $datos['num_factura'];
				
				if($datos['ok_f'] == '1'){
					$_SESSION['ok_f'] = "Factura creada correctamente.<br/>";
					$_SESSION['ok_p_f'] = $datos['ok_p_f'].' productos guardados correctamente.<br/>';
					$_SESSION['error_p_f'] = $datos['error_p_f'].' productos no se han podido guardar.<br/>';
					$_SESSION['ok_s'] = $datos['ok_s'].' productos actualizados correctamente.<br/>';
					$_SESSION['error_s'] = $datos['error_s'].' productos no se han podido actualizar.<br/>';

					echo 1;

				}else{
					$_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';

					echo 0;
				}

			}else{
				$_SESSION['error_f'] = 'No se ha podido crear la factura.<br/>';
				echo 0;
			}
				
		}
		elseif(isset($_POST['addRecibo'])){
			
			$jsonFull 	  = $_POST['jsonFull'];
			$nuevoRecibo  = new Recibo($jsonFull);
			
			if($datos = $nuevoRecibo->setRecibo($_SESSION['id_usuario'])){

				$_SESSION['json'] = json_decode($jsonFull,true);
				$_SESSION['json'][2]['num_recibo'] = $datos['num_recibo'];
				
				if($datos['ok_r'] == '1'){
					$_SESSION['ok_r'] = "Recibo creado correctamente.<br/>";
					$_SESSION['ok_p_r'] = $datos['ok_p_r'].' productos guardados correctamente.<br/>';
					$_SESSION['error_p_r'] = $datos['error_p_r'].' productos no se han podido guardar.<br/>';
					$_SESSION['ok_s'] = $datos['ok_s'].' productos actualizados correctamente.<br/>';
					$_SESSION['error_s'] = $datos['error_s'].' productos no se han podido actualizar.<br/>';

					echo 1;

				}else{

					$_SESSION['error_r'] = 'No se ha podido crear el recibo.<br/>';
					echo 0;
				}

			}else{
			
				$_SESSION['error_r'] = 'No se ha podido crear el recibo.<br/>';
				echo 0;
			
			}
		
		}
		elseif(isset($_POST['addCliente'])){ //revisada
			
			$jsonFull 	  = $_POST['jsonFull'];
			
			$nuevoCliente = new Cliente($jsonFull);
			
			$setC 		  = $nuevoCliente->newClient();
			
			echo $setC;

		}
		elseif(isset($_POST['addUsuario'])){ //revisada
			
			$jsonFull 	  = $_POST['jsonFull'];
			
			$nuevoUsuario = new Usuario($jsonFull);
			
			$setU 		  = $nuevoUsuario->newUser();
			
			echo $setU;

		}		
		elseif(isset($_POST['paginarMensajes'])){ //revisada

			$id      = $_POST['id'];
			$page 	 = $_POST['page'];
			
			$paginar = new Mensaje(Null);

			$numPag = $paginar->pagination($id,$page);
			
			echo $numPag;

		}
		elseif(isset($_POST['getMensajes'])){ //revisada
		
			$id     = $_POST['id'];
			$ini    = $_POST['ini'];
			$fin    = $_POST['fin'];
			
			$lista  = new Mensaje(Null);
			
			$inbox = $lista->inBox($id,$ini,$fin);

			echo json_encode($inbox);
			
			//else echo json_encode(0);

		}
		elseif(isset($_POST['getMensajesSalida'])){ //revisada

			$id      = $_POST['id'];
			$ini     = $_POST['ini'];
			$fin     = $_POST['fin'];

			$lista   = new Mensaje(Null);
			
			$outbox = $lista->outBox($id,$ini,$fin);
			
			echo json_encode($outbox);
			
			//else echo json_encode(0);

		}
		elseif(isset($_POST['getPapelera'])){ //revisada

			$id      = $_POST['id'];
			$ini     = $_POST['ini'];
			$fin     = $_POST['fin'];

			$lista   = new Mensaje(Null);
			
			$bin = $lista->bin($id,$ini,$fin);
			
			echo json_encode($bin);
			
			//else echo json_encode(0);

		}				
		elseif(isset($_POST['getMensajesSinLeer'])){ //revisada
	
			$id = $_POST['id'];
			
			$sinleer = new Mensaje(Null);
			
			$noleidos = $sinleer->unRead($id);

			echo $noleidos;		
	
		}
		elseif(isset($_POST['responderMensaje'])){ //revisada

			$id_mensaje = $_POST['id_mensaje'];
			
			$mensaje    = new Mensaje(Null);
			
			$responder = $mensaje->reMessage($id_mensaje);
			
			echo json_encode($responder);
		
		}		
		elseif(isset($_POST['updateMensaje'])){ //revisada

			$id_mensaje = $_POST['id'];
			
			$mensaje    = new Mensaje(Null);
			
			$leido = $mensaje->readMessage($id_mensaje);
			
			echo $leido;

		}
		elseif(isset($_POST['borrarMensaje'])){ //revisada
			
			$id_mensaje = $_POST['id'];
			
			$mensaje    = new Mensaje(Null);
			
			$papelera = $mensaje->send2TheBin($id_mensaje);
			
			echo $papelera;
		
		}
		elseif(isset($_POST['sendMensaje'])){ //revisada

			$jsonMensaje = $_POST['jsonMensaje'];
			
			$mensaje = new Mensaje($jsonMensaje);
			
			$correcto = $mensaje->sendMessage();
			
			echo $correcto;

		}
		elseif(isset($_POST['estadisticaAnual'])){
			
			$grafica     = new Estadistica(Null);
			
			if($correcto = $grafica->facturacionMensual())
				echo json_encode($correcto);
			else
				throw new Exception( "498" );	

		}
		elseif(isset($_POST['semanalComercial'])){
			
			//$id_usuario = $_POST['id_usuario'];

			$grafica     = new Estadistica(Null);
			
			if($correcto = $grafica->fasComercial())
				echo json_encode($correcto);
			else
				throw new Exception( "509" );	

		}

	//}else{
	    
	  //  $_SESSION = array(); 
	   	//$_SESSION['timeExpired'] = true;
	
	//}

} catch(PHPException $ex) {
	echo 'Error cacheado PHP: '. $ex->getMessage();
   // Aquí llega cualquier otro tipo de Exception, veremos lo que hacemos
   // por norma general header 500 y página bonita
} catch(UsuarioException $ex) {
	echo 'Error cacheado Usuario: '. $ex->getMessage();
   // Informamos al equipo de desarrollo, pasando por ejemplo el print_debug_backtrace()
   // headers y enviar a alguna página de error "bonita"
} catch(DBException $ex) {
	echo 'Error cacheado DB '. $ex->getMessage();
   // Informamos al DB Admin via mail por ejemplo
   // headers y enviar a alguna página de error "bonita"
} catch(Exception $ex) {
	echo 'Error cacheado: '. $ex->getMessage();
   // Aquí llega cualquier otro tipo de Exception, veremos lo que hacemos
   // por norma general header 500 y página bonita
}

?>
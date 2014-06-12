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
// Creamos una exception especial
/*class PHPException extends Exception { }

// Deberíamos hacer que nuestra clase de BBDD en vez de lanzar Exceptions genéricas lance DBExceptions...
class DBException extends Exception { }

// Separamos las excepciones de código
set_error_handler('myErrorHandler');
function myErrorHandler($code, $error, $file = NULL, $line = NULL) {
	throw new PHPException($error . ' encontrado en '. $file.', línea '.$line);
}

try {
	session_start();
	$mysqli = new mysqli("qrw056.dbname.net", "qrw056", "Nosaba17", "qrw056"); 
	$mysqli->set_charset("utf8");
	// Todo el código que queramos instanciando N clases, con herencias y todo lo que queráis
	if(isset($_POST['login'])){
		$dni = $_POST['dni'];
		$password = $_POST['password'];
		$status = loginUsuario($dni,$password);
		if($_SESSION['inAdmin'] && $status){
			header("Location: ../portada/control.php");
			exit();
		}else if($_SESSION['inComercial'] && $status){
			header("Location: ../comercial/controlComercial.php");
			exit();
		}else{
			session_destroy();
			header("Location: ../login.php");
			exit();
		}
	}

	if($_SESSION['temper'] > time()){
		if(isset($_POST['peClientes'])){
			$clientesE = getClientesFactura();
			echo json_encode($clientesE);
		}
		elseif(isset($_POST['paClientes'])){
			$clientesA = getClientesAlbaran();
			echo json_encode($clientesA);
		}
		elseif(isset($_POST['getUsuarios'])){
			$usuarios = getUsuarios($_POST['id']);
			echo json_encode($usuarios);
		}		
		elseif(isset($_POST['categorias'])){
			$categorias = getCategorias();
			echo json_encode($categorias);
		}
		elseif(isset($_POST['tarifaP'])){
			$tarifa = getTarifaPlataforma();
			echo json_encode($tarifa);
		}	
		elseif(isset($_POST['formaPago'])){
			$formasP = getFormaspago();
			echo json_encode($formasP);
		}
		elseif(isset($_POST['selCategoria'])){ 
			$productos = getProductos();
			echo json_encode($productos);
		}
		elseif(isset($_POST['numeroAlbaran'])){
			$numAlbaran = getNumAlbaran();
			echo json_encode($numAlbaran);
		}
		elseif(isset($_POST['numeroFactura'])){
			$numFactura = getNumFactura();
			echo json_encode($numFactura);
		}
		elseif(isset($_POST['numeroRecibo'])){
			$numRecibo = getNumRecibo();
			echo json_encode($numRecibo);
		}
		elseif(isset($_POST['addAlbaran'])){
			$setA = setAlbaran();
			echo json_encode($setA);
		}				
		elseif(isset($_POST['addFactura'])){
			$setF = setFacturas();
			echo json_encode($setF);
		}
		elseif(isset($_POST['addRecibo'])){
			$setR = setRecibo();
			echo json_encode($setR);
		}
		elseif(isset($_POST['addCliente'])){
			$setC = setCliente();
			echo json_encode($setC);
		}
		elseif(isset($_POST['paginarMensajes'])){
			$numPag = paginarMensajes($_POST['id'],$_POST['page']);
			echo $numPag;
		}
		elseif(isset($_POST['getMensajes'])){
			$getMen = cargarMensajes($_POST['id'],$_POST['ini'],$_POST['fin']);
			echo json_encode($getMen);
		}
		elseif(isset($_POST['getMensajesSalida'])){
			$getMenS = cargarMensajesSalida($_POST['id'],$_POST['ini'],$_POST['fin']);
			echo json_encode($getMenS);
		}
		elseif(isset($_POST['getPapelera'])){
			$getMenP = cargarPapelera($_POST['id'],$_POST['ini'],$_POST['fin']);
			echo json_encode($getMenP);
		}		
		elseif(isset($_POST['getMensajesSinLeer'])){
			$getMenSin = cargarMensajesSinLeer($_POST['id']);
			echo $getMenSin;
		}
		elseif(isset($_POST['responderMensaje'])){
			$getMenR = responderMensaje($_POST['id_mensaje']);
			echo json_encode($getMenR);
		}		
		elseif(isset($_POST['updateMensaje'])){
			$upMen = updateMensaje($_POST['id']);
			echo $upMen;
		}
		elseif(isset($_POST['borrarMensaje'])){
			$supMen = borrarMensajes($_POST['id']);
			echo $supMen;
		}
		elseif(isset($_POST['sendMensaje'])){
			$sendM = enviarMensaje($_POST['id_destinatario'],$_POST['id_emisor'],$_POST['asunto'],$_POST['contenido']);
			echo $sendM;
		}
	}else{
	    $_SESSION = array(); 
	   	$_SESSION['timeExpired'] = true;
	}

} catch(PHPException $ex) {
	echo $ex->getMessage();
    throw new Exception($ex);
   // Informamos al equipo de desarrollo, pasando por ejemplo el print_debug_backtrace()
   // headers y enviar a alguna página de error "bonita"
} catch(DBException $ex) {
	echo $ex->getMessage();
    throw new Exception($ex);
   // Informamos al DB Admin via mail por ejemplo
   // headers y enviar a alguna página de error "bonita"
} catch(Exception $ex) {
    echo $ex->getMessage();
    throw new Exception($ex);
   // Aquí llega cualquier otro tipo de Exception, veremos lo que hacemos
   // por norma general header 500 y página bonita
}
	
	//Corregida
	function getClientesFactura(){
		global $mysqli;
		$query = "SELECT * from clientes c join formasPago f on c.cod_fp=f.cod_fp where f.dias=0";
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
				$clientes[] = $row;
			}
		}
		return $clientes;
	}
	//Corregida
	function getClientesAlbaran(){
		global $mysqli;
		$query = "select * from clientes c join formasPago f on c.cod_fp=f.cod_fp where f.dias>0";
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
				$clientes[] = $row;
			}
		}
		return $clientes;
	}
	//Corregida
	function getCategorias(){
		global $mysqli;
		$query = "select * from categorias";
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
				$categorias[] = $row;
			}
		}
		return $categorias;
	}
	//Corregida
	function getTarifaPlataforma(){
		global $mysqli;
		$query = "select * from tarifaPlataforma";
		if($consulta = $mysqli->query($query)){
			$tarifaP = $consulta->fetch_assoc();
		}
		return $tarifaP;
	}
	//Corregida
	function getFormaspago(){
		global $mysqli;
		$query = "select * from formasPago";
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
				$formaspago[] = $row;
			}
		}
		return $formaspago;
	}
	//Corregida
	function getNumAlbaran(){
		global $mysqli;
		$query = "select id_albaran from albaranes order by id_albaran desc limit 1";
		if($consulta = $mysqli->query($query)){
			$albaran = $consulta->fetch_assoc();
		}
		if(!$albaran){
			$albaran = array("id_albaran" => 0);
		}
		return $albaran;
	}
	//Corregida
	function getNumFactura(){
		global $mysqli;
		$query = "select id_factura from facturas order by id_factura desc limit 1";
		if($consulta = $mysqli->query($query)){
			$factura = $consulta->fetch_assoc();
		}
		if(!$factura){
			$factura = array("id_factura" => 0);
		}else{
			return $factura;
		}
	}
	//Corregida
	function getNumRecibo(){
		global $mysqli;
		$query = "select id_recibo from recibos order by id_recibo desc limit 1";
		if($consulta = $mysqli->query($query)){
			$recibo = $consulta->fetch_assoc();
		}
		if(!$recibo){
			$recibo = array("id_recibo" => 0);
		}else{
			return $recibo;
		}
	}
	//Corregida
	function getProductos(){
		global $mysqli;
		$general = "";
		$productos = "";
		$cliente = "";

		$cliente = $_POST['num_cliente'];
		$cod_categoria = $_POST['cod_categoria'];

		$query = "SELECT p.cod_producto,p.nom_producto,p.precio,p.stock,p.peso_gramos,p.unidades_caja,t.nom_tarifa,t.tarifa,t.especial,a.nom_categoria,a.cod_categoria,c.num_cliente,c.nombre 
		from productos p join tarifas t on 
		t.cod_producto = p.cod_producto join clientes c on 
		t.num_cliente = c.num_cliente join categorias a on 
		p.cod_categoria = a.cod_categoria 
		where c.num_cliente = $cliente and a.cod_categoria = $cod_categoria";
		if($consulta = $mysqli->query($query)){
			if($consulta->num_rows != 0){
				while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
					$general[] = $row;				
				}
			}else{
				$general = "";
			}
		}

		unset($query,$row);
		$query = "SELECT DISTINCT * FROM productos p WHERE NOT EXISTS (select * from tarifas t where p.cod_producto = t.cod_producto and t.num_cliente = $cliente) and p.cod_categoria = $cod_categoria";
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_array(MYSQLI_BOTH)) {
				$productos[] = $row;
			}
		}

		$resultado = array('0' => $general, '1' => $productos);

		return $resultado;
	}

	function setAlbaran(){
		global $mysqli;
		$json_data = $_POST['jsonFull'];
		$jsonPHP = json_decode($json_data,true);
	 	$fecha_exp = date("Y-n-j");
	 	$forma_de_pago = false;
		$query = "select f.dias,f.mesvencido from formasPago f join clientes c on f.cod_fp=c.cod_fp where num_cliente=".$jsonPHP[0]['numcliente']."";
		if($consulta = $mysqli->query($query)){
			$tipo = $consulta->fetch_assoc();
		}

		if($tipo['dias'] != 0 && $tipo['mesvencido'] == "no"){
			$mesvencido = false;		
		}elseif($tipo['dias'] != 0 && $tipo['mesvencido'] == "si"){
			$mesvencido = true;		
		}

		if(!$mesvencido){
			$fecha_ven = date("Y-n-j",mktime(0,0,0,date('n'),date('j')+$tipo['dias'],date('Y')));

			$query = "INSERT INTO albaranes (id_albaran, num_albaran, fecha_exp, fecha_ven, total_p, total_i, total_r, total_a, num_cliente,id_usuario) VALUES 
			(NULL, '".$jsonPHP[2]['num_albaran']."', '".$fecha_exp."', '".$fecha_ven."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."','".$_SESSION['id_usuario']."')";

			if($mysqli->query($query)){
				$_SESSION['ok_a'] = "Albaran guardado con exito.<br/>";
			}else{
				$_SESSION['error_a'] = "No se ha podido guardar el albaran. ".$mysqli->error()."<br/>";
			}

			$query = "select id_albaran from albaranes where num_albaran='".$jsonPHP[2]['num_albaran']."' and num_cliente='".$jsonPHP[0]['numcliente']."'";
			if($consulta = $mysqli->query($query)){
				$id_albaran = $consulta->fetch_assoc();
			}

			if(!$id_albaran){
				$id_albaran = array("id_albaran" => 0);
			}
			
			$contOk = 0;
			$contEr = 0;
			for($x=0;$x<count($jsonPHP[1]);$x++){
				$query = "INSERT INTO albaranesProductos (id, id_albaran, num_albaran, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
				(NULL, '".$id_albaran['id_albaran']."','".$jsonPHP[2]['num_albaran']."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
				if($mysqli->query($query)){
					$query = "SELECT stock FROM productos WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
					if($consulta = $mysqli->query($query)){
						$stock = $consulta->fetch_assoc();
					}
					$stockRestante = (intval($stock['stock']) - intval($jsonPHP[1][$x]['cantidad']));
					$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
					if($mysqli->query($query)){
						$contOk++;
						$_SESSION['ok_p_a'] = $contOk." Productos guardados con exito.<br/>";
					}else{
						$contEr++;
						$_SESSION['error_p_a'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";				
					}			
				}else{
					$contEr++;
					$_SESSION['error_p_a'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";			
				}
			}

			$query = "SELECT id_factura FROM facturas order by id_factura desc limit 1";
			if($consulta = $mysqli->query($query)){
				$id_factura = $consulta->fetch_assoc();
			}

			$id_factura = (intval($id_factura['id_factura'])+1);
			$num_factura = date("Y")."-".$id_factura;

			$query = "INSERT INTO facturas (id_factura, num_factura, fecha, total_p, total_i, total_r, total_f, num_cliente, id_albaran, num_albaran,id_usuario) VALUES 
			(NULL, '".$num_factura."', '".$fecha_ven."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."', '".$id_albaran['id_albaran']."','".$jsonPHP[2]['num_albaran']."','".$_SESSION['id_usuario']."')";
			if($mysqli->query($query)){
				$_SESSION['ok_f'] = "Factura guardada con exito.<br/>";
			}else{
				$_SESSION['error_f'] = "No se ha podido guardar el albaran. ".$mysqli->error()."<br/>";
			}

			$query = "select id_factura from facturas where num_factura='".$num_factura."' and num_cliente='".$jsonPHP[0]['numcliente']."'";
			if($consulta = $mysqli->query($query)){
				$id_factura = $consulta->fetch_assoc();
			}

			if(!$id_factura){
				$id_factura = array("id_factura" => 0);
			}

			$contOk = 0;
			$contEr = 0;
			for($x=0;$x<count($jsonPHP[1]);$x++){
				$query = "INSERT INTO facturasProductos (id, id_factura, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
				(NULL, '".$id_factura['id_factura']."','".$num_factura."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
				if($mysqli->query($query)){
					$contOk++;
					$_SESSION['ok_p_f'] = $contOk." Productos guardados con exito en factura.<br/>";					
				}else{
					$contEr++;
					$_SESSION['error_p_f'] = $contEr." Productos no se han podido guardar en factura. ".$mysqli->error()."<br/>";			
				}
			}
		}else{
			//Caso teorico
			//$fecha_act = date("Y-6-21");
			//$fecha_ven = date("Y-n-j",mktime(0,0,0,date('n')+1,date('20'),date('Y')));

			$fecha_act = date("Y-n-j");
			$fecha_ven = date("Y-n-j",mktime(0,0,0,date('n'),date($tipo['dias']),date('Y')));

			$fecha1 = new DateTime($fecha_act);
			$fecha2 = new DateTime($fecha_ven);

			if($fecha1 >= $fecha2){
				$fecha_ven = date("Y-n-j",mktime(0,0,0,date('n')+1,date($tipo['dias']),date('Y')));
			}

			$query = "INSERT INTO albaranes (id_albaran, num_albaran, fecha_exp, fecha_ven, total_p, total_i, total_r, total_a, num_cliente,id_usuario) VALUES 
			(NULL, '".$jsonPHP[2]['num_albaran']."', '".$fecha_exp."', '".$fecha_ven."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."','".$_SESSION['id_usuario']."')";

			if($mysqli->query($query)){
				$_SESSION['ok_a'] = "Albaran guardado con exito.<br/>";
			}else{
				$_SESSION['error_a'] = "No se ha podido guardar el albaran. ".$mysqli->error()."<br/>";
			}

			$query = "select id_albaran from albaranes where num_albaran='".$jsonPHP[2]['num_albaran']."' and num_cliente='".$jsonPHP[0]['numcliente']."'";
			if($consulta = $mysqli->query($query)){
				$id_albaran = $consulta->fetch_assoc();
			}

			if(!$id_albaran){
				$id_albaran = array("id_albaran" => 0);
			}
			
			$contOk = 0;
			$contEr = 0;
			for($x=0;$x<count($jsonPHP[1]);$x++){
				$query = "INSERT INTO albaranesProductos (id, id_albaran, num_albaran, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
				(NULL, '".$id_albaran['id_albaran']."','".$jsonPHP[2]['num_albaran']."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
				if($mysqli->query($query)){
					$query = "SELECT stock FROM productos WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
					if($consulta = $mysqli->query($query)){
						$stock = $consulta->fetch_assoc();
					}
					$stockRestante = (intval($stock['stock']) - intval($jsonPHP[1][$x]['cantidad']));
					$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
					if($mysqli->query($query)){
						$contOk++;
						$_SESSION['ok_p_a'] = $contOk." Productos guardados con exito.<br/>";
					}else{
						$contEr++;
						$_SESSION['error_p_a'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";				
					}			
				}else{
					$contEr++;
					$_SESSION['error_p_a'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";			
				}
			}

			$query = "SELECT id_factura,num_factura from facturas where fecha='".$fecha_ven."' and num_cliente=".$jsonPHP[0]['numcliente']."";
			$consulta = $mysqli->query($query);
			$id = $consulta->fetch_assoc();
			$result = $consulta->num_rows;

			if($result == 0){
				$query = "SELECT id_factura FROM facturas order by id_factura desc limit 1";
				if($consulta = $mysqli->query($query)){
					$id_factura = $consulta->fetch_assoc();
				}

				$id_factura = (intval($id_factura['id_factura'])+1);
				$num_factura = date("Y")."-".$id_factura;

				$query = "INSERT INTO facturas (id_factura, num_factura, fecha, total_p, total_i, total_r, total_f, num_cliente, id_albaran, num_albaran,id_usuario) VALUES 
				(NULL, '".$num_factura."', '".$fecha_ven."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."', NULL,NULL,'".$_SESSION['id_usuario']."')";
				if($mysqli->query($query)){
					$_SESSION['ok_f'] = "Factura guardada con exito.<br/>";
				}else{
					$_SESSION['error_f'] = "No se ha podido guardar el albaran. ".$mysqli->error()."<br/>";
				}

				$contOk = 0;
				$contEr = 0;
				for($x=0;$x<count($jsonPHP[1]);$x++){
					$query = "INSERT INTO facturasProductos (id, id_factura, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(NULL, '".$id_factura."','".$num_factura."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
					if($mysqli->query($query)){
						$contOk++;
						$_SESSION['ok_p_f'] = $contOk." Productos guardados con exito en factura.<br/>";					
					}else{
						$contEr++;
						$_SESSION['error_p_f'] = $contEr." Productos no se han podido guardar en factura. ".$mysqli->error()."<br/>";			
					}
				}
			}else{
				$query = "SELECT total_p, total_i, total_r, total_f FROM facturas where id_factura=".$id['id_factura']."";
				if($consulta = $mysqli->query($query)){
					$oldData = $consulta->fetch_assoc();
				}
				$total_p = $oldData['total_p'] + $jsonPHP[2]['total_p'];
				$total_i = $oldData['total_i'] + $jsonPHP[2]['total_i'];
				$total_r = $oldData['total_r'] + $jsonPHP[2]['total_r'];
				$total_f = $oldData['total_f'] + $jsonPHP[2]['total'];

				$query = "UPDATE facturas SET total_p=$total_p,total_i=$total_i,total_r=$total_r,total_f=$total_f WHERE id_factura=".$id['id_factura']."";
				if($mysqli->query($query)){
					$_SESSION['ok_f'] = "Factura actualizada con exito.<br/>";
				}else{
					$_SESSION['error_f'] = "No se ha podido actualizar la factura. ".$mysqli->error()."<br/>";
				}

				$contOk = 0;
				$contEr = 0;
				for($x=0;$x<count($jsonPHP[1]);$x++){
					$query = "INSERT INTO facturasProductos (id, id_factura, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
					(NULL, '".$id['id_factura']."','".$id['num_factura']."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
					if($mysqli->query($query)){
						$contOk++;
						$_SESSION['ok_p_f'] = $contOk." Productos guardados con exito en factura.<br/>";					
					}else{
						$contEr++;
						$_SESSION['error_p_f'] = $contEr." Productos no se han podido guardar en factura. ".$mysqli->error()."<br/>";			
					}
				}				
			}			
		}
		//DATOS EN SESSION
		$_SESSION['json'] = $jsonPHP;
		$ok = ['0' => 0];
		return $ok;
	}

	function setFacturas(){
		global $mysqli;
		$json_data = $_POST['jsonFull'];
		$jsonPHP = json_decode($json_data,true);
	 	$fecha = date("Y-n-j");

		$query = "INSERT INTO facturas (id_factura, num_factura, fecha, total_p, total_i, total_r, total_f, num_cliente, id_albaran, num_albaran, id_usuario) VALUES 
		(NULL, '".$jsonPHP[2]['num_factura']."', '".$fecha."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."', NULL, NULL,'".$_SESSION['id_usuario']."')";

		if($mysqli->query($query)){
			$_SESSION['ok_f'] = "Factura guardado con exito.<br/>";
		}else{
			$_SESSION['error_f'] = "No se ha podido guardar la factura. ".$mysqli->error()."<br/>";
		}

		$query = "select id_factura from facturas where num_factura='".$jsonPHP[2]['num_factura']."' and num_cliente='".$jsonPHP[0]['numcliente']."'";
		if($consulta = $mysqli->query($query)){
			$id_factura = $consulta->fetch_assoc();
		}

		if(!$id_factura){
			$id_factura = array("id_factura" => 0);
		}
		
		$contOk = 0;
		$contEr = 0;
		for($x=0;$x<count($jsonPHP[1]);$x++){
			$query = "INSERT INTO facturasProductos (id, id_factura, num_factura, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
			(NULL, '".$id_factura['id_factura']."','".$jsonPHP[2]['num_factura']."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
			if($mysqli->query($query)){
				$query = "SELECT stock FROM productos WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
				if($consulta = $mysqli->query($query)){
					$stock = $consulta->fetch_assoc();
				}
				$stockRestante = (intval($stock['stock']) - intval($jsonPHP[1][$x]['cantidad']));
				$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
				if($mysqli->query($query)){
					$contOk++;
					$_SESSION['ok_p_f'] = $contOk." Productos guardados con exito.<br/>";
				}else{
					$contEr++;
					$_SESSION['error_p_f'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";				
				}			
			}else{
				$contEr++;
				$_SESSION['error_p_f'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";			
			}
		}

		//DATOS EN SESSION
		$_SESSION['json'] = $jsonPHP;
		
		$ok = ['0' => 0];
		return $ok;
	}

	function setRecibo(){
		global $mysqli;
		$json_data = $_POST['jsonFull'];
		$jsonPHP = json_decode($json_data,true);
	 	$fecha = date("Y-n-j");

		$query = "INSERT INTO recibos (id_recibo, num_recibo, fecha, total_p, total_i, total_r, total_re, num_cliente, id_usuario) VALUES 
		(NULL, '".$jsonPHP[2]['num_recibo']."', '".$fecha."', '".$jsonPHP[2]['total_p']."', '".$jsonPHP[2]['total_i']."', '".$jsonPHP[2]['total_r']."', '".$jsonPHP[2]['total']."', '".$jsonPHP[0]['numcliente']."', '".$_SESSION['id_usuario']."')";

		if($mysqli->query($query)){
			$_SESSION['ok_r'] = "Recibo guardado con exito.<br/>";
		}else{
			$_SESSION['error_r'] = "No se ha podido guardar el recibo. ".$mysqli->error()."<br/>";
		}

		$query = "select id_recibo from recibos where num_recibo='".$jsonPHP[2]['num_recibo']."' and num_cliente='".$jsonPHP[0]['numcliente']."'";
		if($consulta = $mysqli->query($query)){
			$id_recibo = $consulta->fetch_assoc();
		}

		if(!$id_recibo){
			$id_recibo = array("id_recibo" => 0);
		}
		
		$contOk = 0;
		$contEr = 0;
		for($x=0;$x<count($jsonPHP[1]);$x++){
			$query = "INSERT INTO recibosProductos (id, id_recibo, num_recibo, cod_producto, cantidad, precio, dto, total_u, num_cliente) VALUES 
			(NULL,'".$id_recibo['id_recibo']."','".$jsonPHP[2]['num_recibo']."','".$jsonPHP[1][$x]['cod_producto']."', '".$jsonPHP[1][$x]['cantidad']."', '".$jsonPHP[1][$x]['precioUnitario']."', '".$jsonPHP[1][$x]['dto']."', '".$jsonPHP[1][$x]['totalUnitario']."', '".$jsonPHP[0]['numcliente']."')";	
			if($mysqli->query($query)){
				$query = "SELECT stock FROM productos WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
				if($consulta = $mysqli->query($query)){
					$stock = $consulta->fetch_assoc();
				}
				$stockRestante = (intval($stock['stock']) - intval($jsonPHP[1][$x]['cantidad']));
				$query = "UPDATE productos SET stock = '".$stockRestante."' WHERE cod_producto = '".$jsonPHP[1][$x]['cod_producto']."'";
				if($mysqli->query($query)){
					$contOk++;
					$_SESSION['ok_p_r'] = $contOk." Productos guardados con exito.<br/>";
				}else{
					$contEr++;
					$_SESSION['error_p_r'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";				
				}			
			}else{
				$contEr++;
				$_SESSION['error_p_r'] = $contEr." Productos no se han podido guardar. ".$mysqli->error()."<br/>";			
			}
		}

		//DATOS EN SESSION
		$_SESSION['json'] = $jsonPHP;
		
		$ok = ['0' => 0];
		return $ok;
	}

	function setCliente(){
		global $mysqli;
		$json_data = $_POST['jsonFull'];
		$jsonPHP = json_decode($json_data,true);

		$query = "INSERT INTO clientes (num_cliente,nombre,direccion,cp,localidad,nombre_contacto,telefono,movil,email,cod_fp ,cif ,recargo) 
		VALUES (NULL , '".$jsonPHP['nombre']."', '".$jsonPHP['direccion']."', '".$jsonPHP['cp']."', '".$jsonPHP['localidad']."', '".$jsonPHP['nombre_contacto']."', '".$jsonPHP['telefono']."', '".$jsonPHP['movil']."', '".$jsonPHP['email']."', '".$jsonPHP['formapago']."', '".$jsonPHP['cif']."', '".$jsonPHP['recargo']."')";

		if($mysqli->query($query)){
			$_SESSION['ok_c'] = "Nuevo cliente guardado con exito.<br/>";
		}else{
			$_SESSION['error_c'] = "No se ha podido guardar el nuevo cliente. ".$mysqli->error()."<br/>";
		}

		//DATOS EN SESSION
		$_SESSION['json'] = $jsonPHP;
		
		$ok = ['0' => 0];
		return $ok;
	}

	function getUsuarios($id){
		global $mysqli;
		$usuarios = "";
		$query = 'select id_usuario,nombre from usuarios where id_usuario!='.$id.'';
		if($consulta = $mysqli->query($query)){
			while ($row = $consulta->fetch_assoc()) {
				$usuarios[] = $row;
			}
		}
		return $usuarios;		
	}

	//Funcion de inicio de sesion
	function loginUsuario($dni,$password){	
		global $mysqli;
		$query = 'SELECT id_usuario,dni,nombre,password,tipo from usuarios where dni="'.$dni.'" and password="'.$password.'"';
		$consulta = $mysqli->query($query);
		//$resultados = $consulta->num_rows;
		if($consulta->num_rows != 0){
			$resultado = $consulta->fetch_assoc();
			$dni_db = $resultado['dni'];
			$nombre_db = $resultado['nombre'];
			$password_db = $resultado['password'];
			$tipo_db = $resultado['tipo'];
			if(strtolower($dni_db) === strtolower($dni) && $password_db === $password){
				$_SESSION['nombre'] = $resultado['nombre']; 
				$_SESSION['id_usuario'] = $resultado['id_usuario']; 
				if($tipo_db == 1){
					$_SESSION['temper'] = time()+23000;
					$_SESSION['inAdmin'] = true;
					$_SESSION['inComercial'] = false;
					return true;
				}else if($tipo_db == 2){
					$_SESSION['temper'] = time()+23000;
					$_SESSION['inComercial'] = true;
					$_SESSION['inAdmin'] = false;
					return true;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	//Funcion de inicio de sesion
	function paginarMensajes($id,$bandeja){	
		global $mysqli;
		$mensajes = null;
		if($bandeja == "1"){
			$query = 'SELECT * from mensajes where id_destinatario="'.$id.'" and (estado="P" or estado="L")';
		}elseif($bandeja == "2"){
			$query = 'SELECT * from mensajes where id_emisor="'.$id.'" and (estado="P" or estado="L")';
		}else{
			$query = 'SELECT * from mensajes where (id_destinatario="'.$id.'" or id_emisor="'.$id.'") and estado="B"';
		}
		$consulta = $mysqli->query($query);
		$numero = $consulta->num_rows;
		$paginas = $numero/10;
		$paginas =ceil($paginas);
		return $paginas;
	}

	function enviarMensaje($dest,$emis,$asunto,$contenido){
		global $mysqli;
		$query = 'INSERT INTO mensajes (id_mensaje, id_destinatario, id_emisor, asunto, contenido, estado, fecha) 
		VALUES (NULL, '.$dest.', '.$emis.', "'.$asunto.'", "'.nl2br($contenido).'", "P", "'.date("Y-n-j").'")';
		if($mysqli->query($query)){
			return true;
		}else{
			return false;
		}
	}

	//Funcion de inicio de sesion
	function cargarMensajes($id_destinatario,$ini,$fin){	
		global $mysqli;
		$mensajes = null;
		$query = 'SELECT m.id_mensaje,m.id_destinatario,m.id_emisor,m.asunto,m.contenido,m.estado,m.fecha,u.nombre from mensajes m join usuarios u on m.id_emisor=u.id_usuario where id_destinatario="'.$id_destinatario.'" and (estado="P" or estado="L") order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		$consulta = $mysqli->query($query);
		while($row = $consulta->fetch_assoc()){
			$mensajes[] = $row;
		}
		return $mensajes;
	}

	//Funcion de inicio de sesion
	function cargarMensajesSalida($id_emisor,$ini,$fin){	
		global $mysqli;
		$mensajes = null;
		$query = 'SELECT m.id_mensaje,m.id_destinatario,m.id_emisor,m.asunto,m.contenido,m.estado,m.fecha,u.nombre from mensajes m join usuarios u on m.id_destinatario=u.id_usuario where id_emisor="'.$id_emisor.'" and (estado="P" or estado="L") order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		$consulta = $mysqli->query($query);
		while($row = $consulta->fetch_assoc()){
			$mensajes[] = $row;
		}
		return $mensajes;
	}

	//Funcion de inicio de sesion
	function cargarPapelera($id,$ini,$fin){	
		global $mysqli;
		$mensajes = null;
		$query = 'SELECT * from mensajes where (id_destinatario="'.$id.'" or id_emisor="'.$id.'") and estado="B" order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		$consulta = $mysqli->query($query);
		while($row = $consulta->fetch_assoc()){
			$mensajes[] = $row;
		}
		return $mensajes;
	}

	//Funcion de inicio de sesion
	function cargarMensajesSinLeer($id_destinatario){	
		global $mysqli;
		$mensajesSinleer = null;
		$query = 'SELECT * from mensajes where id_destinatario="'.$id_destinatario.'" and estado="P"';
		$consulta = $mysqli->query($query);
		$mensajesSinleer = $consulta->num_rows;
		return $mensajesSinleer;
	}

	//Funcion de inicio de sesion
	function responderMensaje($id_mensaje){	
		global $mysqli;
		$resMensaje = null;
		$query = 'SELECT * from mensajes where id_mensaje="'.$id_mensaje.'"';
		$consulta = $mysqli->query($query);
		$resMensaje = $consulta->fetch_assoc();

		$query = 'SELECT nombre from usuarios where id_usuario="'.$resMensaje['id_emisor'].'"';
		$consulta = $mysqli->query($query);
		$destR = $consulta->fetch_assoc();

		$resMen = ['nombre'=>$destR['nombre'],
		           'asunto'=>$resMensaje['asunto'],
		           'contenido'=>$resMensaje['contenido'],
		           'estado'=>$resMensaje['estado'],
		           'fecha'=>$resMensaje['fecha'],
		           'id_destinatario'=>$resMensaje['id_destinatario'],
		           'id_emisor'=>$resMensaje['id_emisor'],
		           'id_mensaje'=>$resMensaje['id_mensaje']
		          ];
		return $resMen;
	}

	//Funcion de inicio de sesion
	function updateMensaje($id_mensaje){
		global $mysqli;
		$query = 'UPDATE mensajes SET estado="L" where id_mensaje="'.$id_mensaje.'"';
		if($consulta = $mysqli->query($query)){
			return true;
		}else{
			return false;
		}
	}

	//Funcion de inicio de sesion
	function borrarMensajes($id_mensaje){
		global $mysqli;
		$query = 'UPDATE mensajes SET estado="B" where id_mensaje="'.$id_mensaje.'"';
		if($consulta = $mysqli->query($query)){
			return true;
		}else{
			return false;
		}
	}*/
?>
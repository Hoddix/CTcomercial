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

class Mensaje extends Conexion{
	
	//DECLARAMOS LAS VARIABLES
	private $jsonPHP;

	//DECLARAMOS EL CONSTRUCTOR
	function __construct($strJson){
		//OBTENEMOS LOS CONSTRUCTORES PADRES
		parent::__construct();
		//INICIALIZAMOS LA VARIABLE
		$this->jsonPHP = json_decode($strJson,true);

	}

	//FUNCION QUE MANDA EL MENSAJE // Revisada
	function sendMessage(){
		//CONSULTA PARA INSTRODUCIR LOS DATOS DE UN NUEVO MENSAJE EN LA DB
		$query = "INSERT INTO mensajes (id_mensaje, id_destinatario, id_emisor, asunto, contenido, estado, fecha) VALUES 
		(
			NULL, 
			'".$this->jsonPHP['id_destinatario']."', 
			'".$this->jsonPHP['id_emisor']."', 
			'".$this->jsonPHP['asunto']."', 
			'".nl2br($this->jsonPHP['contenido'])."', 
			'P', 
			'".date("Y-n-j")."'
		)";
		
		//HACEMOS LA CONSULTA
		if($this->conectar->query($query)) return true;

		else throw new DBException( "Problema al enviar mensaje. Consulta mal realizada" );

	}

	//FUNCION PARA LA BANDEJA DE ENTRADA // Revisada
	function inBox($id_destinatario,$ini,$fin){	

		$mensajes = null;

		//CONSULTA QUE CARGA LOS MENSAJES DE LA BANDEJA DE ENTRADA
		$query = 'SELECT m.id_mensaje,m.id_destinatario,m.id_emisor,m.asunto,m.contenido,m.estado,m.fecha,u.nombre 
		from mensajes m join usuarios u on m.id_emisor=u.id_usuario 
		where id_destinatario="'.$id_destinatario.'" and (estado="P" or estado="L") 
		order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			
			//LEEMEOS LINEA A LINEA Y OBTENEMOS LOS DATOS
			while($row = $consulta->fetch_assoc()){
			
				$mensajes[] = $row;
			
			}
			//RETORNAMOS LOS MENSJAES DE LA BANDEJA DE ENTRADA
			return $mensajes;
		
		}else
			throw new DBException( "Problema en bandeja de entrada. Consulta mal realizada" );
	
	}

	//FUNCION PARA LA BANDEJA DE SALIDA // Revisada
	function outBox($id_emisor,$ini,$fin){	
			
		$mensajes = null;
		
		//CONSULTA QUE CAGRA LOS MENSAJES ENVIADOS
		$query = 'SELECT m.id_mensaje,m.id_destinatario,m.id_emisor,m.asunto,m.contenido,m.estado,m.fecha,u.nombre 
		from mensajes m join usuarios u on m.id_destinatario=u.id_usuario 
		where id_emisor="'.$id_emisor.'" and (estado="P" or estado="L") 
		order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			
			//LEEMOS LINEA A LINEA Y OBKTENEMOS LOS DATOS
			while($row = $consulta->fetch_assoc()){
			
				$mensajes[] = $row;
			
			}
			
			//RETORNAMOS LOS MENSAJES
			return $mensajes;
		
		}else
			throw new DBException( "Problema en bandeja de salida. Consulta mal realizada" );
	
	}

	//FUNCION PARA LA PAPELERA // Revisada
	function bin($id,$ini,$fin){

		$mensajes = null;

		//CONSULTA QUE CARGA LOS MENSAJES QUE ESTAN EN LA PAPELERA
		$query = 'SELECT * 
		from mensajes 
		where (id_destinatario="'.$id.'" or id_emisor="'.$id.'") and estado="B" 
		order by estado desc,id_mensaje desc,fecha desc limit '.$ini.','.$fin.'';
		
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			
			//LEEMOS LINEA A LINEA Y OBKTENEMOS LOS DATOS
			while($row = $consulta->fetch_assoc()){
			
				$mensajes[] = $row;
			
			}
			
			//RETORNAMOS LOS MENSAJES
			return $mensajes;
		
		}else
			throw new DBException( "Problema en la papelera. Consulta mal realizada" );
	
	}

	//FUNCION QUE SE ENCARGA DE PAGINAR // Resivsada
	function pagination($id,$bandeja){	

		$paginas = null;

		//NUMERO DE PAGINAS SEGUN LA BANDEJA O PAPELERA
		switch ($bandeja) {
			case '1':
				$query = 'SELECT * from mensajes where id_destinatario="'.$id.'" and (estado="P" or estado="L")';
				break;
			case '2':
				$query = 'SELECT * from mensajes where id_emisor="'.$id.'" and (estado="P" or estado="L")';
				break;
			case '3':
				$query = 'SELECT * from mensajes where (id_destinatario="'.$id.'" or id_emisor="'.$id.'") and estado="B"';
				break;
		}

		//HACEMOSLA PETICION
		if($consulta = $this->conectar->query($query)){
			//OBTENEMOS EL NUMERO DE FILAS Y CALCULAMOS LAS PAGINAS
			$numero 	= $consulta->num_rows;
			$paginas 	= $numero/10;
			$paginas 	= ceil($paginas);
			
			//RETORNAMOS EL NUMERO DE PAGINAS
			return $paginas;	

		}else
			throw new DBException( "Problema en el paginador. Consulta mal realizada" );

	}

	//FUNCION QUE NOS DICE CUANTOS MENSAJES TENEMOS SIN LEER
	function unRead($id_destinatario){	//revisada
		
		$sinleer = null;

		//CONSULTA QUE BUSCA MENSAJES SIN LEER
		$query = 'SELECT * from mensajes where id_destinatario="'.$id_destinatario.'" and estado="P"';
		
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			//OBTENEMOS EL NUMERO DE MENSAJES SIN LEER
			$sinleer = $consulta->num_rows;
			//RETORNAMOS EL NUMERO DE MENSAJES SIN LEER
			return $sinleer;
		
		}else
			throw new DBException( "Problema al cargar el numero de mensajes. Consulta mal realizada" );

	}

	//FUNCION PARA REEVIAR MENSAJES
	function reMessage($id_mensaje){ //revisada

		$resMen = null;

		//CONSULTA PARA OBTENER EL MENSAJE A RESPONDER
		$query = 'SELECT * from mensajes where id_mensaje="'.$id_mensaje.'"';
		
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query)){
			
			//SACAMOS LOS DATOS
			$resMensaje = $consulta->fetch_assoc();
			//PEQUEÑA CONSULTA PARA OBTENER EL NOMBRE DEL DESTINATARIO
			$query 		= 'SELECT nombre from usuarios where id_usuario="'.$resMensaje['id_emisor'].'"';
			//HACEMOS LA PETICION
			if($consulta = $this->conectar->query($query)){
				//SACAMOS LOS DATOS
				$destR  = $consulta->fetch_assoc();
				//CREAMOS UN ARRAY PARA INTRODUCIR EL NOMBRE DEL DESTINATARIO
				$resMen = [
					'nombre' 			=> $destR['nombre'],
		          	'asunto' 			=> $resMensaje['asunto'],
		          	'contenido' 		=> $resMensaje['contenido'],
		          	'estado' 			=> $resMensaje['estado'],
		           	'fecha'			 	=> $resMensaje['fecha'],
		           	'id_destinatario' 	=> $resMensaje['id_destinatario'],
		           	'id_emisor' 		=> $resMensaje['id_emisor'],
		           	'id_mensaje' 		=> $resMensaje['id_mensaje']
			    ];
			    //RETORNAMOS TODO EL MENSAJE
				return $resMen;

			}else
				throw new DBException( "Problema al responder el mensaje. Consulta mal realizada" );
	
		}else
			throw new DBException( "Problema al responder el mensaje. Consulta mal realizada" );	
	
	}

	//FUNCION PARA MARCAR UN MENSAJE COMO LEIDO
	function readMessage($id_mensaje){ //revisada

		//CONSULTA QUE CAMBIA EL MENSAJE A LEIDO
		$query = 'UPDATE mensajes SET estado="L" where id_mensaje="'.$id_mensaje.'"';
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query))
			return true;
		
		else
			throw new DBException( "Problema al leer el mensaje. Consulta mal realizada" );
	
	}

	//FUNCION PARA MANDAR EL MENSAJE EN LA PAPELERA
	function send2TheBin($id_mensaje){ //revisada
		
		//CONSULTA PARA CAMBIAR EL ESTADO DEL MENSAJE A LA PAPELERA
		$query = 'UPDATE mensajes SET estado="B" where id_mensaje="'.$id_mensaje.'"';
		//HACEMOS LA PETICION
		if($consulta = $this->conectar->query($query))
			return true;
		
		else
			throw new DBException( "Problema al mandar el mensaje a la papelera. Consulta mal realizada" );
	
	}
	
}

?>
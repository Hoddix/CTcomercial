<?php 

include_once('class.conexion.php');

class Estadistica extends Conexion{

	private $jsonFull;

	function __construct($strJson){
		parent::__construct();

		$this->jsonFull = json_decode($strJson,true);
	}


	function facturacionMensual(){

		$estadisticas = "";
		$query = 'SELECT {fn week(fecha)},sum(total_f) as total 
				  from facturas 
				  Where {fn year(fecha)}='.date("Y").' group by {fn week(fecha)}';
		
		/*$query = 'SELECT mes, sum(total) as total
				  from (
				  SELECT month(r.fecha) as mes,sum(r.total_re) as total 
				  FROM recibos r 
    			  group by mes 
				  union 
				  SELECT month(f.fecha) as mes,sum(f.total_f) as total 
				  FROM facturas f 
				  group by mes
				  ) as resultados
				  group by mes';*/

		if($consulta = $this->conectar->query($query)){

			while($row = $consulta->fetch_assoc()){

				$estadisticas[] = $row;

			}

			return $estadisticas;

		}else{

			return $estadisticas;

		}

	}

	function fasComercial(){

		$estadisticas = "";

		$query = 'SELECT id_usuario,nombre from usuarios';

		if($consulta = $this->conectar->query($query)){

			while($row = $consulta->fetch_assoc()){

				$usuarios[] = $row;

			}
		}

		for($x=0;$x<count($usuarios);$x++){

			$estadisticas=[];
			
			$query = 'SELECT {fn week(fecha)} as semana,sum(total_f) as total 
					  from facturas
					  Where {fn year(fecha)}='.date("Y").' and id_usuario="'.$usuarios[$x]['id_usuario'].'" group by {fn week(fecha)}';

			if($consulta = $this->conectar->query($query)){

				while($row = $consulta->fetch_assoc()){

					$estadisticas[] = $row;

				}

				$datosTotales[] = [$usuarios[$x],$estadisticas];
				unset($estadisticas);
			}

		}

		return [$datosTotales];		

	}


}

?>
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
//session_start();

//if($_SESSION['temper'] > time()){
  //  if(isset($_SESSION['temper']) && isset($_SESSION['inAdmin'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../Flat-UI-master/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Flat-UI-master/bootstrap-select/bootstrap-select.css" rel="stylesheet">
    <!-- Loading Flat UI -->
    <link href="../Flat-UI-master/css/flat-ui.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Loading mis estilos -->
    <link href="../css/estilos.css" rel="stylesheet">

</head>
<body>
	<header>
		<div id="barra_sup">
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
		      <span class="sr-only">Toggle navigation</span>
		    </button>
			<div class="col-md-12"><h4><a class="inicio" href="control.php">CTComercial</a></h4></div>	
		  </div>
		  <div class="collapse navbar-collapse" id="navbar-collapse-01">      
		    	<div class="navbar-right"> 
            		<ul class="nav navbar-nav">
                		<li>
                    		<a href="bandeja.php" id="alertamensajes">
                    		</a>
                		</li>
            		</ul>     
            	</div>
				<ul class="nav navbar-nav visible-xs">
					<li><a class="padre" href="#">Clientes</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Añadir cliente</a></li>
							<li><a class="" href="#">Modificar cliente</a></li>
							<li><a class="" href="#">Eliminar cliente</a></li>
						</ul>
					</li>
					<li><a class="padre" href="#">Albaranes</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Añadir albaran</a></li>
							<li><a class="" href="#">Consultar albaranes</a></li>
							<li><a class="" href="#">Eliminar albaran</a></li>
						</ul>
					</li>
					<li><a class="padre" href="#">Facturas</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Crear factura</a></li>
							<li><a class="" href="#">Consultar facturas</a></li>
							<li><a class="" href="#">Eliminar factura</a></li>
						</ul>
					</li>
					<li><a class="padre" href="#">Recibos</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Crear recibo</a></li>
							<li><a class="" href="#">Consultar recibos</a></li>
							<li><a class="" href="#">Eliminar recibo</a></li>
						</ul>
					</li>
					<li><a class="padre" href="#">Stockage</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Ver stockage</a></li>
							<li><a class="" href="#">Modificar stockage</a></li>
						</ul>				
					</li>
					<li><a class="padre" href="#">Pedidos</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Realizar pedido</a></li>
							<li><a class="" href="#">Estado del pedido</a></li>
							<li><a class="" href="#">Ver pedidos</a></li>
						</ul>				
					</li>
					<li><a class="padre" href="#">Tarifas</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Añadir tarifa</a></li>
							<li><a class="" href="#">Modificar tarifa</a></li>
							<li><a class="" href="#">Eliminar tarifa</a></li>
						</ul>				
					</li>
					<li><a class="padre" href="#">Estadisticas</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="#">Ver estadisticas</a></li>
							<li><a class="" href="#">Impirmir estadisticas</a></li>
							<li><a class="" href="#">Resetear estadisticas</a></li>
						</ul>				
					</li>
					<li><a class="padre" href="#">Empleados</a>
						<ul class="sub_ul_lat_nav">
							<li><a class="" href="nuevoUsuario.php">Añadir empleado</a></li>
							<li><a class="" href="#">Mostrar empleados</a></li>
							<li><a class="" href="#">Eliminar empleados</a></li>
						</ul>				
					</li>							
				</ul>
			
			<div class="navbar-text navbar-right btn-group">
				<span id="sesion" data-id="<?php echo $_SESSION['id_usuario']; ?>">Sesion iniciada como </span><a class="dropdown-toggle navbar-link" data-toggle="dropdown" href="#">
                <?php echo $_SESSION['nombre']; ?>
                </a>
				<ul class="dropdown-menu dropdown-inverse" role="menu">
				<li><a href="#">Mis ventas</a></li>
				<li><a href="#">Ruta del dia</a></li>
				<li><a href="#">Facturas pendientes</a></li>
				<li class="divider"></li>
				<li><a href="#">Cerrar sesion</a></li>
				</ul>
			</div>
		    <form class="navbar-form navbar-right" action="#" role="search">
		      <div class="form-group">
		        <div class="input-group">
		          <input class="form-control" id="navbarInput-01" type="search" placeholder="Search">
		          <span class="input-group-btn">
		            <button type="submit" class="btn"><span class="fui-search"></span></button>
		          </span>            
		        </div>
		      </div>               
		    </form>
		  </div><!-- /.navbar-collapse -->
		</nav><!-- /navbar -->
	</div>	
	</header>
	<section>
		<div class="col-md-2" id="lat_nav">
		<nav>
	        <div class="collapse navbar-collapse zero">
				<ul class="ul_lat_nav">
					<li><a class="btn_li padre" href="#">Clientes</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="addCliente.php">Añadir cliente</a></li>
							<li><a class="sub_btn_li" href="#">Modificar cliente</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar cliente</a></li>
						</ul>
					</li>
					<li><a class="btn_li padre" href="#">Albaranes</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="addAlbaran.php">Añadir albaran</a></li>
							<li><a class="sub_btn_li" href="#">Consultar albaranes</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar albaran</a></li>
						</ul>
					</li>
					<li><a class="btn_li padre" href="#">Facturas</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="addFactura.php">Crear factura</a></li>
							<li><a class="sub_btn_li" href="#">Consultar facturas</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar factura</a></li>
						</ul>
					</li>
					<li><a class="btn_li padre" href="#">Recibos</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="#">Crear recibo</a></li>
							<li><a class="sub_btn_li" href="#">Consultar recibos</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar recibo</a></li>
						</ul>
					</li>
					<li><a class="btn_li padre" href="#">Stockage</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="#">Ver stockage</a></li>
							<li><a class="sub_btn_li" href="#">Modificar stockage</a></li>
						</ul>				
					</li>
					<li><a class="btn_li padre" href="#">Pedidos</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="#">Realizar pedido</a></li>
							<li><a class="sub_btn_li" href="#">Estado del pedido</a></li>
							<li><a class="sub_btn_li" href="#">Ver pedidos</a></li>
						</ul>				
					</li>
					<li><a class="btn_li padre" href="#">Tarifas</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="#">Añadir tarifa</a></li>
							<li><a class="sub_btn_li" href="#">Modificar tarifa</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar tarifa</a></li>
						</ul>				
					</li>
					<li><a class="btn_li padre" href="#">Estadisticas</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="#">Ver estadisticas</a></li>
							<li><a class="sub_btn_li" href="#">Impirmir estadisticas</a></li>
							<li><a class="sub_btn_li" href="#">Resetear estadisticas</a></li>
						</ul>				
					</li>
					<li><a class="btn_li padre" href="#">Empleados</a>
						<div class="seleccion"></div>
						<ul class="sub_ul_lat_nav">
							<li><a class="sub_btn_li" href="nuevoUsuario.php">Añadir empleado</a></li>
							<li><a class="sub_btn_li" href="#">Mostrar empleados</a></li>
							<li><a class="sub_btn_li" href="#">Eliminar empleados</a></li>
						</ul>				
					</li>						
				</ul>
			</div>
		</nav>
	</div>
	</section>
	<section>
		<div class="col-md-10 col-md-offset-2" id="conten">
			<div id="content"></div>
			<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		</div>
	</section>
	    <!-- Load JS here for greater good =============================-->
	    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	    <script src="../Flat-UI-master/js/jquery-ui-1.10.3.custom.min.js"></script>
	    <script src="../Flat-UI-master/js/jquery.ui.touch-punch.min.js"></script>
	    <script src="../Flat-UI-master/js/bootstrap.min.js"></script>
	    <script src="../Flat-UI-master/js/bootstrap-select.js"></script>
	    <script src="../Flat-UI-master/js/bootstrap-switch.js"></script>
	    <script src="../Flat-UI-master/js/flatui-checkbox.js"></script>
	    <script src="../Flat-UI-master/js/flatui-radio.js"></script>
	    <script src="../Flat-UI-master/js/jquery.tagsinput.js"></script>
	    <script src="../Flat-UI-master/js/jquery.placeholder.js"></script>
	    
	    <script type="text/javascript" src="../js/jquery.autocomplete.min.js"></script>
	    <script type="text/javascript" src="../js/loaders.js"></script>
	    <script type="text/javascript" src="../js/comunes.js"></script>
	    <script type="text/javascript" src="../js/validacion.js"></script>

		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>


	    <script type="text/javascript">
	    /*    $( document ).ready(function() {
				loader.cargando("Cargando gráfico");

	        	$.post('../php/class.php',
	        		{
	        			semanalComercial : 'semanalComercial'
	        		},
	        		function(res){
	        			console.log (res)

						var _series = new Array();
						var series_ = new Array(); 
	        			var semanas = new Array();

     					for(var i=0; i<res[0].length; i++){

							for(var z=0; z<53; z++){
     							
     							for(var x=0; x<res[0][i][1].length; x++){

			     					if(res[0][i][1][x].semana == z){
			     						semanas[z] = parseInt(res[0][i][1][x].total);
			     						break;

			     					}else{
			     						semanas[z] = 0;
			     					}

     							}

     						}

							series_[i] = {name: res[0][i][0].nombre,data: semanas};
							semanas=[];

     					}
	     				
	     				for(var y=0;y<series_.length;y++){
	     					_series[y] = series_[y];
	     				}

						var titulo_ = {text: 'Facturacion semanal por comercial',x: -20};
						var subtitle_ = {text: 'Referencia: '+location.host,x: -20};

						console.log(_series)
						loader.quitarPeque();
				        $('#container').highcharts({
				            title: titulo_,
				            subtitle: subtitle_,
				            xAxis: {
				                categories: ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18',
				                '19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37',
				                '38','39','40','41','42','43','44','45','46','47','48','49','50','51','52']
				            },
				            yAxis: {
				                title: {
				                    text: 'Euros'
				                },
				                plotLines: [{
				                    value: 0,
				                    width: 1,
				                    color: '#808080'
				                }]
				            },
				            tooltip: {
				                valueSuffix: '€'
				            },
				            legend: {
				                layout: 'vertical',
				                align: 'right',
				                verticalAlign: 'middle',
				                borderWidth: 0
				            },
				            //Comercial
				            series: _series
				        });
	        		}
	        	,"json");
					

	            $("select").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown-inverse'});
	            $('input:text').on('blur',function(){
	              $(this).validation();  
	            });
				comun.subMenu();
	        });*/
	    </script>
</body>
</html>
<?php 
    //    }
  //  }else{ 
        //error_reporting(E_ALL); 
        //ini_set('display_errors', 'On');
      //  $_SESSION = array(); 
       // $_SESSION['timeExpired'] = true;
       // header("Location: ../login.php");
    //}
?>
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
session_start();

if($_SESSION['temper'] > time()){
    if(isset($_SESSION['temper']) && isset($_SESSION['inComercial'])){

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CTC 1.0 - Comercial Tablet Control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../Flat-UI-master/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Flat-UI-master/bootstrap-select/bootstrap-select.css" rel="stylesheet">
    <!-- Loading Flat UI -->
    <link href="../Flat-UI-master/css/flat-ui.css" rel="stylesheet">
    <link href="../css/tagsStyle.css" rel="stylesheet" type="text/css" media="all" >

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Loading mis estilos -->
    <link href="../css/estilos.css" rel="stylesheet">

</head>
<body>
	<div class="container-fluid">
	    <header id="albaran">
	        <nav class="navbar navbar-inverse" role="navigation">
	          <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
	              <span class="sr-only">Toggle navigation</span>
	            </button>
	            <a class="navbar-brand" href="controlComercial.php">CTComercial</a>
	          </div>
	          <div class="collapse navbar-collapse" id="navbar-collapse-01">      
	            <ul class="nav navbar-nav">           
	              	<li><a href="albaranFinal.php">CREAR ALBARAN</a></li>
					<li><a href="facturaFinal.php">CREAR FACTURA</a></li>	              
					<li><a href="reciboFinal.php">CREAR RECIBO</a></li>
	              	<li><a href="clienteFinal.php">AÑADIR CLIENTE</a></li>
	            </ul>        
	            <div class="navbar-right">   
	            <ul class="nav navbar-nav">
	                <li>
	                    <a href="bandeja.php" id="alertamensajes">

	                    </a>
	                </li>
	            </ul>    
	            </div>   
	            <div class="navbar-text navbar-right btn-group">
	                <span id="sesion" data-id="<?php echo $_SESSION['id_usuario']; ?>">Sesion iniciada como </span><a class="dropdown-toggle navbar-link" data-toggle="dropdown" href="#">
	                <?php echo $_SESSION['nombre']; ?>
	                </a>
	                <ul class="dropdown-menu dropdown-inverse" id="no_top" role="menu">
	                <li><a href="#">Mis ventas</a></li>
	                <li><a href="#">Ruta del dia</a></li>
	                <li><a href="#">Facturas pendientes</a></li>
	                <li class="divider"></li>
	                <li><a href="../login.php">Cerrar sesion</a></li>
	                </ul>
	            </div>
	          </div><!-- /.navbar-collapse -->
	        </nav><!-- /navbar -->
	    </header>
	    <section>
	        <div class="row" id="resume_general">
	            <div class="col-md-4 col-md-offset-4" id="reporte">
		  			<div id='resumen'>
						<div id='cerrarV'><h6>x</h6></div>
						<p>Resumen</p>
						<small><?php if(isset($_SESSION['error_a'])) {echo $_SESSION['error_a'];}else{ echo $_SESSION['ok_a']; } ?></small>
						<small><?php if(isset($_SESSION['ok_a'])) {echo $_SESSION['ok_p_a']; echo $_SESSION['error_p_a']; } ?></small>
						<small><?php if(isset($_SESSION['error_f'])) { echo $_SESSION['error_f']; }else{ echo $_SESSION['ok_f']; } ?></small>
						<small><?php if(isset($_SESSION['ok_f'])) { echo $_SESSION['ok_p_f']; echo $_SESSION['error_p_f']; } ?></small>
						<small><?php if(isset($_SESSION['error_r'])) {echo $_SESSION['error_r'];}else{ echo $_SESSION['ok_r']; } ?></small>
						<small><?php if(isset($_SESSION['ok_r'])) {echo $_SESSION['ok_p_r']; echo $_SESSION['error_p_r']; } ?></small>
					</div>  
	            </div>
	        </div>
			<div class="col-md-4 col-md-offset-4 col-xs-12" id="titulo_pagina">
	            <?php 
	            	if(isset($_SESSION['json'][2]['num_factura'])){
	            		$tipo = "DE FACTURA";
	            	}elseif(isset($_SESSION['json'][2]['num_albaran'])){
	            		$tipo = "DE ALBARAN";
	            	}else{
	            		$tipo = "DE RECIBO";
	            	}

	            ?>
	            <h3>RESUMEN <?php echo $tipo; ?></h3>
	        </div>
			<div class="col-md-12" id="contenido">
				<div class="row">
		            <div class="col-xs-12 col-md-4 col-md-offset-2 datos">
		                <p class="resumen"><span class="fui-user">&nbsp;</span>Cliente: <span class="over_name"><?php echo $_SESSION['json'][0]['cliente']; ?></span></p>
		                <p class="resumen"><span class="fui-location">&nbsp;</span>Direccion: <span class="over_name"><?php echo $_SESSION['json'][0]['direccion']; ?></span></p>
		                <p class="resumen"><span class="fui-radio-checked">&nbsp;</span>Localidad: <span class="over_name"><?php echo $_SESSION['json'][0]['cp'] .', '. $_SESSION['json'][0]['localidad']; ?></span></p>
		                <p class="resumen"><span class="fui-lock">&nbsp;</span>CIF: <span class="over_name"><?php echo $_SESSION['json'][0]['cif']; ?></span></p>
		            </div>
		            <div class="col-xs-12 col-md-4  col-md-offset-2 datos">
		                <p class="resumen"><span class="fui-calendar-solid">&nbsp; </span>Fecha: <span class="over_name"><?php echo date("d-n-Y"); ?></span></p>
		                <p class="resumen"><span class="fui-new">&nbsp;</span>
		                <?php 
		                	if(isset($_SESSION['json'][2]['num_factura'])){
		                		echo 'Nº Factura: ';
		                	}elseif(isset($_SESSION['json'][2]['num_albaran'])){
		                		echo 'Nº Albaran: ';
		                	}else{
		                		echo 'Nº Recibo: ';
		                	}
		                ?>
						<span class="over_name">
		                <?php 
		                	if(isset($_SESSION['json'][2]['num_factura'])){
		                		echo $_SESSION['json'][2]['num_factura'];
		                	}elseif(isset($_SESSION['json'][2]['num_albaran'])){
		                		echo $_SESSION['json'][2]['num_albaran'];
		                	}else{
		                		echo $_SESSION['json'][2]['num_recibo'];
		                	}
		                ?>
		            	</span>
		                </p>
		                <p class="resumen"><span class="fui-user">&nbsp; </span>Nº Cliente: <span class="over_name"><?php echo $_SESSION['json'][0]['numcliente']; ?></span></p>
		                <p class="resumen"><span class="fui-check">&nbsp; </span>Total: <span class="over_name"><?php echo $_SESSION['json'][2]['total']." €"; ?></span></p>
		            </div>			
				</div>

	            <div class="table-responsive" id="tabla">
					<table class="table">
						<tr>
							<th>#</th>
							<th>Producto</th>
							<th class="white"></th>
							<th class="cantidad">Cantidad</th>
							<th class="precio">Precio</th>
							<th class="dto">Dto.</th>
							<th class="total">Total</th>
						</tr>
						<?php 
							for ($x=0; $x < count($_SESSION['json'][1]); $x++) { 
								echo '<tr>
								<td><div><small>'.($x+1).'</small></div></td>
								<td class="doble" colspan="2">'.$_SESSION['json'][1][$x]['nombre'].'</td>
								<td class="grisito">'.$_SESSION['json'][1][$x]['cantidad'].'</td>
								<td class="precio">'.$_SESSION['json'][1][$x]['precioUnitario'].'€</td>
								<td class="dto">'.$_SESSION['json'][1][$x]['dto'].'%</td>
								<td>'.$_SESSION['json'][1][$x]['totalUnitario'].'€</td>
								</tr>';
							}
						?>
						<tfoot>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="2" class='titulos'>Base Imponible</td>					
								<td><?php echo $_SESSION['json'][2]['total_p'].'€';?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="2" class='titulos'>Total I.V.A. (10,00%)</td>
								<td><?php echo $_SESSION['json'][2]['total_i'].'€';?></td>
							</tr>
							<?php 
							if(!empty($_SESSION['json'][2]['total_r'])){
								echo '<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="2" class="titulos">Recargo de equivalencia (1,4%)</td>
								<td>'.$_SESSION['json'][2]['total_r'].'€</td>
								</tr>	';
							}
							?>			
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td class="rojilla">Total</td>
								<td class="rojilla"><?php echo $_SESSION['json'][2]['total'].'€';?></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
	    </section>
	    <section>
			<div class="btn" id="btn">
				<button class="btn btn-primary" id='printA'>
	            <?php 
	            	if(isset($_SESSION['json'][2]['num_albaran'])){
	            		echo 'Imprimir albaran';
	            	}elseif(isset($_SESSION['json'][2]['num_factura'])){
                		echo 'Imprimir factura';
                	}elseif(isset($_SESSION['json'][2]['num_recibo'])){
						echo 'Imprimir recibo';
                	}
	            ?>
				</button>
			</div>
	    </section>
    </div>
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

    <script type="text/javascript" src="../js/loaders.js"></script>    
    <script type="text/javascript" src="../js/comunes.js"></script>
	<script>
		
		$( document ).ready(function() {
			$('#resumen').delay(3000).fadeOut("slow");
			$('#printA').on("click",function(){
				window.open('../php/crearPdf.php','_blank');
			});
		});

	</script>
</body>
</html>
<?php 
		//Vaciamos las sessiones que no necesitamos
		unset($_SESSION['error_a'],$_SESSION['ok_a'],$_SESSION['error_p_a'],$_SESSION['ok_p_a'],$_SESSION['error_f'],
		$_SESSION['ok_f'],$_SESSION['ok_p_f'],$_SESSION['error_p_f'],$_SESSION['error_r'],$_SESSION['ok_r'],$_SESSION['error_p_r'],$_SESSION['ok_p_r'],$_SESSION['error_s'],$_SESSION['ok_s']);
    }
}else{ 
    $_SESSION = array(); 
    $_SESSION['timeExpired'] = true;
    header("Location: ../login.php");
}
?>
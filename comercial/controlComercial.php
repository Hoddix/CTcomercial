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
    <header>
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
		<a href="albaranFinal.php"><button class="col-xs-12 col-md-12 btn btn-hg btn-primary cntrl-pnl" id="btn-pcc-albaran">
		  	CREAR NUEVO ALBARAN
		</button></a>			

		<a href="facturaFinal.php"><button class="col-xs-12 col-md-12 btn btn-hg btn-primary cntrl-pnl" id="btn-pcc-factura">
		  	CREAR NUEVA FACTURA
		</button></a>			

        <a href="reciboFinal.php"><button class="col-xs-12 col-md-12 btn btn-hg btn-primary cntrl-pnl" id="btn-pcc-recibo">
            CREAR NUEVO RECIBO
        </button></a>   

		<a href="clienteFinal.php"><button class="col-xs-12 col-md-12 btn btn-hg btn-primary cntrl-pnl" id="btn-pcc-cliente">
            AÑADIR NUEVO CLIENTE
		</button></a>	
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
    
    <script type="text/javascript" src="../js/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="../js/loaders.js"></script>
    <script type="text/javascript" src="../js/comunes.js"></script>
</body>
</html>
<?php 
    }
}else{ 
    //error_reporting(E_ALL); 
    //ini_set('display_errors', 'On');
    $_SESSION = array(); 
    $_SESSION['timeExpired'] = true;
    header("Location: ../login.php");
}
?>
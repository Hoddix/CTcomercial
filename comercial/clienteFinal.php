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
    <meta charset="utf-8">
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
    <div id="content"></div>
  <div class="container-fluid">
    <header id="cliente">
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
              <li class="active"><a href="clienteFinal.php">AÑADIR CLIENTE</a></li>
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
        <div class="row">
            <div class="col-md-6 col-md-offset-3" id="errores">
                
            </div>
        </div>
        <div class="row" id="cabeceraClientes"> 
            <div class="col-md-4 col-md-offset-4 col-xs-12" id="titulo_pagina">
                <h3>AÑADIR NUEVO CLIENTE</h3>
            </div>
        </div>
        <div class="row" id="resume_general">

        </div>       
        <h6>Nombre (Comercio / Autonomo): </h6>
        <div class="form-group">
            <input type="text" class="form-control" id="nombre" placeholder="Nombre (Comercio / Autonomo)" data-validar="nombre" data-nombre="Nombre (Comercio / Autonomo)"/>
            <span class="input-icon fui-check-inverted"></span>
            <div class="toltip-cont"></div>
        </div>
        <h6>Direccion: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="direccion" placeholder="Direccion" data-validar="direccion" data-nombre="Direccion"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Codigo postal: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="cp" placeholder="Codigo postal" data-validar="cp" data-nombre="Codigo postal"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Localidad: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="localidad" placeholder="Localidad" data-validar="nombre" data-nombre="Localidad"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Nombre de contacto: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="nombre_contacto" placeholder="Nombre de contacto" data-validar="nombre" data-nombre="Nombre de contacto"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Telefono: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="telefono" placeholder="Telefono" data-validar="telefono" data-nombre="Telefono"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Telefono movil: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="movil" placeholder="Telefono movil" data-validar="telefono" data-nombre="Telefono movil"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Email: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="email" placeholder="Email" data-validar="email" data-nombre="Email"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>CIF: </h6>
        <div class="form-group">
        <input type="text" class="form-control" id="cif" placeholder="CIF" data-validar="cif" data-nombre="CIF"/>
        <span class="input-icon fui-check-inverted"></span>
        <div class="toltip-cont"></div>
        </div>
        <h6>Forma de pago: </h6>
        <select class="select-block mbl" id="formapago" data-nombre="Forma de pago">
            <option value="">Forma de pago</option>
        </select>
        <h6>Recargo de equivalencia: </h6>
        <label class="radio recargo">
          <input type="radio" name="recargo" value="si" id="" data-toggle="radio" checked>
            Si
        </label>

        <label class="radio recargo">
          <input type="radio" name="recargo" value="no" id="" data-toggle="radio">
            No
        </label>
        <h6>Plataforma Tapas: </h6>
        <label class="radio plataforma">
          <input type="radio" name="plataforma" value="si" id="" data-toggle="radio">
            Si
        </label>

        <label class="radio plataforma">
          <input type="radio" name="plataforma" value="no" id="" data-toggle="radio" checked>
            No
        </label>        
        <div id="botones">
            <button class="btn btn-primary submit" id="addCliente">Añadir nuevo cliente</button>
        </div>
    </section>
<!-- /.container -->
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
    <script type="text/javascript" src="../js/cliente.js"></script>
    <script type="text/javascript" src="../js/ejecuta.js"></script>
    <script type="text/javascript" src="../js/validacion.js"></script>

    <script type="text/javascript">
        $(window).ready(function(){
            clientes.formasPago();
            $(':radio').radio();
            $("select").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown-inverse'});
            $('input:text').on('blur',function(){
              $(this).validation();  
            });
        });
    </script>

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
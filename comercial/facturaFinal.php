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
    <title>Nosaba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../Flat-UI-master/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Flat-UI-master/bootstrap-select/bootstrap-select.css" rel="stylesheet">
    <!-- Loading Flat UI -->
    <link href="../Flat-UI-master/css/flat-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="../css/tagsStyle.css">

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
    <header id="factura">
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
              <li class="active"><a href="facturaFinal.php">CREAR FACTURA</a></li>
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
        <div class="row">
            <div class="col-md-6 col-md-offset-3" id="errores">
                
            </div>
        </div>    
        <div class="col-md-4 col-md-offset-4 col-xs-12" id="titulo_pagina">
            <h3>CREAR FACTURA</h3>
        </div>
        <div class="row" id="cabeceraFactura">
            <div class="col-md-12">
                <h6>Buscar cliente</h6>
                <div class="form-group">
                    <input class="form-control" id="allClientes" type="text" placeholder="Buscar cliente">
                    <span class="icono-borrar" id="erase" style="display:none;color:#bdc3c7;"><h6>x</h6></span>
                </div>        
                <div id="datosCliente" style="display:none;"></div>
            </div>
            <div class="col-xs-12 col-md-4 col-md-offset-2 datos" id="cliente">                
                <h6><span class="fui-user"></span>&nbsp; Cliente: <span class="over_name" id="g_cliente"></span></h6>
                <h6><span class="fui-location"></span>&nbsp; Direccion: <span class="over_name" id="g_direccion"></span></h6>
                <h6><span class="fui-radio-checked"></span>&nbsp; Localidad: <span class="over_name" id="g_cp"></span> <span class="over_name" id="g_localidad"></span></h6>
                <h6><span class="fui-lock"></span>&nbsp; CIF: <span class="over_name" id="g_cif"></span></h6>  
            </div>
            <div class="col-xs-12 col-md-4  col-md-offset-2 datos" id="datosFactura">
                <h6><span class="fui-calendar-solid"></span>&nbsp; Fecha: <span class="over_name" id="fecha_expedicion"><?php echo date("d-n-Y"); ?></span></h6>
                <h6><span class="fui-user"></span>&nbsp; Nº Cliente: <span class="over_name" id="g_numcliente"></span></h6>    
            </div>
        </div>      
        <div class="row" id="addProductos">            
            <div class="col-md-12">
                <h6>Seleccionar categoria</h6>
                <select class="select-block mbl" id="categorias">
                    <option value="">Categorias</option>
                </select>
            </div>
            <div class="col-md-12">
                <h6>Buscar producto</h6>
                <div class="form-group">
                    <input class="form-control" name="productos" id="productos" type="text" placeholder="Buscar productos">
                    <span class="icono-borrar" id="erase" style="display:none;color:#bdc3c7;"><h6>x</h6></span>
                </div>
                <div id="datosProducto" style="display:none;"></div>   
            </div>               
            <div class="col-md-12">
                <h6>Cantidad de unidades</h6>
                <input class="form-control" type="text" id="cantidadU" placeholder="Cantidad de unidades" data-validar="numero">
                <div class="toltip-cont"></div>
            </div>

            <div class="col-md-12">
                <h6>Cantidad de cajas</h6>
                <input class="form-control" type="text" id="cantidadC" placeholder="Cantidad de cajas" data-validar="numero" >
                <div class="toltip-cont"></div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary" id="add">Añadir producto</button>
            </div>                      
        </div>
        <div class="table-responsive" id="tabla">
            <table class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio/Unidad</th>
                    <th>Dto.</th>
                    <th>Total/Unidades</th>
                    </tr>
                </thead>
                <tbody id="contenidoF">

                </tbody>
                <tfoot id="footF">

                </tfoot>                
            </table>
        </div>
        <div id="botones">
            <button class="btn btn-primary" id="addFactura">Guardar Factura</button>
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
        $( document ).ready(function() {
            comun.calcularTotal();
            
            $('input:text').focuseable();
            
            clientes.efectivo();
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
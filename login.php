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

  if (isset($_SESSION['timeExpired'])){
      $timeExpired = 'La sesion ha caducado. Para comenzar de nuevo haga login otra vez.';
      session_destroy();
  }else if (isset($_SESSION['usuarioerror'])){
      $timeExpired = 'El usuario introducido no existe.';
      session_destroy();
  }else{
      $timeExpired = null;
      session_destroy();
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CTC 1.0 - Comercial Tablet Control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="Flat-UI-master/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Flat-UI-master/bootstrap-select/bootstrap-select.css" rel="stylesheet">
    <!-- Loading Flat UI -->
    <link href="Flat-UI-master/css/flat-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="css/tagsStyle.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Loading mis estilos -->
    <link href="css/estilos.css" rel="stylesheet">
    <style>
      p{
        color: black;
        font-size: 10px;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="col-md-4 col-md-offset-4" id="login">
      <div class="login-form">
        <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h4>Inicia sesion para comenzar</h4>
          <p>El DNI de prueba es: 12345678A</p>
          <p>La contraseña de demo es: A1234567</p>
        </div>
        </div>
        <form action="php/class.php" method="post" onsubmit="return verify();">
        <div class="form-group">
          <input type="text" class="form-control login-field" name="dni" placeholder="Escribe tu DNI" id="login-dni" data-validar="dni" />
          <label class="login-field-icon fui-user" for="login-dni"></label>
        </div>

        <div class="form-group">
          <input type="password" class="form-control login-field" name="password" placeholder="Escribe tu contraseña" id="login-pass" data-validar="password"/>
          <label class="login-field-icon fui-lock" for="login-pass"></label>
          <div class="toltip-cont"></div>
          <small class="col-md-12 text">(La contraseña tiene que ser de 8 a 10 caracteres, por lo menos un digito y un alfanumérico, y no puede contener caracteres espaciales)</small>
        </div>

        <input type="submit" class="btn btn-primary btn-lg btn-block" name="login" value="Iniciar sesion">
        <a class="login-link" href="#">¿Has perdido tu password?</a>
        <p class="outSession"><?php echo $timeExpired;?></p> 
        </div>
        </form>

      </div>
    </div>
    <!-- Load JS here for greater good =============================-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="Flat-UI-master/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="Flat-UI-master/js/jquery.ui.touch-punch.min.js"></script>
    <script src="Flat-UI-master/js/bootstrap.min.js"></script>
    <script src="Flat-UI-master/js/bootstrap-select.js"></script>
    <script src="Flat-UI-master/js/bootstrap-switch.js"></script>
    <script src="Flat-UI-master/js/flatui-checkbox.js"></script>
    <script src="Flat-UI-master/js/flatui-radio.js"></script>
    <script src="Flat-UI-master/js/jquery.tagsinput.js"></script>
    <script src="Flat-UI-master/js/jquery.placeholder.js"></script>

    <script type="text/javascript" src="js/validacion.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $('input').on('blur',function(){
              $(this).validation();  
            });
        });
    </script>

  </body>
</html>
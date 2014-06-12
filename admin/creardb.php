<!-- 
CTC 1.0 - Comercial Tablet Control

Creado por Javier Cabello Ortega
http://www.javiercabello.com
contactar@javiercabello.com 

Licencia de Creative Commons
CTC 1.0 - Comercial Tablet Control by Javier cabello Ortega 
is licensed under a Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional License.
Creado a partir de la obra en http://javiercabello.com.
Puede hallar permisos más allá de los concedidos con esta licencia en http://javiercabello.com
-->

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Language" content="es" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>        
    </title>
</head>
<body>
    <div class="contenido">
        <header>
        </header>
        <section>
            <div id="contenidoseccion">
				<?php
				//Creamos la instalacion inicial de la base de datos
				include_once('../php/claseConexion.php');
				if(isset($_POST['instalar'])){
					$objConexion = new Conexion("qrw056.dbname.net", "qrw056", "Nosaba17", "qrw056");
					$objConexion->conectarServidor();
					//$objConexion->crearBasedatos();
					$objConexion->seleccionarBaseDatos();
					$objConexion->crearTablas();
				}else{
				?>
                <div id="instalar">                    
                    <form id="formulario" action="" method="post" accept-charset="utf-8">
                        <input type="submit" id="instalar" name="instalar" value="Instalar">
                    </form>
                </div>
                <?php
            	}
            	?>
            </div>
        </section>
        <footer>
<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">CTC 1.0 - Comercial Tablet Control</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://javiercabello.com" property="cc:attributionName" rel="cc:attributionURL">Javier cabello Ortega</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional License</a>.<br />Creado a partir de la obra en <a xmlns:dct="http://purl.org/dc/terms/" href="http://javiercabello.com" rel="dct:source">http://javiercabello.com</a>.<br />Puede hallar permisos más allá de los concedidos con esta licencia en <a xmlns:cc="http://creativecommons.org/ns#" href="http://javiercabello.com" rel="cc:morePermissions">http://javiercabello.com</a>
        </footer>
    </div>
</body>
</html>
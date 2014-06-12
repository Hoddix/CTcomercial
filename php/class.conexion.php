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

require_once "config_db.php"; 
 
class Conexion{ 

    public $conectar; 
    
    public function __construct(){ 
    	
    	//CREAMOS EL OBJETO QUE CONTENDRA LA CLASE MYSQLI
        if($this->conectar = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME)){
        
            $this->conectar->set_charset(DB_CHARSET); 
        
        }else{
            
            throw new DBException( "Error al conectar con el servidor MySql" ); 
            
        }
    	  
    } 

} 

?>
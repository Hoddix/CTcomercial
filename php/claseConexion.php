<?php 

class Conexion{

	public $localhost;
	public $usuario;
	public $password;
	public $basedatos;
	//Recibe los datos necesarios para iniciar sesion en el server, crear la base de datos y seleccionarla
	function __construct($l, $u, $p, $db) {
		$this->localhost = $l;
		$this->usuario = $u;
		$this->password = $p;
		$this->basedatos = $db;
	}
	//Funcion que conectar con el servidor
	function conectarServidor(){
		if(mysqli_connect($this->localhost, $this->usuario, $this->password)){
			return true;
		}else{
			return false;
		}
	}
	//Funcion que crea la base de datos
    function crearBasedatos(){
        if(mysqli_query("create database $this->basedatos")){
            echo $this->basedatos.' creada con exito<br/>';
        }else{
            echo 'No se ha podido crear la base de datos<br/>';
        }
    }
    //Funcion que selecciona la base de datos
	function seleccionarBaseDatos(){
		if(mysqli_select_db($this->basedatos)){
            return true;
		}else{
            return false;
		}
	}
	//Funcion que nos crea las tablas necesarias para la web
    function crearTablas(){
        $usuarios= 'CREATE TABLE usuarios(
                    id_usuario Int NOT NULL AUTO_INCREMENT,
                    dni Varchar(10) NOT NULL,
                    nombre Varchar(255) NOT NULL,
                    password Varchar(255) NOT NULL,
                    tipo Int(5) NOT NULL,
                    PRIMARY KEY (id_usuario)
                    )';
        $formasPago= 'CREATE TABLE formasPago(
                    cod_fp Int NOT NULL AUTO_INCREMENT,
                    forma_pago Varchar(255) NOT NULL,
                    dias Int NOT NULL,
                    PRIMARY KEY (cod_fp)
                    )';
        $clientes = 'CREATE TABLE clientes(
                    num_cliente Int NOT NULL AUTO_INCREMENT,
                    nombre Varchar(255) NOT NULL,
                    direccion Varchar(255) NOT NULL,
                    cp Int(5) NOT NULL,
                    localidad Varchar(25) NOT NULL,
                    nombre_contacto Varchar(255),
                    telefono Int(9),
                    movil Int(9),
                    email Varchar(150),
                    cod_fp Int NOT NULL,
                    cif Varchar(11) NOT NULL,
                    recargo Varchar(2) NOT NULL,
                    plataforma Varchar(2) NOT NULL,
                    PRIMARY KEY (num_cliente),
                    FOREIGN KEY (cod_fp) REFERENCES formasPago(cod_fp)
                    )';
        $albaranes = 'CREATE TABLE albaranes(
                    id_albaran Int NOT NULL AUTO_INCREMENT,
                    num_albaran Varchar(255) NOT NULL,
                    fecha_exp Date NOT NULL,
                    fecha_ven Date NOT NULL,
                    total_p float NOT NULL,
                    total_i float NOT NULL,
                    total_r float NOT NULL,
                    total_a float NOT NULL,
                    num_cliente Int NOT NULL,
                    id_usuario Int NOT NULL,
                    PRIMARY KEY (id_albaran,num_albaran),
                    FOREIGN KEY (num_cliente) REFERENCES clientes(num_cliente),
                    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
                    )';
        $facturas = 'CREATE TABLE facturas(
                    id_factura Int NOT NULL AUTO_INCREMENT,
                    num_factura Varchar(255) NOT NULL,
                    fecha Date NOT NULL, 
                    total_p float NOT NULL,
                    total_i float NOT NULL,
                    total_r float NOT NULL,
                    total_f float NOT NULL,
                    num_cliente Int NOT NULL,
                    id_albaran Int,
                    num_albaran Varchar(255),
                    id_usuario Int NOT NULL,
                    PRIMARY KEY (id_factura,num_factura),
                    FOREIGN KEY (num_cliente) REFERENCES clientes(num_cliente),
                    FOREIGN KEY (id_albaran,num_albaran) REFERENCES albaranes(id_albaran,num_albaran),
                    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
                    )';
        $categorias = 'CREATE TABLE categorias(
                    cod_categoria Int(11) NOT NULL AUTO_INCREMENT,
                    nom_categoria Varchar(50) NOT NULL,
                    PRIMARY KEY (cod_categoria)
                    )';
        $productos = 'CREATE TABLE productos(
                    cod_producto Varchar(255) NOT NULL,
                    nom_producto Varchar(50) NOT NULL,                    
                    cod_categoria Int(11) NOT NULL,
                    stock Int(11) NOT NULL,
                    precio Int(11) NOT NULL,
                    tarifa float NOT NULL,
                    unidades_caja Int,
                    peso_gramos float,
                    oferta Varchar(2) NOT NULL,   
                    img Varchar(255),
                    PRIMARY KEY (cod_producto),
                    FOREIGN KEY (cod_categoria) REFERENCES categorias(cod_categoria),
                    FOREIGN KEY (tarifa) REFERENCES tarifas(tarifa)
                    )';
        $tarifaPlataforma = 'CREATE TABLE tarifaPlataforma(
                    cod_tarifaP Int NOT NULL AUTO_INCREMENT,
                    tarifa Int NOT NULL,
                    PRIMARY KEY (cod_tarifa)
                    )';
        $tarifas = 'CREATE TABLE tarifas(
                    cod_tarifa Int NOT NULL AUTO_INCREMENT,
                    nom_tarifa Varchar(255) NOT NULL,
                    tarifa float NOT NULL,
                    num_cliente Int NOT NULL,
                    cod_producto Varchar(255) NOT NULL,
                    especial Varchar(2) NOT NULL,
                    PRIMARY KEY (cod_tarifa),
                    FOREIGN KEY (num_cliente) REFERENCES clientes(num_cliente),
                    FOREIGN KEY (cod_producto) REFERENCES productos(cod_producto)
                    )';
        $albaranesProductos = 'CREATE TABLE albaranesProductos(
                    id Int NOT NULL AUTO_INCREMENT,
                    id_albaran Int NOT NULL,
                    num_albaran Varchar(255) NOT NULL,
                    cod_producto Varchar(255) NOT NULL,
                    cantidad Int NOT NULL,
                    precio float NOT NULL,
                    dto float NOT NULL,
                    total_u float NOT NULL,
                    num_cliente Int NOT NULL,
                    PRIMARY KEY (id),
                    FOREIGN KEY (id_albaran,num_albaran) REFERENCES albaranes(id_albaran,num_albaran),
                    FOREIGN KEY (cod_producto) REFERENCES productos(cod_producto),
                    FOREIGN KEY (num_cliente) REFERENCES clientes(num_cliente)
                    )';
        $facturasProductos = 'CREATE TABLE facturasProductos(
                    id Int NOT NULL AUTO_INCREMENT,
                    id_factura Int NOT NULL,
                    num_factura Varchar(255) NOT NULL,
                    cod_producto Varchar(255) NOT NULL,
                    cantidad Int NOT NULL,
                    precio float NOT NULL,
                    dto float NOT NULL,
                    total_u float NOT NULL,                    
                    num_cliente Int NOT NULL,
                    PRIMARY KEY (id),
                    FOREIGN KEY (id_factura,num_factura) REFERENCES facturas(id_factura,num_factura),
                    FOREIGN KEY (cod_producto) REFERENCES productos(cod_producto),
                    FOREIGN KEY (num_cliente) REFERENCES clientes(num_cliente)
                    )';
		//Una ves creadas las tablas, nos introduce todos los coleres de nuestra paleta de colores.
        if(mysqli_query($usuarios) && mysqli_query($formasPago) && mysqli_query($clientes) && mysqli_query($albaranes) && mysqli_query($facturas) && 
            mysqli_query($categorias) && mysqli_query($productos) && mysqli_query($tarifas) && mysqli_query($albaranesProductos) &&  
            mysqli_query($facturasProductos)){
            echo 'Tablas creadas con exito.';
        } else{
            echo 'No se han podido crear las tablas.<br>';
            echo mysqli_error();
        }
    }
}
?>
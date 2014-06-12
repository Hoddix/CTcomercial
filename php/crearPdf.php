<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

require('fpdf17/fpdf.php');
session_start();
$cliente = $_SESSION['json'][0];
$productos = $_SESSION['json'][1];
$datos = $_SESSION['json'][2];

$header = array('#', 'Producto', 'Cantidad', 'Precio', 'Dto', 'Total');
$footer = array('Base imponible','Total I.V.A. (10.00%)','Recargo de equivalecia (1,4%)','Total');




/*
* Se debe crear siempre una clase heredada de FPDF
* y partir de aqui se irán agregando la cabecera
* footer, cuerpo, etc
* */

//Clase en blanco
class PDF extends FPDF{

  // Pie de página
  function Footer(){
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);

    // Colores de los bordes, fondo y texto
    $this->SetDrawColor(241,92,0);
    $this->SetFillColor(241,153,0);
    $this->SetTextColor(255,255,255);
    $this->Cell(0,10,'Inscrita en el Reg. Merc. de Vizcaya, Tomo 5150, Libro 0, Folio 203 Hoja BI-57271 Inscrip. 1',T,1,'C',true);
  }
  
  //Encabezado
  function Header(){
    global $cliente,$datos,$header;

    $datosEmpresa = "Nosaba SL";
    $datosEmpresa2 = "Grupo la Paz Vicente Uribe, of.6";
    $datosEmpresa3 = "48910 Sestao-Vizcaya";
    $datosEmpresa4 = "94 608 52 43";
    $datosEmpresa5 = "info@nosabaweb.com";
    $datosEmpresa6 = "nosabaweb.com";
    $datosEmpresa7 = "B95623526";

    //Datos del cliente
    $nom_cliente = $cliente['cliente'];
    $dir = $cliente['direccion'];
    $loc = $cliente['cp'].",".$cliente['localidad'];
    $cif = $cliente['cif']; 
  
    //Datos de la factura
    if(isset($datos['num_factura'])){
      $datotipo1= "N-FACTURA: ";
      $num= $datos['num_factura'];
    }else if(isset($datos['num_albaran'])){
      $datotipo1= "N-ALBARAN: ";
      $num= $datos['num_albaran'];
    }else{
      $datotipo1= "N-RECIBO: ";
      $num= $datos['num_recibo'];
    }
    $fec = date("d-n-Y");
    $num_c = $cliente['numcliente'];

    //Define tipo de letra a usar, Arial, Negrita, 15
    $this->SetFont('Arial','B',7);
 		$this->SetTextColor(241,92,0);
    $this->Cell(30,10,'',0,0,'C',false,$this->Image('../img/logo.png', 125,12, 20)); 
   	$this->SetX(150); 
    $this->Cell(30,4,$datosEmpresa,0,1,'L',false); 
		$this->SetFont('Arial','',7);
 		$this->SetTextColor(0,0,0);
 		$this->SetX(150); 
    $this->Cell(30,3,$datosEmpresa2,0,1,'L',false); $this->SetX(150); 
   	$this->Cell(30,3,$datosEmpresa3,0,1,'L',false); $this->SetX(150); 
    $this->Cell(30,3,$datosEmpresa4,0,1,'L',false); $this->SetX(150); 
    $this->Cell(30,3,$datosEmpresa5,0,1,'L',false); $this->SetX(150); 
   	$this->Cell(30,3,$datosEmpresa6,0,1,'L',false); $this->SetX(150); 
		$this->Cell(30,3,$datosEmpresa7,0,1,'L',false);
        
    //Linea de separacion
    $this->SetY(35);
    $this->SetFillColor(241,153,0);
    $this->Cell(190,2,"",0,0,"L",true);

    //Cabecera cliente		 
 		$this->SetY(47);
 		//Foto cliente
 		$this->Cell(30,10,'',0,0,'C',false,$this->Image('../img/clientes.png', 17,47, 20)); 
 		
    //Color nombre cliente
 		$this->SetTextColor(241,92,0);
 		$this->SetFont('Arial','B',13);
 		$this->SetX(40);
    $this->multiCell(50,5,utf8_decode($nom_cliente),0,'L'); 
    //Color letras negras
    $this->SetTextColor(0,0,0);
    $this->SetFont('Arial','',9);
    $this->SetX(40);
    $this->Cell(50,4,utf8_decode($dir),0,1,'L',false); $this->SetX(40);
    $this->Cell(50,4,utf8_decode($loc),0,1,'L',false); $this->SetX(40);
    //Fuente y color para cif/nif
    $this->SetFont('Arial','',7);
    $this->SetTextColor(241,92,0);
   	$this->Cell(15,4,"C.I.F./N.I.F.: ",0,0,'L',false); 
   	//Fuente y color de datos cliente
   	$this->SetFont('Arial','',9);
   	$this->SetTextColor(0,0,0);
   	$this->Cell(30,4,$cif,0,1,'L',false); 


    //Datos Factura		 
    $this->SetY(47);
	  //Fuente y color para numero factura naranja
    $this->SetFont('Arial','',10);
    $this->SetTextColor(241,92,0);
    $this->SetX(140);
   	$this->Cell(25,6,$datotipo1,0,0,'L',false); 
   	//Fuente y color para numero factura negro
   	$this->SetFont('Arial','',9);
   	$this->SetTextColor(0,0,0);
    $this->Cell(30,6,$num,0,1,'L',false); $this->SetX(140);

   	//Fuente y color para fecha naranja
    $this->SetFont('Arial','',10);
    $this->SetTextColor(241,92,0);
   	$this->Cell(25,6,"FECHA: ",0,0,'L',false); 
   	//Fuente y color para fecha negro
   	$this->SetFont('Arial','',9);
   	$this->SetTextColor(0,0,0);
    $this->Cell(30,6,$fec,0,1,'L',false); $this->SetX(140);

    //Fuente y color para numero cliente naranja
    $this->SetFont('Arial','',10);
    $this->SetTextColor(241,92,0);
   	$this->Cell(25,6,"N-CLIENTE: ",0,0,'L',false); 
   	//Fuente y color numero cliente negro
   	$this->SetFont('Arial','',9);
   	$this->SetTextColor(0,0,0);
    $this->Cell(30,6,$num_c,0,1,'L',false); $this->SetX(140);

    $this->SetX(10);
    $this->SetY(75);
    $this->SetFillColor(241,153,0);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(0,0,0);
    $this->SetFont('Arial','',11);
    // Cabecera
    $w = array(10, 70, 30, 30, 20,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],'B',0,'C',true);
    $this->Ln();
	}    

  // Tabla coloreada
  function FancyTable($productos, $footer, $datos){
      $this->SetX(10);
      // Restauración de colores y fuentes
      $this->SetTextColor(0);
      $this->SetFont('Arial','',9);
      // Datos
      $w = array(10, 70, 30, 30, 20,30);
      $fill = false;
      $i=0;
      for($x=0; $x < count($productos);$x++){
          $this->Cell($w[0],10,$x+1,'B',0,'C',$fill);
          $this->Cell($w[1],10,$productos[$x]['nombre'],'B',0,'L',$fill);
          $this->Cell($w[2],10,$productos[$x]['cantidad'],'B',0,'C',$fill);
          $this->Cell($w[3],10,number_format($productos[$x]['precioUnitario'], 2, ',',''),'B',0,'C',$fill);
          $this->Cell($w[4],10,number_format($productos[$x]['dto'], 2, ',',''),'B',0,'C',$fill);
          $this->Cell($w[5],10,number_format($productos[$x]['totalUnitario'], 2, ',',''),'B',0,'C',$fill);
          $this->Ln();
          if($x%18 == 0){
            $i=0;
          }else{
            $i++;
          }
          //$fill = !$fill;
      }
      // Línea de cierre
      //$this->Cell(array_sum($w),0,'','T');

      $this->SetFillColor(241,153,0);
      $this->SetTextColor(0,0,0);
      $this->SetDrawColor(0,0,0);
      $this->SetFont('Arial','',9);
      // Cabecera
      
      
      if($i<15){
          $this->SetY(235);
          $this->SetX(100);
          $this->Cell(70,10,$footer[0],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_p'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(100);
          $this->Cell(70,10,$footer[1],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_i'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(100);
          $this->Cell(70,10,$footer[2],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_r'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(140);
          $this->SetTextColor(255,255,255);

          $this->Cell(30,10,$footer[3],0,0,'C',true);
          $this->Cell(30,10,$datos['total'],0,0,'C',true);
      }else{
          $this->addPage();
          $this->SetY(235);
          $this->SetX(100);
          $this->Cell(70,10,$footer[0],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_p'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(100);
          $this->Cell(70,10,$footer[1],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_i'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(100);
          $this->Cell(70,10,$footer[2],'B',0,'R',false);
          $this->Cell(30,10,$datos['total_r'],'B',0,'C',false);
          $this->Ln(10.2);$this->SetX(140);
          $this->SetTextColor(255,255,255);

          $this->Cell(30,10,$footer[3],0,0,'C',true);
          $this->Cell(30,10,$datos['total'],0,0,'C',true);
      }

  }

}

$pdf = new PDF();             //Crea objeto PDF
// Carga de datos
$pdf->SetFont('Arial','',11);

$pdf->AddPage(); //Agrega hoja, Vertical, Carta

$pdf->FancyTable($productos,$footer,$datos);

$pdf->Output();

unset($_SESSION['json']);
?>
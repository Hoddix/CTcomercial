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
$.fn.validation = function(){

  var nombre        = /^[A-Za-zñÑ-áéíóúÁÉÍÓÚ]+([A-Za-zñÑ-áéíóúÁÉÍÓÚ] ?)*[A-Za-zñÑ-áéíóúÁÉÍÓÚ]$/;
  var numero        = /^[0-9]+$/;
  var direccion     = /^([A-Za-zñÑ-áéíóúÁÉÍÓÚ0-9 :,]{5,})+$/;
  var password      = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
  var dni           = /^\d{8}[a-zA-Z]$/;
  var email         = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  var telefono      = /^[0-9]{2,3}-? ?[0-9]{6,9}$/;
  var codigoPostal  = /^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/;
  var cif           = /\d{8}[a-zA-Z]$/;

  var patron        = $(this).data('validar');
  var texto         = "";

  switch(patron){

    case 'nombre':
      patron  = nombre;
      texto   = "Este campo solo puede contener letras.";
    break;

    case 'direccion':
      patron  = direccion;
      texto   = "Este campo solo puede contener numeros y letas.";
    break;

    case 'numero':
      patron  = numero;
      texto   = "Este campo solo puede contener numeros.";
    break;

    case 'password':
      patron  = password;
      texto   = "Solo puede contener de 8 a 10 catracteres entre numeros y letras.";
    break;

    case 'dni':
      patron  = dni;
      texto   = "Este campo ha de ser de 8 numeros y 1 letra.";
    break;

    case 'email':
      patron  = email;
      texto   = "Este campo ha de contener una @ y un dominio. Ej: @dominio.com.";
    break;

    case 'telefono':
      patron  = telefono;
      texto   = "Este campo solo puede contener 9 numeros.";
    break;

    case 'cp':
      patron  = codigoPostal;
      texto   = "Este campo solo puede contener 5 numeros.";
    break;

    case 'cif':
      patron  = cif;
      texto   = "Este campo solo puede contener numeros y letras. Ej: E1234567D";
    break;

  }

  if(!$(this).val().match(patron)){

    $(this).focus();

    $(this).css('color','#e74c3c')
           .css('border','2px solid #e74c3c');
    
    $(this).parent().find('span').css('color','#e74c3c');

    var toltip    = '<div class="toltip">'+texto+'</div><div class="flecha"></div>';

    if(!$('.toltip').is(':visible')){

      var $toltip = $(toltip).hide().fadeIn("slow");

      $(this).parent().find('.toltip-cont').html($toltip);

      $('.toltip').css('position', 'absolute')
                  .css('top', '0px')
                  .css('left','0px')
                  .css('width','150px')
                  .css('height','70px')
                  .css('background-color','#e74c3c')
                  .css('border-radius','5px')
                  .css('box-shadow','2px 2px 5px rgb(167, 167, 167)')
                  .css('color','white')
                  .css('padding','5px')
                  .css('font-size','11px');

      $('.flecha').css('position', 'absolute')
                  .css('top', '65px')
                  .css('left','15px')
                  .css('width','16px')
                  .css('height','16px')
                  .css('background-image','url("http://'+location.host+'/nosaba3/img/flecha-toltip.png")');

    }
    $('.toltip').delay(3000).fadeOut("slow");

    $('.flecha').delay(3000).fadeOut("slow");

  }else{

    $(this).css('color','#2ecc71')
           .css('border','2px solid #2ecc71');

    $(this).parent().find('span').css('color','#2ecc71');

  }

};

var verify = function(){

  //var password = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;

  var password = /[0-9]{1,4}/;

  if(!$('#login-pass').val().match(password)){

    return false;

  }else{

    return true;

  }

}

/*function nif(dni) {
var numero
var let
var letra
var expresion_regular_dni

expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

if(expresion_regular_dni.test (dni) == true){
numero = dni.substr(0,dni.length-1);
let = dni.substr(dni.length-1,1);
numero = numero % 23;
letra='TRWAGMYFPDXBNJZSQVHLCKET';
letra=letra.substring(numero,numero+1);
if (letra!=let) {
alert('Dni erroneo, la letra del NIF no se corresponde');
}else{
alert('Dni correcto');
}
}else{
alert('Dni erroneo, formato no válido');
}
}*/
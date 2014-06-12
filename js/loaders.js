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

var loader = {
	cargando : function(dato){
		$('#content').html('<div class="gifcarga-p"><div id="texto"><p>'+dato+'</p></div><img src="../img/ajax-loader.gif"/></div>');
	},
	guardando : function(dato){
		$('#content').html('<div class="gifcarga"><div id="texto"><p>'+dato+'</p></div><img src="../img/ajax-loader.gif"/></div>');
	},
	quitarPeque : function(){
		$('.gifcarga-p').remove("");
	},
	quitarGrande : function(){
		$('.gifcarga').remove("");
	}
};


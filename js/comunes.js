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

//VARIABLES GLOBALES
var cont  		= 0;
var iva 		= 10;
var recargo 	= 1.4;
var id_session 	= $("#sesion").data("id");

var comun 		= {

	capturarErrores : function(){
	
		var option 	= $('header').attr('id');
	
		if(option == "cliente" || option == "usuario"){
	
			$('#errores').find('div#errorR').remove();
	
			var html = '<div id="errorR">'+	
				'<div id="cerrarR"><h6>x</h6></div>'+
				'<p>Estos campos son obligatorios. Por favor, rellenalos para añadir el nuevo '+option+'.</p>';
			
			$('input:text').each(function(){
			
				if($(this).val() == ""){
			
					html += '<small>'+$(this).data('nombre')+ ' es obligatorio.</small><br>';
			
				}
			
			});

			$('input:password').each(function(){
			
				if($(this).val() == ""){
			
					html += '<small>'+$(this).data('nombre')+ ' es obligatorio.</small><br>';
			
				}
			
			});
			
			$('select').each(function(){
			
				if($(this).val() == ""){
			
					html += '<small>Tienes que seleccionar una '+$(this).data('nombre')+ '.</small><br>';
			
				}
			
			});
			
			html += '</div>';
			
			var $wrong = $(html).hide().fadeIn(1000);
			
			$('#errores').append($wrong).css('display','block');
			
			$(document).scrollTop( 0 );
		}
		else if(option == "albaran" || option == "factura"){

			$('#errores').find('div#errorR').remove();

			var numeroProductos = $('.producto');
			
			var html 			= '<div id="errorR">'+
				'<div id="cerrarR"><h6>x</h6></div>'+
				'<p>Estos campos son obligatorios. Por favor, rellenalos para completar la accion.</p>';
			
			if($('#g_cliente').text() == ""){
			
				html += '<small>Cliente es obligatorio.</small><br>';
			
			}
						
			if(numeroProductos.length == 0){
			
				html += '<small>Tienes que seleccionar al menos un producto.</small><br>';			
			
			}
			
			html += '</div>';
			
			var $wrong = $(html).hide().fadeIn(1000);
			
			$('#errores').append($wrong).css('display','block');
			
			$(document).scrollTop( 0 );
		
		}else if(option == "bandeja"){

			$('#errores').find('div#errorR').remove();

			var numeroProductos = $('.producto');
			
			var html 			= '<div id="errorR">'+
				'<div id="cerrarR"><h6>x</h6></div>'+
				'<p>Estos campos son obligatorios. Por favor, rellenalos para completar el mensaje.</p>';

			if($('#g_cliente').text() == ""){

				html += '<small>Asunto es obligatorio.</small><br>';

			}

			if(numeroProductos.length == 0){

				html += '<small>Tienes que seleccionar al menos un destinatario.</small><br>';			

			}

			html += '</div>';

			var $wrong = $(html).hide().fadeIn(1000);

			$('#errores').append($wrong).css('display','block');

			$(document).scrollTop( 0 );

		}		

	},
	
	calcularTotal   : function(){
		
		var recargo 		= $('#clienteSeleccionado').data("recargo");
		var total 			= 0;
		var totalUnitarios 	= 0;

		$('tr').each(function(){
		
			totalUnitarios 	= $(this).find('.totalUnitario').data("val");
		
			if(!isNaN(totalUnitarios)){
		
				total 		= parseFloat(total)+parseFloat(totalUnitarios);
		
			}	
		
		});
		
		var strTotal 	= '<tr><td colspan="5"></td><td>Total Productos</td><td id="total_p">'+total.toFixed(2)+'</td></tr>';
		
		var mostrarIva 	= (parseFloat(total) * parseFloat(iva)) / parseFloat(100);
		
		strTotal 		+= '<tr><td colspan="5"></td><td>iva - '+iva+'%</td><td id="total_i">'+mostrarIva.toFixed(2)+'</td></tr>';
		
		total 			= (parseFloat(total) * parseFloat(iva) / parseFloat(100) ) + parseFloat(total);
		
		if(recargo == 'si'){
		
			var mostrarRecargo 	= (parseFloat(total) * parseFloat(1.4)) / parseFloat(100);
		
			strTotal 			+= '<tr><td colspan="5"></td><td>Recargo - 1.4%</td><td id="total_r">'+mostrarRecargo.toFixed(2)+'</td></tr>';
		
			total 				= (parseFloat(total) * parseFloat(1.4) / parseFloat(100) ) + parseFloat(total);
		
		}
		
		strTotal 		+= '<tr><td colspan="5" id="noBorde"></td><td>Total</td><td id="total">'+total.toFixed(2)+'</td></tr>';

		$('#footF').html(strTotal);

	},

	mensajesSinLeer : function(){

	    var id_session = $("#sesion").data("id");

	    $.post("../php/class.php",
	        {
	           	getMensajesSinLeer : "getMensajesSinLeer",
	            id : id_session
	        },
	        function(res){

		        if(res == null || res == 0){
		    
		        	$('#alertamensajes').html('Mensajes') 
		    
		        }else{
		    
		        	res.length > 0 ? $('#alertamensajes').html('Mensajes<span class="navbar-new">'+res+'</span>') : $('#alertamensajes').html('Mensajes') ;	
		    
		        }
        
        	}
        
        ).fail(function(xhr, ajaxOptions, thrownError){
			
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	
		
		});
	
	},
	
	subMenu 		: function(){

		$("ul.sub_ul_lat_nav").hide();	

		$('.seleccion').css('display', 'none');

		$('.padre').on("click",function(){

			$("ul.sub_ul_lat_nav").slideUp('fast');

			$('.seleccion').css('display', 'none');

			$(this).parent().find('.seleccion').css('display', 'inline');

			$(this).parent().find('.sub_ul_lat_nav').slideToggle('fast'); 	

		});

		$('.inicio').on("click",function(){

			$("ul.sub_ul_lat_nav").slideUp('fast');

			$('.seleccion').css('display', 'none');

		});

	},

	failErrors 		: function(xhr, ajaxOptions, thrownError){

		console.log(xhr.status)
		console.log(xhr.responseText)
		console.log(thrownError)
		
		if (xhr.status === 0) {
		    
		    console.log('Error de conexión, verifica tu instalación.');
		
		} else if (xhr.status == 302) {
		
		    console.log('La página ha sido movida. [302]');
		
		} else if (xhr.status == 404) {
		
		    console.log('La página no ha sido encontrada. [404]');
		
		} else if (xhr.status == 500) {
		
		    console.log('Internal Server Error [500].');
		
		} else if (thrownError === 'parsererror') {
		
		    console.log('Error parse JSON.');
		
		} else if (thrownError === 'timeout') {
		
		    console.log('Exceso tiempo.');
		
		} else if (thrownError === 'abort') {
		
		    console.log('Petición ajax abortada.');
		
		} else {
		
		    console.log('Error desconocido: ' + xhr.responseText);
		
		}	
	
	}

};


//Llamaos a la funcion para todas las paginas

$(function(){
	comun.mensajesSinLeer(); 
});

$.fn.focuseable = function(){
	$(this).on('focus',function(){
		$(this).val('');
	});
};



$('.table').on('keydown','.cantidad',function(){
		var code = null;
      	$(this).keypress(function(e){
            code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) return false;
            //e.preventDefault();
        });
});



$('.table').on('blur','.cantidad',function(){

	var stock = $('#productoSelecionado').data('stock');
	var nuevaCantidad = $(this).text();
	var precioUnitario = $(this).parent().find('.precioUnitario').data('val');
	
	if(!isNaN(nuevaCantidad) && nuevaCantidad > 0){
		if(stock < nuevaCantidad){

			alert("Stock sobrepasado. Disponibles: "+stock)

			$('#cantidadU').val("0");

			$('#cantidadC').val("0");

			$(this).text($(this).data('val'));

		}else{

			$(this).data('val',nuevaCantidad);

			nuevaCantidad = $(this).data('val');

			var totalUnitario = nuevaCantidad*precioUnitario;

			$(this).parent().find('.totalUnitario').data('val',totalUnitario.toFixed(2));
			$(this).parent().find('.totalUnitario').html(totalUnitario.toFixed(2));

			comun.calcularTotal();
		}
	}else{
		$(this).text($(this).data('val'));
	}

});



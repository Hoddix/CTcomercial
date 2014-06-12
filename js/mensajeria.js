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

/*#######################################################################################
				MENSAJERIA
#######################################################################################*/

var id_session = $("#sesion").data("id");

var mensajeria = {

	usuariosDestinatarios: function(){
		
		loader.cargando("Cargando");

		$.post("../php/class.php",
			{
				getUsuarios : "getUsuarios",
				id 			: id_session
			},
			function(res){		

				var usuariosArray = new Array();
				
				for(var x=0; x<res.length; x++){
					usuariosArray[x] 	= { 
						value 			: res[x].nombre, 
						dataidusuario 	: res[x].id_usuario, 
						datanombre 		: res[x].nombre
					};
				}
				
				loader.quitarPeque();
			    
			    $('#destinatario').autocomplete({
			        
			        lookup: usuariosArray,
			        
			        onSelect: function (suggestion) {
			        
			        	var html = '<span id="usuarioSeleccionado" data-id_usuario="'+suggestion.dataidusuario+'" data-nombre="'+suggestion.datanombre+'" style="display:none;"></span>';
						$('#datosDestinatario').html(html);
			        
			        }
			    
			    });
		
			},"json"
		)

		.fail(function(xhr, ajaxOptions, thrownError){
		
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		
		
		});
	},
	//CARGA LOS MENSAJES DE LA BANDEJA DE ENTRADA SEGUN PAGINAS
	bandejaEntada : function(ini_,fin_){

		loader.cargando("Cargando mensajes");
	    
	    $.post("../php/class.php",
	    	{
	    		getMensajes : "getMensajes",
	        	id 			: id_session,
	        	ini 		: ini_,
	        	fin 		: fin_
	        },
	        function(res){
	        	
	        	if(res != null){

		            var html = ''; 

		            for (var i=0; i<res.length; i++) {
		            
		                html += '<li class="list-group-item subjet" id="id_mensaje" data-id_mensaje="'+res[i].id_mensaje+'">';
		            
		                if(res[i].estado == "P"){
		                    html += '<span class="badge">Sin leer</span>';
		                }               
		            
		                html += '<span class="estilomensajes asunto">Asunto: '+res[i].asunto+'</span>'+
		                '<ul class="cont-message">'+
		                '<li class="estilomensajes"><span>Mensaje de: '+res[i].nombre+'</span></li>'+
		                '<li class="estilomensajes">Enviado el: '+res[i].fecha+'</li>'+
		                '<li id="acciones_men"><button class="btn btn-primary navbar-btn btn-xs" type="button" id="responder" data-id_mensaje="'+res[i].id_mensaje+'">'+
		                '<span class="estilomensajes glyphicon glyphicon-share-alt"> Responder</span></button>&nbsp;&nbsp;&nbsp;&nbsp;'+
		                '<button class="btn btn-primary navbar-btn btn-xs" type="button" id="borrar" data-id_mensaje="'+res[i].id_mensaje+'">'+
		                '<span class="estilomensajes glyphicon glyphicon-trash"> Borrar</span></li></button>'+
		                '<li>'+ res[i].contenido +'</li></ul></li>';
		            }
		            
		            $('#mensajeria').html(html).css('text-align','left');	
		            
		            loader.quitarPeque();
	        	
	        	}else{
		            
		            $('#mensajeria').html("No hay mensajes.").css('text-align','center');	

		            loader.quitarPeque();
	        	
	        	}

	    	},"json"
	    )

		.fail(function(xhr, ajaxOptions, thrownError){
	    
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	
	    
	    });
	},
	//CARGA LOS MENSAJES DE LA BANDEJA DE ENTRADA SEGUN PAGINAS
	bandejaSalida : function(ini_,fin_){
		
		loader.cargando("Cargando mensajes");

	    $.post("../php/class.php",
	        {
	        	getMensajesSalida 	: "getMensajesSalida",
	        	id 					: id_session,
	        	ini 				: ini_,
	        	fin 				: fin_
	        },
	        function(res){
	        	
	        	if(res != null){
	        		
	        		var html = ''; 		        
		            
		            for (var i=0; i<res.length; i++) {
		        
		                html += '<li class="list-group-item subjet" data-id_mensaje="'+res[i].id_mensaje+'">';
		        
		                if(res[i].estado == "P"){
		                    html += '<span class="badge">Sin leer</span>';
		                }                
		        
		                html += '<span class="estilomensajes asunto">Asunto: '+res[i].asunto+'</span>'+
		                '<ul class="cont-message">'+
		                '<li class="estilomensajes"><span class="estilomensajes">Enviado a: '+res[i].nombre+'</span></li>'+
		                '<li class="estilomensajes" id="fecha">Enviado el: '+res[i].fecha+'</li>'+
		                '<li id="acciones_men"><button class="btn btn-primary navbar-btn btn-xs" type="button" id="borrar" data-id_mensaje="'+res[i].id_mensaje+'">'+
		                '<span class="estilomensajes glyphicon glyphicon-trash"> Borrar</span></li></button>'+
		                '<li>'+res[i].contenido+'</li></ul></li>';
		            }
    	
    	            $('#mensajeria').html(html).css('text-align','left');
	    
	            	loader.quitarPeque();

		        }else{

		            $('#mensajeria').html("No hay mensajes.").css('text-align','center');	
		            
		            loader.quitarPeque();

	        	}
	   
	        },"json"
	    )

		.fail(function(xhr, ajaxOptions, thrownError){
	        
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	 
	    
	    });
	},
	//CARGA LOS MENSAJES DE LA BANDEJA DE ENTRADA SEGUN PAGINAS
	papelera : function(ini_,fin_){

		loader.cargando("Cargando mensajes");
	    
	    $.post("../php/class.php",
	        {
	        	getPapelera :"getPapelera",
	        	id 			: id_session,
	        	ini  		: ini_,
	        	fin 		: fin_
	        },
	        function(res){
	            
	            if(res != null){
		        	
		        	var html = '';
		            
		            for (var i=0; i<res.length; i++) {
		        
		                html += '<li class="list-group-item subjet" data-id_mensaje="'+res[i].id_mensaje+'">';
		        
		                if(res[i].estado == "P"){
		                    html += '<span class="badge">Sin leer</span>';
		                }                
		        
		                html += '<span class="estilomensajes asunto">Asunto: '+res[i].asunto+'</span>'+
		                '<ul class="cont-message">'+
		                '<li class="estilomensajes"><span class="estilomensajes">Enviado a: '+res[i].nombre+'</span></li>'+
		                '<li class="estilomensajes" id="fecha">Enviado el: '+res[i].fecha+'</li>'+
		                '<li id="acciones_men"><button class="btn btn-primary navbar-btn btn-xs" type="button" id="borrar" data-id_mensaje="'+res[i].id_mensaje+'">'+
		                '<span class="estilomensajes glyphicon glyphicon-trash"> Borrar</span></li></button>'+
		                '<li>'+res[i].contenido+'</li></ul></li>';
		            }
		        	
		        	$('#mensajeria').html(html).css('text-align','left');
	    
	            	loader.quitarPeque();

		        }else{

		            $('#mensajeria').html("No hay mensajes.").css('text-align','center');	
		            
		            loader.quitarPeque();

	        	}
	    
	    	},"json"
    	)
		
		.fail(function(xhr, ajaxOptions, thrownError){
	    
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	 
	    
	    });
	},
	//CARGA LOS INDICES DE LAS PAGINAS
	pagination : function(){ //REVISADA
	    
	    var page_ = $('.sel').data('val');
	    
	    $.post("../php/class.php",
	        {  
	        	paginarMensajes : "paginarMensajes",
	            id 				: id_session,
	            page 			: page_            
	        },
	        function(res){       

	        	if(res == 0) res=1;

	            var all = false;             
	        
	            var html = '<li class="previous"><a href="#" class="fui-arrow-left"></a></li>';
	        
	            for (var i=0; i<res; i++) {
	        
	                if(i==0){
	                    html += '<li class="pag active" data-ini="'+(10*i)+'" data-fin="10" data-pag="'+(i+1)+'"><a href="#">'+(i+1)+'</a></li>';
	                }else if(i<4){
	                    html += '<li class="pag" data-ini="'+(i*10)+'" data-fin="10" data-pag="'+(i+1)+'"><a href="#">'+(i+1)+'</a></li>';
	                }else if(i>4){
	                	all = true;
	                }
	            }
	        
	            if(all){
	    
	            	html += '...'+
            			'<li class="pag" data-ini="0" data-fin="1000" data-pag="all"><a href="#">all</a></li>';
	            	all = false;
	    
	            }
	    
	            html += '<li class="next"><a href="#" class="fui-arrow-right"></a></li>';
	    
	            $('.pagination').find('ul').html(html);
	    
	    	}
	    )
		
		.fail(function(xhr, ajaxOptions, thrownError){
	    
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	 
	    
	    });
	},
	//CREAMOS UN NUEVO MENSAJE
	nuevoMensaje : function(){
		
		var html = '<h6>Nuevo mensaje</h6>'+
			'<label for="">Destinatario:</label>'+
			'<div class="form-group">'+
			'<input type="text" class="form-control" placeholder="Destinatario" id="destinatario" data-validar="nombre"/>'+
			'<div id="datosDestinatario"></div>'+
			'</div>'+
			'<label for="">Asunto: </label>'+
			'<div class="form-group">'+
	  		'<input type="text" class="form-control" placeholder="Asunto" id="asunto" data-validar="direccion" >'+
	  		'<div class="toltip-cont"></div>'+
			'</div>'+
			'<label for="">Contenido: </label>'+
			'<div class="form-group">'+
	  		'<textarea class="form-control" rows="10" id="contenido"></textarea>'+
			'</div>'+
			'<button class="btn btn-primary" id="sendMensaje">Enviar</button>';
		
		$('#mensajeria').html(html).css('text-align','left');
		
		$('.pagination').find('ul').html("");
		
		mensajeria.usuariosDestinatarios();
	},
	//SELECCIONAMOS EL TIPO DE BANDEJA EN LA QUE ESTAMOS
	seleccionarPager : function(pager){
		switch(pager){
		
			case 1:			
				mensajeria.pagination();
				mensajeria.bandejaEntada(0,10);			
			break;
		
			case 2:
				mensajeria.pagination();
				mensajeria.bandejaSalida(0,10);			
			break;
		
			case 3:
				mensajeria.pagination();
				mensajeria.papelera(0,10);
			break;
		
			case 4:
				mensajeria.nuevoMensaje();
			break;						
		
		}
	},
	//SELECCIONAMOS EN QUE BANDEJA ESTAMOS Y EN QUE PAGINA
	selectBandeja : function(ini_,fin_){
	    
	    var page = $('.sel').data('val');
	    
	    switch(page){
	    	case 1:
	    	mensajeria.bandejaEntada(ini_,fin_);
	    	break;
	    
	    	case 2:
	    	mensajeria.bandejaSalida(ini_,fin_);
	    	break;
	    
	    	case 3:
	    	mensajeria.papelera(ini_,fin_);
	    	break;
	
	    }
	}
	
};


//Cargamos la primera vez que entramos en la bandeja de entrada
$(function(){
	mensajeria.pagination();
	mensajeria.bandejaEntada(0,10);  	
});


//ENVIAR MENSAJE
$('#mensajeria').on('click','#sendMensaje',function(){
	
	var id_destinatario_ = $('#usuarioSeleccionado').data('id_usuario');
	var id_emisor_       = $("#sesion").data("id");
	var asunto_          = $('#asunto').val();
	var contenido_       = $('#contenido').val();
	
	var jsonMen = new Array();

	jsonMen 	= {
		id_destinatario   	: id_destinatario_,
		id_emisor         	: id_emisor_,
		asunto 		       	: asunto_,
		contenido 		 	: contenido_
	};
	
	var JSONString = JSON.stringify(jsonMen);

	if(asunto_ != "" && id_destinatario_ != ""){
	
		loader.guardando("Enviando mensaje");
	
		$.post('../php/class.php',
			{
				sendMensaje : "sendMensaje",
				jsonMensaje : JSONString
			},
			function(res){
				console.log(res)
				if(res==1){
					loader.quitarGrande();
			
					var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
						'<div id="resumen">'+
						'<div id="cerrarV"><h6>x</h6></div>'+
						'<p>Mensaje enviado correctamente</p>'+
						'</div>'+
						'</div>';
					
					$('#resume_general').html(html);	
					
					$(document).scrollTop( 0 );
					
					$('#reporte').delay(3000).fadeOut("slow");
				
					mensajeria.nuevoMensaje();
				}else{
					loader.quitarGrande();

					var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
							'<div id="resumenR">'+
						 	'<div id="cerrarR"><h6>x</h6></div>'+
						 	'<p>No se ha podido enviar el mensaje.</p>'+
							'</div>'+
							'</div>';
				
					$('#resume_general').html(html);	
				
					$(document).scrollTop( 0 );
				
					$('#reporte').delay(3000).fadeOut("slow");					
				}

			}
		)
		.fail(function(xhr, ajaxOptions, thrownError){
		
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		
		
			loader.quitarGrande();

			var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
					'<div id="resumenR">'+
				 	'<div id="cerrarR"><h6>x</h6></div>'+
				 	'<p>No se ha podido enviar el mensaje.</p>'+
					'</div>'+
					'</div>';
		
			$('#resume_general').html(html);	
		
			$(document).scrollTop( 0 );
		
			$('#reporte').delay(3000).fadeOut("slow");
		});

	}else{
		
		comun.capturarErrores();

	}

});

//MENU PARA NAVEGAR ENTRE BANDEJAS Y PAPELERA
$(document).ready(function(){
    var $first = $('.pagina:first', 'ul'),
        $last  = $('.pagina:last', 'ul');

    $(".pager").on("click", ".next",function () {
        
        var $next, $selected = $(".sel");
        
        $next = $selected.next('.pagina').length ? $selected.next('.pagina') : $first;
        $selected.removeClass('sel').addClass("nosel");
        $next.removeClass('nosel').addClass('sel');
       	mensajeria.seleccionarPager($next.data("val"));
    
    });

    $(".pager").on("click", ".previous",function () {
    
        var $prev, $selected = $(".sel");
    
        $prev = $selected.prev('.pagina').length ? $selected.prev('.pagina') : $last;
        $selected.removeClass('sel').addClass("nosel");
        $prev.removeClass('nosel').addClass('sel');
        mensajeria.seleccionarPager($prev.data("val"));
    
    });

});

//PASAR DE PAGINA
$('.pagination').on('click','.pag',function(){
    
    var ini_ = $(this).data('ini');

    var fin_ = $(this).data('fin');
	
	mensajeria.selectBandeja(ini_,fin_);
    
    $('.pag').each(function(){
    
        $(this).removeClass("active");    
    
    });
    
    $(this).addClass("active");

});

//PASAR DE PAGINA
$('.pagination').on('click','.next',function(){
  
    var $first    = $('.pag:first', 'ul'),
		$last     = $('.pag:last', 'ul');
    
    var $next, 
    	$selected = $(".active");
    
    $next         = $selected.next('.pag').length ? $selected.next('.pag') : $first;
    
    $selected.removeClass('active');
    
    $next.addClass('active');
	
	var ini_      = $next.data('ini');
	
	var fin_      = $next.data('fin');
	
	mensajeria.selectBandeja(ini_,fin_);

});

$('.pagination').on('click','.previous',function(){
   
    var $first    = $('.pag:first', 'ul'),
		$last     = $('.pag:last', 'ul');
   	
   	var $prev, 
   		$selected = $(".active");
    
    $prev         = $selected.prev('.pag').length ? $selected.prev('.pag') : $last;
    
    $selected.removeClass('active');
    
    $prev.addClass('active');
	
	var ini_      = $prev.data('ini');
	
	var fin_      = $prev.data('fin');
	
	selectBandeja(ini_,fin_);

});

//FUNCION PARA CONTROL DE LOS MENSAJES
$(document).ready(function(){ // Script del Navegador

    $("ul.cont-message").hide();    

    $('#mensajeria').on("click",".asunto",function(){

        var asunto = $(this);

        /*$("ul.cont-message").each(function(){

            if($(this).is(':visible')){

                $(this).slideUp('fast');  

            } 

        });*/    

        if(asunto.parent().find('.cont-message').is(':visible')){

            asunto.parent().find('.cont-message').slideUp('fast');  
            
            var ini,fin;
            
            $('.pag').each(function(){
		    
		        ini = $(this).parent().find(".active").data("ini");
		        fin = $(this).parent().find(".active").data("fin");    
		    
		    });

			mensajeria.selectBandeja(ini,fin);
        
        }else{
		
			asunto.parent().find('.cont-message').slideDown('fast'); 
		
			var id_mensaje = asunto.parent().data("id_mensaje");
        
            var page       = $('.sel').data('val');
        
            if(page == 1){
		
				$.post("../php/class.php",
					{
					    updateMensaje: "updateMensaje",
					    id: id_mensaje
					},
					function(res){                                
					    asunto.parent().find('.badge').remove();

					    comun.mensajesSinLeer();
					}
				)
				
				.fail(function(xhr, ajaxOptions, thrownError){
				
					console.log(xhr.status)
					console.log(xhr.responseText)
					console.log(thrownError)
					//comun.failErrors(xhr, ajaxOptions, thrownError);	 
				
				});
            
            }

        }
    
    });

}); 

$('#mensajeria').on('click','#responder',function(){
	
	var _id_mensaje = $(this).data("id_mensaje");
	
	var _emis       = $("#sesion").data("id");

	$.post('../php/class.php',
		{
			responderMensaje:"responderMensaje",
			id_mensaje: _id_mensaje
		},
		function(res){
			var html = '<h6>Responder mensaje</h6>'+
				'<label for="">Destinatario:</label>'+
				'<div class="form-group">'+
				'<input type="text" class="form-control" placeholder="Destinatario" id="destinatario" data-validar="nombre" value="'+res.nombre+'"/>'+
				'<div id="datosDestinatario"><span id="usuarioSeleccionado" data-id_usuario="'+res.id_emisor+'" style="display: none; color: rgb(46, 204, 113);"></span></div>'+
				'</div>'+
				'<label for="">Asunto: </label>'+
				'<div class="form-group">'+
		  		'<input type="text" class="form-control" placeholder="Asunto" id="asunto" data-validar="direccion" value="RE: '+res.asunto+'">'+
		  		'<div class="toltip-cont"></div>'+
				'</div>'+
				'<label for="">Contenido: </label>'+
				'<div class="form-group">'+
		  		'<textarea class="form-control" rows="10" id="contenido">\n\n\nMensaje recibido el '+res.fecha+'.\n'+res.contenido+'</textarea>'+
				'</div>'+
				'<button class="btn btn-primary" id="sendMensaje">Enviar</button>';
		
			$('.pagina').each(function(){

				if($(this).data('val') == 1){
		        
		        	$(this).removeClass('sel').addClass('nosel');
				
				}else if($(this).data('val') == 4){
				
					$(this).removeClass('nosel').addClass('sel');
				
				}
			
			});

			$('#mensajeria').html(html);

			$('textarea').focus();

			$('.pagination').find('ul').html("");

		},'json'

	).fail(function(xhr, ajaxOptions, thrownError){
    
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	
    
    });

});

$('#mensajeria').on('click','#borrar',function(){

	var _id_mensaje = $(this).data("id_mensaje");
	
	$.post('../php/class.php',
		{
			borrarMensaje:"borrarMensaje",
			id: _id_mensaje
		},
		function(res){
		
		}
	)

	.fail(function(xhr, ajaxOptions, thrownError){
	
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	 
	
	});
});

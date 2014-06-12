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

var clientes =  {

	aplazado : function(){ // Revisada
	
		loader.cargando("Cargando clientes");

		$.post("../php/class.php",
			{
				paClientes:"paClientes"
			},
			function(res){		

				if(res != null){	

					var tarifaP = 0;
					var clientesArray = new Array();

					for(var x=0; x<res.length; x++){
						clientesArray[x] = { 
							value : res[x].nombre, 
							datanumcliente : res[x].num_cliente, 
							datanombre : res[x].nombre, 
							datarecargo : res[x].recargo,
							datadir :res[x].direccion,
							datacp :res[x].cp,
							dataloc :res[x].localidad,
							datacif	:res[x].cif,
							plataforma : res[x].plataforma
						};
					}

					$.post("../php/class.php",
						{
							tarifaP 	: "tarifaP"
						},
						function(res){
							
							callback(res.valor);
					
						},"json"
					
					)
					
					.fail(function(xhr, ajaxOptions, thrownError){
					
						console.log(xhr.status)
						console.log(xhr.responseText)
						console.log(thrownError)
						//comun.failErrors(xhr, ajaxOptions, thrownError);		
					
					});

					function callback(tarifa){

						tarifaP = tarifa;
						
						loader.quitarPeque();
					}

				    $('#allClientes').autocomplete({
				        
				        lookup: clientesArray,
				        
				        onSelect: function (suggestion) {

				        	var html = '<span id="clienteSeleccionado" data-numcliente="'+suggestion.datanumcliente+'" data-nombre="'+suggestion.datanombre+'" '+
								'data-recargo="'+suggestion.datarecargo+'" data-plataforma="'+suggestion.plataforma+'"';
							
							suggestion.plataforma == "si" ? html += 'data-tarifaP="'+tarifaP+'"' : "";
							
							html += ' style="display:none;"></span>';
							
							$('#datosCliente').html(html);
							$('#g_numcliente').html(suggestion.datanumcliente);
							$('#g_cliente').html(suggestion.datanombre);
							$('#g_direccion').html(suggestion.datadir);
							$('#g_cp').html(suggestion.datacp);
							$('#g_localidad').html(suggestion.dataloc);
							$('#g_cif').html(suggestion.datacif);

				        }

				    });
				
				}else{

					loader.quitarPeque();
								
					$('#errores').find('div#errorR').remove();

					var html 			= '<div id="errorR">'+
						'<div id="cerrarR"><h6>x</h6></div>'+
						'<p>No hay clientes para crear un albaran.</p>'+
						'</div>';
					
					var $wrong = $(html).hide().fadeIn(1000);
					
					$('#errores').append($wrong).css('display','block');
				
					$(document).scrollTop( 0 );
				
					$('#errorR').delay(3000).fadeOut("slow");

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
	//CLIENTES QUE PAGAN EN EFECTIVO
	efectivo : function(){	// Revisada

		loader.cargando("Cargando clientes");
		
		$.post("../php/class.php",
			{
				peClientes:"peClientes"
			},function(res){		

				if(res != null){	

					var tarifaP = 0;
					var clientesArray = new Array();
					
					for(var x=0; x<res.length; x++){
					
						clientesArray[x] = { 
							value : res[x].nombre, 
							datanumcliente:res[x].num_cliente, 
							datanombre : res[x].nombre, 
							datarecargo	: res[x].recargo,
							datadir	: res[x].direccion,
							datacp : res[x].cp,
							dataloc : res[x].localidad,
							datacif	: res[x].cif,
							plataforma : res[x].plataforma
						};
					
					}

					$.post("../php/class.php",
						{
							tarifaP : "tarifaP"
						},
						function(res){

							callback(res.valor);
						
						},"json"
					)

					.fail(function(xhr, ajaxOptions, thrownError){
					
						console.log(xhr.status)
						console.log(xhr.responseText)
						console.log(thrownError)
						//comun.failErrors(xhr, ajaxOptions, thrownError);		
					
					});

					function callback(tarifa){
						
						tarifaP = tarifa;
						
						loader.quitarPeque();
					
					}

				    $('#allClientes').autocomplete({
				    
				        lookup: clientesArray,
				    
				        onSelect: function (suggestion) {
				    
				        	var html = '<span id="clienteSeleccionado" data-numcliente="'+suggestion.datanumcliente+'" data-nombre="'+suggestion.datanombre+'" '+
								'data-recargo="'+suggestion.datarecargo+'" data-plataforma="'+suggestion.plataforma+'"';
							
							suggestion.plataforma == "si" ? html += 'data-tarifaP="'+tarifaP+'"' : "";
							
							html += ' style="display:none;"></span>';
							
							$('#datosCliente').html(html);
							$('#g_numcliente').html(suggestion.datanumcliente);
							$('#g_cliente').html(suggestion.datanombre);
							$('#g_direccion').html(suggestion.datadir);
							$('#g_cp').html(suggestion.datacp);
							$('#g_localidad').html(suggestion.dataloc);
							$('#g_cif').html(suggestion.datacif);
				        
				        }
				    
				    });

				}else{
					loader.quitarPeque();
								
					$('#errores').find('div#errorR').remove();

					var html 			= '<div id="errorR">'+
						'<div id="cerrarR"><h6>x</h6></div>'+
						'<p>No hay clientes para crear una factura.</p>'+
						'</div>';
					
					var $wrong = $(html).hide().fadeIn(1000);
					
					$('#errores').append($wrong).css('display','block');
				
					$(document).scrollTop( 0 );
				
					$('#errorR').delay(3000).fadeOut("slow");
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
	// CLIENTES RECIBO
	recibo : function(){ // Revisada

		loader.cargando("Cargando clientes");

		$.post("../php/class.php",
			{
				peClientes : "peClientes"
			},function(res){		

				if(res != null){	

					var tarifaP 			= 0;
					var clientesArray 		= new Array();

					for(var x=0; x<res.length; x++){
					
						clientesArray[x] 	= { 
							value 			: res[x].nombre, 
							datanumcliente 	: res[x].num_cliente, 
							datanombre 		: res[x].nombre, 
							datarecargo 	: res[x].recargo,
							datadir 		: res[x].direccion,
							datacp 			: res[x].cp,
							dataloc 		: res[x].localidad,
							datacif 		: res[x].cif,
							plataforma 		: res[x].plataforma
						};
					}

					$.post("../php/class.php",
						{
							tarifaP : "tarifaP"
						},
						function(res){
							
							callback(res.valor);
					
						},"json"
					
					)
					.fail(function(xhr, ajaxOptions, thrownError){
					
						console.log(xhr.status)
						console.log(xhr.responseText)
						console.log(thrownError)
						//comun.failErrors(xhr, ajaxOptions, thrownError);		
					
					});	

					function callback(tarifa){
						
						tarifaP = tarifa;
						
						loader.quitarPeque();
				
					}

				    $('#allClientes').autocomplete({
				
				        lookup: clientesArray,
				
				        onSelect: function (suggestion) {
				            if (confirm("¿El cliente desea el recibo con I.V.A.?")){
				                
				                iva = 10;
			    	            
			    	            if (confirm("¿El cliente desea el recibo con recargo de equivalencia?")){

					                suggestion.datarecargo = "si";
					            
					            }else{
					            
					                suggestion.datarecargo = "no";
					            
					            }
				            
				            }else{
				            
				                iva = 0;
				            
				                suggestion.datarecargo = "no";
				            
				            }
				        	var html = '<span id="clienteSeleccionado" data-numcliente="'+suggestion.datanumcliente+'" data-nombre="'+suggestion.datanombre+'" ';
							
							suggestion.datarecargo == "si" ? html += 'data-recargo="'+suggestion.datarecargo+'"' : 'data-recargo="no"';
							
							html += 'data-plataforma="'+suggestion.plataforma+'"';
							
							suggestion.plataforma == "si" ? html += 'data-tarifaP="'+tarifaP+'"' : "";
							
							html += ' style="display:none;"></span>';
							
							$('#datosCliente').html(html);
							$('#g_numcliente').html(suggestion.datanumcliente);
							$('#g_cliente').html(suggestion.datanombre);
							$('#g_direccion').html(suggestion.datadir);
							$('#g_cp').html(suggestion.datacp);
							$('#g_localidad').html(suggestion.dataloc);
							$('#g_cif').html(suggestion.datacif);
				        
				        }
			
				    });

				}else{

					loader.quitarPeque();
								
					$('#errores').find('div#errorR').remove();

					var html 			= '<div id="errorR">'+
						'<div id="cerrarR"><h6>x</h6></div>'+
						'<p>No hay clientes para crear un recibo.</p>'+
						'</div>';
					
					var $wrong = $(html).hide().fadeIn(1000);
					
					$('#errores').append($wrong).css('display','block');
				
					$(document).scrollTop( 0 );
				
					$('#errorR').delay(3000).fadeOut("slow");

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
	//FORMAS DE PAGO
	formasPago : function(){ // Revisada
		
		loader.cargando("Cargando fomas de pago"); 
		
		$.post("../php/class.php",
			{
				formaPago : "formapago"
			},function(res){

				if(res != null){

					var html = '<option value="0">Formas de pago</option>';
				
					for(var x=0; x<res.length; x++){
				
						html += '<option value="'+res[x].cod_fp+'">'+res[x].forma_pago+'</option>';
				
					}
				
					$('#formapago').html(html);

					loader.quitarPeque();
				}else{
					var html = '<option value="">No hay formas de pago</option>';
				
					$('#formapago').html(html);

					loader.quitarPeque();
				}
			
			},"json")

		.fail(function(xhr, ajaxOptions, thrownError){

			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	

		});

	}

};

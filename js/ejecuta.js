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

//AÑADIRMOS UN NUEVO ALBARAN / LA FACTURA CORRESPONDIENTE
$('#addAlbaran').on("click",function(){

	//Declaramos los arrays para el posterios Json
	var jsonCliente        	= new Array();
	var jsonProductos 	   	= new Array();
	var jsonAlbaran        	= new Array();

	//Datos que introduciremos en el json
	var j_numcliente 	   	= $('#clienteSeleccionado').data('numcliente');
	var j_cliente 		   	= $('#g_cliente').html();
	var j_direccion 	   	= $('#g_direccion').html();
	var j_cp 			   	= $('#g_cp').html();
	var j_localidad 	   	= $('#g_localidad').html();
	var j_cif  			   	= $('#g_cif').html();
	var j_total_p 		   	= $('#total_p').text();
	var j_total_i 		   	= $('#total_i').text();
	var j_total_r 		   	= $('#total_r').text();
	var j_total 		   	= $('#total').text();
	//var j_num_albaran 	   	= $('#num_albaran').html();
	var j_fecha_expedicion 	= $('#fecha_expedicion').html();
	var numeroProductos    	= $('.producto');
	var y                  	= 0;

	jsonCliente 			= {
		numcliente 			: j_numcliente,
		cliente    			: j_cliente,
		direccion  			: j_direccion,
		cp         			: j_cp,
		localidad  			: j_localidad,
		cif        			: j_cif
	};

	jsonAlbaran 			= {
		total_p          	: j_total_p,
		total_i          	: j_total_i,
		total_r          	: j_total_r,
		total            	: j_total,
		//num_albaran      	: j_num_albaran,
		fecha_expedicion 	: j_fecha_expedicion
	};

	$('.producto').each(function(){

		j_cod_producto   	= $(this).data('id');
		j_nombre         	= $(this).find('.nombre').data('val');
		j_cantidad       	= $(this).find('.cantidad').data('val');
		j_precioUnitario 	= $(this).find('.precioUnitario').data('val');
		j_dto            	= $(this).find('.dto').data('val');
		j_totalUnitario  	= $(this).find('.totalUnitario').data('val');

		jsonProductos[y] 	= {
			cod_producto   	: j_cod_producto,
			nombre         	: j_nombre,
			cantidad       	: j_cantidad,
			precioUnitario 	: j_precioUnitario,
			dto            	: j_dto,
			totalUnitario  	: j_totalUnitario
		};

		y++;

	});
	
	var JSONString = JSON.stringify([jsonCliente, jsonProductos, jsonAlbaran]);

	if(j_numcliente != "" && numeroProductos.length > 0){

		loader.guardando("Guardando albaran");
		
		$.post("../php/class.php",
			{
				addAlbaran 	: "addAlbaran",
				jsonFull 	: JSONString
			},
			function(res){
				
				if(res == 1){
			
					window.location.href = "resumenFinal.php";	
			
				}
			}
		)
		.fail(function(xhr, ajaxOptions, thrownError){

			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		

		});

	}else{

		comun.capturarErrores();

	}

});

//AÑADIMOS UNA NUEVA FACTURA
$('#addFactura').on("click",function(){
	//Declaramos los arrays que iran en el json
	var jsonCliente		   	= new Array();
	var jsonProductos 	   	= new Array();
	var jsonFactura 	   	= new Array();

	var j_numcliente 	   	= $('#clienteSeleccionado').data('numcliente');
	var j_cliente 		   	= $('#g_cliente').html();
	var j_direccion 	   	= $('#g_direccion').html();
	var j_cp 			   	= $('#g_cp').html();
	var j_localidad 	   	= $('#g_localidad').html();
	var j_cif 			   	= $('#g_cif').html();
	var j_total_p 	       	= $('#total_p').text();
	var j_total_i    	   	= $('#total_i').text();
	var j_total_r 		   	= $('#total_r').text();
	var j_total 		   	= $('#total').text();
	var j_fecha_expedicion 	= $('#fecha_expedicion').html();
	var numeroProductos    	= $('.producto');
	var y 				  	= 0;

	jsonCliente 			= {
		numcliente       	: j_numcliente,
		cliente          	: j_cliente,
		direccion        	: j_direccion,
		cp 				 	: j_cp,
		localidad 		 	: j_localidad,
		cif 			 	: j_cif
	};

	jsonFactura				= {
		total_p 		 	: j_total_p,
		total_i 		 	: j_total_i,
		total_r 		 	: j_total_r,
		total 			 	: j_total,
		fecha_expedicion 	: j_fecha_expedicion
	};

	
	$('.producto').each(function(){
		j_cod_producto 	 	= $(this).data('id');
		j_nombre 		 	= $(this).find('.nombre').data('val');
		j_cantidad 		 	= $(this).find('.cantidad').data('val');
		j_precioUnitario 	= $(this).find('.precioUnitario').data('val');
		j_dto            	= $(this).find('.dto').data('val');
		j_totalUnitario  	= $(this).find('.totalUnitario').data('val');

		jsonProductos[y] 	= {
			cod_producto   	: j_cod_producto,
			nombre 		   	: j_nombre,
			cantidad 	   	: j_cantidad,
			precioUnitario 	: j_precioUnitario,
			dto 		   	: j_dto,
			totalUnitario  	: j_totalUnitario
		};

		y++;
	
	});
	
	var JSONString = JSON.stringify([jsonCliente, jsonProductos, jsonFactura]);

	if(j_numcliente != "" && numeroProductos.length > 0){

		loader.guardando("Guardando factura");

		$.post("../php/class.php",
			{
				addFactura : "addFactura",
				jsonFull : JSONString
			},
			function(res){
				
				if(res == 1){
			
					window.location.href = "resumenFinal.php";	
			
				}
				
			}
		)	
		.fail(function(xhr, ajaxOptions, thrownError){
		
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		
		
		});
	
	}else{
	
		comun.capturarErrores();
	
	}

});

//AÑADIMOS UN NUEVO RECIBO
$('#addRecibo').on("click",function(){
	//Declaramos los arrays para el posterior json
	var jsonCliente 		= new Array();
	var jsonProductos 		= new Array();
	var jsonRecibo 			= new Array();

	var j_numcliente 		= $('#clienteSeleccionado').data('numcliente');
	var j_cliente 			= $('#g_cliente').html();
	var j_direccion 		= $('#g_direccion').html();
	var j_cp 				= $('#g_cp').html();
	var j_localidad 		= $('#g_localidad').html();
	var j_cif 				= $('#g_cif').html();

	var j_total_p 			= $('#total_p').text();
	var j_total_i 			= $('#total_i').text();
	var j_total_r 			= $('#total_r').text();
	var j_total 			= $('#total').text();
	//var j_num_recibo 		= $('#num_recibo').html();
	var j_fecha_expedicion 	= $('#fecha_expedicion').html();
	var numeroProductos 	= $('.producto');
	var y 					= 0;

	jsonCliente 			= {
		numcliente 			: j_numcliente,
		cliente 			: j_cliente,
		direccion 			: j_direccion,
		cp 					: j_cp,
		localidad 			: j_localidad,
		cif 				: j_cif
	};
	
	jsonRecibo 				= {
		total_p 			: j_total_p,
		total_i 			: j_total_i,
		total_r 			: j_total_r,
		total 				: j_total,
	//	num_recibo 			: j_num_recibo,
		fecha_expedicion 	: j_fecha_expedicion
	};

	$('.producto').each(function(){

		j_cod_producto 		= $(this).data('id');
		j_nombre 			= $(this).find('.nombre').data('val');
		j_cantidad 			= $(this).find('.cantidad').data('val');
		j_precioUnitario 	= $(this).find('.precioUnitario').data('val');
		j_dto 				= $(this).find('.dto').data('val');
		j_totalUnitario 	= $(this).find('.totalUnitario').data('val');

		jsonProductos[y] 	= {
			cod_producto    : j_cod_producto,
			nombre 			: j_nombre,
			cantidad 		: j_cantidad,
			precioUnitario 	: j_precioUnitario,
			dto 			: j_dto,
			totalUnitario 	: j_totalUnitario
		};

		y++;

	});
	
	var JSONString = JSON.stringify([jsonCliente, jsonProductos, jsonRecibo]);

	if(j_numcliente != "" && numeroProductos.length > 0){

		loader.guardando("Guardando recibo");
		
		$.post("../php/class.php",
			{
				addRecibo	: "addRecibo",
				jsonFull	: JSONString
			},
			function(res){

				if(res == 1){
					window.location.href = "resumenFinal.php";	
				}

			}
		)
		.fail(function(xhr, ajaxOptions, thrownError){
	
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		
	
		});
	
	}else{
	
		comun.capturarErrores();
	
	}

});

//AÑADIMOS UN NUEVO CLIENTE
$('#addCliente').on("click",function(){
	
	var jsonNuevoCliente 	= new Array();
	var c_nombre 			= $('#nombre').val();
	var c_direccion 		= $('#direccion').val();
	var c_cp 				= $('#cp').val();
	var c_localidad 		= $('#localidad').val();
	var c_nombre_contacto 	= $('#nombre_contacto').val();
	var c_telefono 			= $('#telefono').val();
	var c_movil 			= $('#movil').val();
	var c_email 			= $('#email').val();
	var c_formapago 		= $('#formapago').val();
	var c_cif 				= $('#cif').val();
	var c_recargo 			= "si";
	var c_plataforma 		= "no";
	
	$('label.recargo').each(function(){
		if($(this).find('input').is(':checked')){
			c_recargo = $(this).find('input:radio:checked').val()
		}
	});
	$('label.plataforma').each(function(){
		if($(this).find('input').is(':checked')){	
			c_plataforma = $(this).find('input:radio:checked').val()
		}
	});

	jsonNuevoCliente 		= {
		nombre 				: c_nombre,
		direccion 			: c_direccion,
		cp 					: c_cp,
		localidad 			: c_localidad,
		nombre_contacto 	: c_nombre_contacto,
		telefono 			: c_telefono,
		movil 				: c_movil,
		email 				: c_email,
		formapago 			: c_formapago,
		cif 				: c_cif,
		recargo 			: c_recargo,
		plataforma 			: c_plataforma
	};

	var JSONString = JSON.stringify(jsonNuevoCliente);

	if(c_nombre != "" && c_direccion != "" && c_cp != "" && c_localidad != "" && c_nombre_contacto != "" && c_telefono != "" && c_email != "" && c_formapago != "" && c_cif != ""){
		
		loader.guardando("Guardando cliente");
		
		$.post("../php/class.php",
			{
				addCliente 	: "addCliente",
				jsonFull   	: JSONString
			},
			function(res){
				if(res == 1){
					loader.quitarGrande();
					
					var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
						'<div id="resumen">'+
						'<div id="cerrarV"><h6>x</h6></div>'+
						'<p>Cliente añadido correctamente.</p>'+
						'</div>'+
						'</div>';
					
					$('#resume_general').html(html);	
					
					$(document).scrollTop( 0 );
					
					$('#reporte').delay(3000).fadeOut("slow");
				
						$('#nombre').val("");
						$('#direccion').val("");
						$('#cp').val("");
						$('#localidad').val("");
						$('#nombre_contacto').val("");
						$('#telefono').val("");
						$('#movil').val("");
						$('#email').val("");
						$('#formapago').val("");
						$('#cif').val("");
						clientes.formasPago();
						
						$('.form-group').each(function(){
							$('input').attr('style','');
							$('span.input-icon').attr('style','');
						});

				}else{

					loader.quitarGrande();

					var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
							'<div id="resumenR">'+
						 	'<div id="cerrarR"><h6>x</h6></div>'+
						 	'<p>No se ha podido añadir el cliente.</p>'+
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
				 	'<p>No se ha podido añadir el cliente.</p>'+
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

//AÑADIMOS UN NUEVO CLIENTE
$('#addUsuario').on("click",function(){

	var jsonNuevoUsuario 	= new Array();
	var u_nombre 			= $('#nombre').val();
	var u_apellidos 		= $('#apellidos').val();
	var u_direccion 		= $('#direccion').val();
	var u_cp 				= $('#cp').val();
	var u_localidad 		= $('#localidad').val();
	var u_telefono 			= $('#telefono').val();
	var u_movil 			= $('#movil').val();
	var u_email 			= $('#email').val();
	var u_dni				= $('#dni').val();
	var u_password 			= $('#password').val();
	var u_rpassword			= $('#rpassword').val();
	var u_tipo 				= "2";

	$('label.tipo').each(function(){
		if($(this).find('input').is(':checked')){	
			u_tipo = $(this).find('input:radio:checked').val()
		}
	});

	console.log('tipo '+u_tipo)

	jsonNuevoUsuario 		= {
		nombre 				: u_nombre,
		apellidos 			: u_apellidos,
		direccion 			: u_direccion,
		cp 					: u_cp,
		localidad 			: u_localidad,		
		telefono 			: u_telefono,
		movil 				: u_movil,
		email 				: u_email,
		dni 				: u_dni,
		password 			: u_password,
		tipo 	 			: u_tipo
	};

	var JSONString = JSON.stringify(jsonNuevoUsuario);

	if(u_nombre != "" && u_apellidos != "" && u_direccion != "" && u_cp != "" && u_localidad != "" && u_telefono != "" && u_email != "" && u_dni != "" && u_password != "" && u_rpassword != ""){
		
		loader.guardando("Guardando empleado");
		
		if(u_password == u_rpassword){
				
			$.post("../php/class.php",
				{
					addUsuario 	: "addUsuario",
					jsonFull   	: JSONString
				},
				function(res){

					if(res == 1){

						loader.quitarGrande();
						
						var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
							'<div id="resumen">'+
							'<div id="cerrarV"><h6>x</h6></div>'+
							'<p>Empleado añadido correctamente.</p>'+
							'</div>'+
							'</div>';
						
						$('#resume_general').html(html);	
						
						$(document).scrollTop( 0 );

						$('#reporte').delay(3000).fadeOut("slow");

						$('#nombre').val("");
						$('#apellidos').val("");
						$('#direccion').val("");
						$('#cp').val("");
						$('#localidad').val("");							
						$('#telefono').val("");
						$('#movil').val("");
						$('#email').val("");
						$('#dni').val("");
						$('#password').val("");
						$('#rpassword').val("");

						$('.form-group').each(function(){
							$('input').attr('style','');
							$('span.input-icon').attr('style','');
						});

					}else{

						loader.quitarGrande();

						var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
								'<div id="resumenR">'+
							 	'<div id="cerrarR"><h6>x</h6></div>'+
							 	'<p>No se ha podido añadir el empleado.</p>'+
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
					 	'<p>No se ha podido añadir el cliente.</p>'+
						'</div>'+
						'</div>';
			
				$('#resume_general').html(html);	
			
				$(document).scrollTop( 0 );
			
				$('#reporte').delay(3000).fadeOut("slow");		

			});

		}else{

			loader.quitarGrande();

			var html = '<div class="col-md-4 col-md-offset-4" id="reporte">'+
					'<div id="resumenR">'+
				 	'<div id="cerrarR"><h6>x</h6></div>'+
				 	'<p>Las contraseñas no son iguales.</p>'+
					'</div>'+
					'</div>';
		
			$('#resume_general').html(html);	
		
			$(document).scrollTop( 0 );
		
			$('#reporte').delay(3000).fadeOut("slow");	

    		$('#password').css('color','#e74c3c').css('border','2px solid #e74c3c');
    		$('#password').parent().find('.input-icon').css('color','#e74c3c');
           
            $('#rpassword').css('color','#e74c3c').css('border','2px solid #e74c3c');
            $('#rpassword').parent().find('.input-icon').css('color','#e74c3c');
		}

	}else{
	
		comun.capturarErrores();
	
	}

});

/*#######################################################################################
				CARGA CATEGORIAS/PRODUCTOS
#######################################################################################*/

//CARGA TODAS LAS CATEGORIAS
$('#allClientes').on('change',function(){ //Revisada

	loader.cargando("Cargando categorias");
	
	$.post("../php/class.php",
		{
			categorias:"categorias"
		},
		function(res){		

			if(res != null){

				var html = '<option value="">Categorias</option>';
				
				for(var x=0; x<res.length; x++){
				
					html += '<option value="'+res[x].cod_categoria+'">'+res[x].nom_categoria+'</option>';
				}
				
				$('#categorias').html(html);
				
				loader.quitarPeque();
			
			}else{

				var html = '<option value="">No hay categorias</option>';
				
				$('#categorias').html(html);
				
				loader.quitarPeque();
			
			}

		},"json"

	).fail(function(xhr, ajaxOptions, thrownError){
	
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);	
	
	});

});

//CARGA TODOS LOS PRODUCTOS
$('#categorias').on('change',function(){ //Revisada
	
	$('#productos').val("");
	$('#cantidadU').val("0");
	$('#cantidadC').val("0");

	var cliente = $('#clienteSeleccionado').data("numcliente");

	loader.cargando("Cargando productos");
	
	$.post("../php/class.php",
		{
			selCategoria 	: 'selCategoria',
			cod_categoria 	: $(this).val(),
			num_cliente 	: cliente

		},function(res){

			console.log(res[0])

			var productosArray 	= new Array();
			var general 		= res[0];
			var productos 		= res[1];
			var x 				= 0;

			if(general != null){

				for (var i = 0; i < general.length; i++) {

				    productosArray[x] = { 
				    	value 			: general[i].nom_producto, 
				    	datacod 		: general[i].cod_producto, 
				    	datanombre 		: general[i].nom_producto+' - '+general[i].peso_gramos+'g/unid', 
				    	datatarifa 		: general[i].tarifa, 
				    	dataprecio 		: general[i].precio, 
				    	datastock 		: general[i].stock, 
				    	datacaja 		: general[i].unidades_caja, 
				    	dataaplicable 	: general[i].especial 
				    };
				    
				    x++;
				}

			}

			if(productos != null){
			
				for (var i = 0; i < productos.length; i++) {
				
				    productosArray[x] = { 
				    	value 			: productos[i].nom_producto+' - '+productos[i].peso_gramos+'g/unid', 
				    	datacod 		: productos[i].cod_producto, 
				    	datanombre 		: productos[i].nom_producto+' - '+productos[i].peso_gramos+'g/unid', 
				    	datatarifa 		: productos[i].tarifa, 
				    	dataprecio 		: productos[i].precio, 
				    	datastock 		: productos[i].stock, 
				    	datacaja 		: productos[i].unidades_caja, 
				    	dataaplicable 	: productos[i].oferta 
				    };
				
				    x++;
				
				}

			}		
			
			loader.quitarPeque();
		    
		    $('#productos').autocomplete({

		        lookup: productosArray,

		        onSelect: function (suggestion) {
		        	var html = '<span id="productoSelecionado" data-val="'+suggestion.datacod+'" data-nombre="'+suggestion.datanombre+'" '+
						'data-tarifa="'+suggestion.datatarifa+'" data-precio="'+suggestion.dataprecio+'" data-stock="'+suggestion.datastock+'" '+
						'data-caja="'+suggestion.datacaja+'" data-aplicable="'+suggestion.dataaplicable+'" style="display:none;"></span>';
					
					$('#datosProducto').html(html);			
		        }

		    });

		    $('#productos').focus();

		},"json"
	
	)

	.fail(function(xhr, ajaxOptions, thrownError){
	
			console.log(xhr.status)
			console.log(xhr.responseText)
			console.log(thrownError)
			//comun.failErrors(xhr, ajaxOptions, thrownError);		
	
	});

});

//AÑADIMOS PRODUCTOS A LA LISTA
$('#addProductos').on("click","#add",function(){

	var cod_producto 	= $('#productoSelecionado').data('val');
	var producto 		= $('#productoSelecionado').data('nombre');
	var precio 			= $('#productoSelecionado').data('precio');
	var unidadesCaja 	= $('#productoSelecionado').data('caja');
	var stock 			= $('#productoSelecionado').data('stock');
	var plataforma 		= $('#clienteSeleccionado').data("plataforma");
	var aplicable 		= $('#productoSelecionado').data("aplicable");
	var tarifaP 		= $('#clienteSeleccionado').data("tarifap");
	var tarifa 			= $('#productoSelecionado').data('tarifa');
	var cantidadU 		= $('#cantidadU').val();
	var cantidadC 		= $('#cantidadC').val();
	var cantidad 		= 0;
	var dto 			= 0;
	var precioUnitario 	= null;
	var nuevaCantidad 	= null;
	var totalUnitario 	= null;
	var repetido 		= false;

	if( cantidadU != 0 && cantidadC == 0 ){
	
		cantidad 		= cantidadU;
	
	}else if( cantidadC != 0 && cantidadU == 0 ){
	
		cantidad 		= parseInt(cantidadC) * parseInt(unidadesCaja);

	}else if( cantidadC != 0 && cantidadU != 0 ){
	
		cantidadUC 		= parseInt(cantidadC) * parseInt(unidadesCaja);
	
		cantidad 		= parseInt(cantidadUC) + parseInt(cantidadU);
	}



	if(producto != undefined && !isNaN(cantidad) && cantidad != 0){

		
		$('tr').each(function(){
		
			if($(this).data("id") == cod_producto){
		
				var indiceExistente 	= $(this).find('.indice').data("val")
				var cantidadExistente 	= $(this).find('.cantidad').data("val")

				if(aplicable == "si"){

					precio 			= parseFloat(precio);
					tarifa 			= parseFloat(tarifa);
					precioUnitario 	= ((precio * tarifa) / 100) + precio;
				
					cantidadExistente 	= parseFloat(cantidadExistente);
					cantidad 			= parseFloat(cantidad);
					nuevaCantidad 		= cantidadExistente + cantidad;
				
					precioUnitario = Math.round(precioUnitario*100)/100;
					nuevaCantidad  = parseFloat(nuevaCantidad);
					totalUnitario  = precioUnitario * nuevaCantidad;
				
				}else{
				
					if(plataforma == "si"){
				
						precio 			= parseFloat(precio);
						tarifa 			= parseFloat(tarifa);
						precioUnitario 	= ((precio * tarifa) / 100) + precio;
					
						precioUnitario  = Math.round(precioUnitario*100)/100;
						tarifaP 		= parseFloat(tarifaP);
						precioUnitario 	= precioUnitario - ((precioUnitario * tarifaP) / 100);

						cantidadExistente 	= parseFloat(cantidadExistente);
						cantidad 			= parseFloat(cantidad);
						nuevaCantidad 		= cantidadExistente + cantidad;
					
						precioUnitario = Math.round(precioUnitario*100)/100;
						nuevaCantidad  = parseFloat(nuevaCantidad);
						totalUnitario  = precioUnitario * nuevaCantidad;

					}else{
				
						precio 			= parseFloat(precio);
						tarifa 			= parseFloat(tarifa);
						precioUnitario 	= ((precio * tarifa) / 100) + precio;
					
						cantidadExistente 	= parseFloat(cantidadExistente);
						cantidad 			= parseFloat(cantidad);
						nuevaCantidad 		= cantidadExistente + cantidad;
					
						precioUnitario = Math.round(precioUnitario*100)/100;
						nuevaCantidad  = parseFloat(nuevaCantidad);
						totalUnitario  = precioUnitario * nuevaCantidad;
				
					}
				
				}

				if(stock < nuevaCantidad){

					alert("Stock sobrepasado. Disponibles: "+stock)

					$('#cantidadU').val("0");

					$('#cantidadC').val("0");

					repetido = true;

			    	return false;

				}else{

					var linea = "<td><button class='eliminar btn btn-danger'>X</button></td><td class='indice' data-val='"+indiceExistente+"'>"+indiceExistente
						+"</td><td class='nombre' data-val='"+producto+"'>"+producto
						+"</td><td class='cantidad' data-val='"+nuevaCantidad+"' contenteditable='true'>"+nuevaCantidad
						+"</td><td class='precioUnitario' data-val='"+precioUnitario.toFixed(2)+"'>"+precioUnitario.toFixed(2)+""
						+"</td><td class='dto' data-val='"+dto+"'>"+dto
						+"</td><td class='totalUnitario' data-val='"+totalUnitario.toFixed(2)+"'>"+totalUnitario.toFixed(2)+"</td>";		    	
			    	
			    	$(this).html(linea);
			    	
			    	repetido = true;
			    	
			    	return false;

		    	}

			}

		});

		if(!repetido){

			if(aplicable == "si"){

				precio 			= parseFloat(precio);
				tarifa 			= parseFloat(tarifa);
				precioUnitario 	= ((precio * tarifa) / 100) + precio;
				
				precioUnitario = Math.round(precioUnitario*100)/100;
				cantidad 	   = parseFloat(cantidad);
				totalUnitario  = precioUnitario * cantidad;

			}else{
		
				if(plataforma == "si"){
		
					precio 			= parseFloat(precio);
					tarifa 			= parseFloat(tarifa);
					precioUnitario 	= ((precio * tarifa) / 100) + precio;
				
					precioUnitario  = Math.round(precioUnitario*100)/100;
					tarifaP 		= parseFloat(tarifaP);
					precioUnitario 	= precioUnitario - ((precioUnitario * tarifaP) / 100);
				
					precioUnitario = Math.round(precioUnitario*100)/100;
					cantidad 	   = parseFloat(cantidad);
					totalUnitario  = precioUnitario * cantidad;

				}else{
		
					precio 			= parseFloat(precio);
					tarifa 			= parseFloat(tarifa);
					precioUnitario 	= ((precio * tarifa) / 100) + precio;
				
					precioUnitario = Math.round(precioUnitario*100)/100;
					cantidad 	   = parseFloat(cantidad);
					totalUnitario  = precioUnitario * cantidad;
		
				}
		
			}

			if(stock < cantidad){
				
				alert("Stock sobrepasado. Disponibles: "+stock)
				
				$('#cantidadU').val("0");
				
				$('#cantidadC').val("0");
				
				repetido = false;

			}else{
				
				cont++;
				
				linea = "<tr class='producto' data-id='"+cod_producto+"'><td><button class='eliminar btn btn-danger'>X</button></td>"
					+"<td class='indice' data-val='"+cont+"'>"+cont
					+"</td><td class='nombre' data-val='"+producto+"'>"+producto
					+"</td><td class='cantidad' data-val='"+cantidad+"' contenteditable='true'>"+cantidad
					+"</td><td class='precioUnitario' data-val='"+precioUnitario.toFixed(2)+"'>"+precioUnitario.toFixed(2)+""
					+"</td><td class='dto' data-val='"+dto+"'>"+dto
					+"</td><td class='totalUnitario' data-val='"+totalUnitario.toFixed(2)+"'>"+totalUnitario.toFixed(2)+"</td></tr>";			    	
	
		    	$('#contenidoF').append(linea);
	
		    	repetido = false;
	    	}
	
		}
		
		$('#cantidadU').val("0");

		$('#cantidadC').val("0");
		
		comun.calcularTotal();
	
	}

});


/*#######################################################################################
				ELIMINAR FILAS
#######################################################################################*/

//ELIMINAR FILAS
$('#tabla').on("click",".eliminar",function(){
	
	var _cont 		= 0;
	var celda 		= $(this).parent();
	
	celda.parent().remove();
	
	$('.indice').each(function(){
	
		contador 	= $(this).data("val");
	
		if(!isNaN(contador)){		
	
			_cont++;
	
			$(this).data("val",_cont);
	
			$(this).html(_cont);
	
		}	
	
	});
	
	cont--;
	comun.calcularTotal();
})

/*#######################################################################################
				AVISO ERROR
#######################################################################################*/

//FUNCION QUE CIERRA LA VENTANA DE LOS ERRORES
$('#errores').on('click','#cerrarR',function(){
	$('#errorR').remove().fadeOut(1000);
});

//FUNCION QUE CIERRA LA VENTANA DE LOS ERRORES
$('#errores').on('click','#cerrarV',function(){
	$('#errorV').remove().fadeOut(1000);
});
var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false,false);
	listar();

	

	//Cargamos los items al select proveedor
	$.post("../ajax/reporteIncidentes.php?op=selectCliente", function(r){
		$("#idoperario").html(r);
		$("#idoperario").selectpicker('refresh');
	});	
	$.post("../ajax/reporteIncidentes.php?op=selectSector", function(r){
		for(let i=1;i<4;i++){
		$("#idarea"+i).html(r);
		$('#idarea'+i).selectpicker('refresh');}
});	
$("#imagenmuestra1").hide();
$("#imagenmuestra2").hide();
$("#imagenmuestra3").hide();

}

//Función limpiar
function limpiar()
{	
	$("#idreporte").val("");
	$("#idoperario").val("");
	$("#idoperario").selectpicker('refresh');
	$("#idcliente").selectpicker('refresh');
	$("#operario").val("");
	$("#idarea1").val("");
	$("#idarea2").val("");
	$("#idarea3").val("");
	$("#idarea1").selectpicker('refresh');
	$("#idarea2").selectpicker('refresh');
	$("#idarea3").selectpicker('refresh');
	$("#operario").val("");
	$("#idcliente").val("");
	$("#titulo").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#fecha_incidente").val("");
	$("#descripcion").val("");
	$("#analisis").val("");
	$("#cierre").val("");
	$("#involucrados").val("");
	
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");
	$("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#imagen").val("");


	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val("");

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag1,flag2)
{
	//limpiar();
	if(flag1 && flag2)
	{

		$.post("../ajax/reporteIncidentes.php?op=getMaxReporte", function(r){
			console.log(r);
			$('#num_comprobante').val(r);
		});
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#listadocabecera").hide();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#archivoCierre").hide();
		$("#buttonArchivos").hide();
		$("#btnAnalisis").hide();
		$("#btnVerFotos").hide();
		$("#btnAgrFotos").show();
		$("#rowFotos").show();
		$("#btnCierre").hide();
		$("#btnGuardar").hide();
		$("#btnDescripcion").show();
		$("#btnReportar").hide();
		$("#imagenmuestra").hide();
		$("#btnCerrar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
		
		$("#btnGuardar").prop('disabled', false);
		$('#titulo').prop('readonly', false);
		$('#num_comprobante').prop('readonly', true);
		$('#idarea1').prop('disabled', false);
		$('#involucrados').prop('readonly', false);
		$('#fecha_incidente').prop('readonly', false);
		$('#idoperario').prop('disabled', false);
		$('#idarea2').prop('disabled', false);
		$('#idarea3').prop('disabled', false);
		$("#idarea1").selectpicker('refresh');
		$("#idoperario").selectpicker('refresh');
		$("#idarea2").selectpicker('refresh');
		$("#idarea3").selectpicker('refresh');
		$("#buttonsPanel").show();
		$("#btnAgrDescripcion").show();
		

	}

	else if(!flag1 && flag2)
    {
		$("#archivoCierre").hide();
		$("#buttonArchivos").show();
        $("#listadoregistros").hide();
		$("#listadocabecera").show();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
		
		$("#btnAnalisis").show();
		$("#btnCierre").show();
		$("#btnDescripcion").hide();
		
    }

	else if(!flag1 && !flag2)
    {
        $("#listadoregistros").show();
		$("#listadocabecera").hide();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }

/*
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
*/
}

//Función cancelarform
function cancelarform()
{$(".img-slider-vertical").empty();
$("#estadoBox").remove();
	limpiar();
	mostrarform(false,false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/reporteIncidentes.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				columnDefs: [
							
							{
								targets: 7,
								render: function(data, type, row, meta) {
									if (type === 'sort') {
										console.log(data)
									  switch (data) {
										case '<span class="label bg-yellow">Aceptado</span>':
										return 0;
										case '<span class="label bg-blue">En Proceso</span>':
										return 1;
										case '<span class="label bg-green">Cerrado</span>':
										return 2;
										case '<span class="label bg-red">Anulado</span>':
										return 3;
									  }
									}
									  return data;
									}
							},
							 {
							 	targets: [1],
							 	orderData: [1, 0],
							 },
						],
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	     "order": [[7,"asc"]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función ListarArticulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/reporteIncidentes.php?op=listarArticulos',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

function listarArticulosUno(idartubi)
{
    //var arrIdArticulo = JSON.stringify(idarticulo);
	tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/reporteIncidentes.php?op=listarArticulosUno',
                    data: {idartubi:idartubi},
					type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
}


//Función para guardar o editar

function guardaryeditar(e, formDataImagen)
{
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	for (const [key, value] of formDataImagen.entries()) {
		  // Verifica si la clave coincide con el campo que deseamos obtener
		//   if (key.includes( 'imagen1')) {
		    formData.append('imagen1[]',value)
		//   }
		}

	// Display the key/value pairs
	for (var pair of formData.entries()) {
		console.log(pair[0]+ ', ' + pair[1]); 
	}
	
	$.ajax({
		url: "../ajax/reporteIncidentes.php?op=guardaryeditar",
	    type: "POST",
		async:false,
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);
			  	          
	          mostrarform(false,false);
	          listar();
			  setTimeout(
				()=>{
					location.reload()
				},'1500'
			)
	    },
		error:function(error){
			console.log(error);
		}

	});
	limpiar();
}

//FUNCION QUE DECLARA EL REPORTE "EN PROCESO"
function procesar(e, flagReporteCierre, formDataArchivos)
{
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	console.log(formDataArchivos)
	if(formDataArchivos != undefined){
	for (const [key, value] of formDataArchivos.entries()) {
		// Verifica si la clave coincide con el campo que deseamos obtener
	  //   if (key.includes( 'imagen1')) {
		  formData.append('archivoCierre[]',value)
	  //   }
	  }
	}
	// Display the key/value pairs
	for (var pair of formData.entries()) {
		console.log(pair[0]+ ', ' + pair[1]); 
	}
	
	$.ajax({
		url: "../ajax/reporteIncidentes.php?op=procesar&flag="+flagReporteCierre,
	    type: "POST",
		async:false,
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);
			  	          
	          mostrarform(false,false);
	          listar();
			  setTimeout(
				()=>{
					location.reload()
				},'1500'
			)
	    },
		error:function(error){
			console.log(error);
		}

	});
	limpiar();
}

//FUNCION QUE MUESTRA EL REPORTE (A SUPERVISORES)
function mostrar(idreporte, estado, creador)
{
	$.post("../ajax/reporteIncidentes.php?op=mostrar",{idreporte : idreporte}, function(data, status)
	{
		console.log(data);	
		data = JSON.parse(data);	
		mostrarform(false,true);

		$("#titulo").val(data.titulo);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#idarea1").val(data.areaAfectada);
		$("#idarea1").selectpicker('refresh');
		
		
		$("#idreporte").val(data.idreporte);
		
		var imagenesArray = data.imagen.split(',');
		console.log(data.imagen+'\n'+imagenesArray);
		$("#imagenGrande").attr("src","../files/reportes/imagenes/"+imagenesArray[0]); //agregamos el atributo src para mostrar la imagen
		if(imagenesArray[0] !=''){
			$("#rowFotos").show();
			$("#btnVerFotos").show();
			$("#imagenmuestra"+0).show(); 
		}
		else{
			$("#rowFotos").hide();
		}
		for(let i=0;i < (imagenesArray.length-1);i++){
			$(".img-slider-vertical").append('<label><input type="checkbox" class="img-check" name="img-check">'
			+'<img class="checked-img" width="100" height="100" id="imagenmuestra'+i+'" src="../files/reportes/imagenes/'+imagenesArray[i]+'"'
			+'onmouseover="selectImage('+i+'); $(\'#imagenGrande\').attr(\'src\',$(\'#imagenmuestra'+i+'\').attr(\'src\'));"'
			+' onclick=""/></label>')
			
			
			if(imagenesArray[i] !=''){
				$("#imagenmuestra"+i).show(); 
			}
			
		}
		$("#imagenmuestra"+0).css('border','3px solid blue')
		
		// $("#imagenactual1").val(imagenesArray[0]);
		// $("#imagenactual2").val(imagenesArray[1]);
		// $("#imagenactual3").val(imagenesArray[2]);

		//Ocultar y mostrar los botones
		// $("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
		if(permisoAdministrador != 1 && creador != nombreSession){
		if(estado === 'Aceptado'){
			$("#btnAgrDescripcion").show();
		}else{
			$("#btnAgrDescripcion").hide();

		}}else if(permisoAdministrador == 1 && creador != nombreSession){
			$("#btnAgrDescripcion").hide();
		}
		else{
			$("#btnAgrDescripcion").show();

		}
		$("#btnAgrAnalisis").hide();
		$("#btnAnalisis").show();
		$("#cierre").attr('readonly',true);
		$("#archivoCierre").hide();
		$("#buttonArchivos").hide();
		$("#btnCierre").show();
		$("#btnCerrar").hide();
		$("#btnReportar").hide();
		$("#btnDescripcion").show();
		$("#buttonsPanel").hide();
		$("#btnCerrarModalCierre").unbind('click');
		$("#btnCerrarModalCierre").click(()=>{$('#modalCierre').modal('hide')})
		$("#crossCerrarModalCierre").unbind('click');
		$("#crossCerrarModalCierre").click(()=>{$('#modalCierre').modal('hide')})
 	});

 	$.post("../ajax/reporteIncidentes.php?op=listarDetalle&id="+idreporte,function(data,status){
		 data = JSON.parse(data);
		 console.log(data);
		$("#involucrados").val(data.involucrados);
		$("#descripcion").val(data.descripcion);
		$("#analisis").val(data.analisis);
		$("#cierre").val(data.cierre);
		$("#fecha_incidente").val(data.fecha_incidente);
		$("#idoperario").val(data.idoperario);
		$("#idoperario").selectpicker('refresh');
		$("#idarea2").val(data.idsectorNotificado);
		$("#idarea2").selectpicker('refresh');
		$("#idarea3").val(data.idsectorInvolucrados);
		$("#idarea3").selectpicker('refresh');
		$("#btnAgrFotos").hide();
		$('#titulo').prop('readonly', true);
		$('#num_comprobante').prop('readonly', true);
		$('#idarea1').prop('disabled', true);
		$('#involucrados').prop('readonly', true);
		$('#fecha_incidente').prop('readonly', true);
		$('#idoperario').prop('disabled', true);
		$('#idarea2').prop('disabled', true);
		$('#idarea3').prop('disabled', true);
	});	
	
	$(".box-title").append('<div id="estadoBox" >'+estado+'</div>')
	switch(estado){
		case 'Aceptado':
			$("#estadoBox").attr("class",'label bg-yellow')
		break;
		case 'Anulado':
			$("#estadoBox").attr("class",'label bg-red')
		break;
		case 'Cerrado':
			$("#estadoBox").attr("class",'label bg-green')
		break;
		case 'En Proceso':
			$("#estadoBox").attr("class",'label bg-blue')
		break;

	}
}
//FUNCION QUE CARGA EL FORMULARIO PARA EDITAR (Sólo Martín)
function editar(idreporte, estado, creador)
{
	$.post("../ajax/reporteIncidentes.php?op=mostrar",{idreporte : idreporte}, function(data, status)
	{
		console.log(data);	
		data = JSON.parse(data);	
		mostrarform(false,true);
		$("#archivoCierre").hide();
		$("#buttonArchivos").show();
		$("#titulo").val(data.titulo);
		$('#titulo').prop('readonly', true);
		$("#num_comprobante").val(data.num_comprobante);
		$('#num_comprobante').prop('readonly', true);
		$('#cierre').attr('readonly', false);
		$("#fecha_hora").val(data.fecha);
		$("#idarea1").val(data.areaAfectada);
		$("#idarea1").selectpicker('refresh');
		$('#idarea1').prop('disabled', true);
		var imagenesArray = data.imagen.split(',');
		console.log(data.imagen+'\n'+imagenesArray);
		$("#imagenGrande").attr("src","../files/reportes/imagenes/"+imagenesArray[0]); //agregamos el atributo src para mostrar la imagen
		if(imagenesArray[0] !=''){
			$("#rowFotos").show();
			$("#btnVerFotos").show();
			$("#imagenmuestra"+0).show(); 
		}
		else{
			$("#rowFotos").hide();
		}
		for(let i=0;i < (imagenesArray.length-1);i++){
			$(".img-slider-vertical").append('<label><input type="checkbox" class="img-check" name="img-check">'
			+'<img class="checked-img" width="100" height="100" id="imagenmuestra'+i+'" src="../files/reportes/imagenes/'+imagenesArray[i]+'"'
			+'onmouseover="selectImage('+i+'); $(\'#imagenGrande\').attr(\'src\',$(\'#imagenmuestra'+i+'\').attr(\'src\'));"'
			+' onclick=""/></label>')
			
			
			if(imagenesArray[i] !=''){
				$("#imagenmuestra"+i).show(); 
			}
			
		}
		$("#imagenmuestra"+0).css('border','3px solid blue')
			// *******BOTONES POR ESTADO ***************
			$("#idreporte").val(idreporte);
			if(estado === 'En Proceso' && permisoAdministrador != 1){
				$("#btnReportar").attr('disabled', true);
			}
			// else if(estado === 'Aceptado'){
				// $("#btnReportar").attr('disabled', true);
				// $("#btnCerrar").attr('disabled', true);
				//  }
				if(permisoAdministrador == 1 && nombreSession != creador){
					$("#btnAgrDescripcion").hide();
					// $("#btnReportar").attr('disabled', false);
		}
		else{
			$("#btnAgrDescripcion").show();

		}
		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnAgrFotos").hide();
		$("#btnGuardar").attr('disabled', true);
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
		$("#btnAgrAnalisis").show();
		$("#btnReportar").hide();
		$("#btnCierre").show();
		$("#btnCerrar").hide();
		$("#buttonsPanel").show();
		$("#btnDescripcion").show();
 	});

 	$.post("../ajax/reporteIncidentes.php?op=listarDetalle&id="+idreporte,function(data,status){
		 data = JSON.parse(data);
		 console.log(data);
		$("#involucrados").val(data.involucrados);
		$('#involucrados').prop('readonly', true);
		$("#descripcion").val(data.descripcion);
		$("#analisis").val(data.analisis);
		$("#cierre").val(data.cierre);
		$("#fecha_incidente").val(data.fecha_incidente);
		$('#fecha_incidente').prop('readonly', true);
		$("#idoperario").val(data.idoperario);
		$("#idoperario").selectpicker('refresh');
		$('#idoperario').prop('disabled', true);
		$("#idarea2").val(data.idsectorNotificado);
		$("#idarea2").selectpicker('refresh');
		$('#idarea2').prop('disabled', true);
		$("#idarea3").val(data.idsectorInvolucrados);
		$("#idarea3").selectpicker('refresh');
		$('#idarea3').prop('disabled', true);
		$("#btnCerrarModalCierre").unbind('click');
		$("#btnCerrarModalCierre").click(()=>{confirmarDocumentos()})
		$("#crossCerrarModalCierre").unbind('click');
		$("#crossCerrarModalCierre").click(()=>{confirmarDocumentos()})
	});	

	//ETIQUETAS POR ESTADO DEL REPORTE
	$(".box-title").append('<div id="estadoBox" >'+estado+'</div>')
	switch(estado){
		case 'Aceptado':
			$("#estadoBox").attr("class",'label bg-yellow')
		break;
		case 'Anulado':
			$("#estadoBox").attr("class",'label bg-red')
		break;
		case 'Cerrado':
			$("#estadoBox").attr("class",'label bg-green')
		break;
		case 'En Proceso':
			$("#estadoBox").attr("class",'label bg-blue')
		break;

	}
}

//Función para anular registros
function anular(idreporte)
{
	bootbox.confirm("¿Está seguro de anular el reporte?", function(result){
		if(result)
        {  
			bootbox.prompt({
				title: 'Motivo de la anulación',
				callback:function(motivo){
					if(motivo != '' && motivo != null && motivo != ' '){
					$.post("../ajax/reporteIncidentes.php?op=anular&idreporte="+idreporte+"&motivo="+motivo, function(e){
						bootbox.alert(e);
						tabla.ajax.reload();
					});
				} else{
					bootbox.alert("Debe escribir un motivo.");
				}
				}

			})
        		
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
// $("#btnGuardar").show();
// $("#tipo_comprobante").change(marcarImpuesto);

// function marcarImpuesto()
//   {
//   	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
//   	if (tipo_comprobante=='Factura')
//     {
//         $("#impuesto").val(impuesto); 
//     }
//     else
//     {
//         $("#impuesto").val("0"); 
//     }
//   }




// function agregarDetalle(idarticulo,idubi_origen,articulo,descripcion,categoria,subcategoria,codigo,codigo_origen,cantidad)
// {
//     //var cantidad = 1;
//     var precio_compra = 1;
//     var precio_venta = 3;
// 	var idubi_destino = 1;
// 	var codigo_destino = "EXT";
// 	console.log('Valor de cantidad -> '+cantidad);
// 	if(idarticulo != "")
//     {
//         //var subtotal = cantidad * precio_compra;
//         var fila = '<tr class="filas" id="fila'+cont+'"> ' +
//                       '<td>'+
//                            '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
//                        '</td>'+
// 					  '<td>' +
//                           '<input type="hidden" name="codigo[]" value="'+codigo+'">'+
//                            codigo +
//                        '</td>'+
//                       '<td>' +
//                           '<input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+
//                            articulo +
//                        '</td>'+
// 					  '<td>' +
//                           '<input type="hidden" name="descripcion[]" value="'+descripcion+'">'+
// 						  descripcion +
//                        '</td>'+
// 					  '<td>' +
//                           '<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
// 						  //'<input type="number" step="0.01" name="cantidad[]" min="0" max="'+cantidad+'" id="cantidad[]" value="'+cantidad+'">'+
//                        '</td>'+
//                       '<td>' +
//                           '<input type="hidden" name="idubi_origen[]" value="'+idubi_origen+'">'+codigo_origen+
//                        '</td>'+
// 					  '<td>' +
//                           '<input type="hidden" name="idubi_destino[]" value="'+idubi_destino+'">'+codigo_destino+
//                        '</td>'+ 
//                    '</tr>';

//         cont++;
//         detalles++;
//         $("#detalles").append(fila);
//         //modificarSubtotales(); 
//     }
//     else
//     {
//         alert("Error al ingresar el detalle, revisar los datos del articulo");
//     }
	
// 	evaluar();
	
// 	consultarDetalle();

// }
// function consultarDetalle()
// {	
// 	var idart = document.getElementsByName("idarticulo[]");
// 	var idubi = document.getElementsByName("idubi_origen[]");
// 	var canti = document.getElementsByName("cantidad[]");
// 	var tamañoCant = idart.length;
// 	console.log('Valor de tamañoCant -> '+tamañoCant);
// 	var idartubi = '';
// 	for (var i=0;i<tamañoCant;i++){
// 	idartubi += idubi[i].value+','+idart[i].value+','+canti[i].value+',';
// 	}
// 	console.log('Valor de idartubi -> '+idartubi);
// 	if (tamañoCant !== 0){  
// 		listarArticulosUno(idartubi);
// 	}else{
// 		listarArticulos();
// 	}

// }


//
// function cancelarFotos(){
// var imagen1 = $("#imagen1").val();
// var imagen2 = $("#imagen2").val();
// var imagen3 = $("#imagen3").val();
// $("#imagen1").val(imagen1);
// $("#imagen2").val(imagen2);
// $("#imagen3").val(imagen3);
// // }

// function modificarSubototales()
// {
//   	var cant = document.getElementsByName("cantidad[]");
//     var prec = document.getElementsByName("precio_venta[]");
//     var desc = document.getElementsByName("descuento[]");
//     var sub = document.getElementsByName("subtotal");

//     for (var i = 0; i <cant.length; i++) {
//     	var inpC=cant[i];
//     	var inpP=prec[i];
//     	var inpD=desc[i];
//     	var inpS=sub[i];

//     	inpS.value=(inpC.value * inpP.value)-inpD.value;
//     	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
//     }
//     calcularTotales();

// }

// function calcularTotales(){
//   	var sub = document.getElementsByName("subtotal");
//   	var total = 0.0;

//   	for (var i = 0; i <sub.length; i++) {
// 		total += document.getElementsByName("subtotal")[i].value;
// 	}
// 	$("#total").html("S/. " + total);
//     $("#total_venta").val(total);
//     evaluar();
//   }

function evaluar(){
  	if (detalles=0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
}

function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
}

//FUNCION QUE MUESTRA LOS BOTONES DE SUBMIT (GUARDAR,PROCESAR Y CERRAR) SEGÚN EL CAMPO ESCRITO
//RECIBE EL FLAG CORRESPONDIENTE A CADA ACCIÓN
function activeButtons(flagGuardar,flagProcesar,flagCerrar){
	$("#buttonsPanel").show();
	if(flagGuardar){
		$("#btnGuardar").show();}
	if(flagProcesar){
		$("#btnReportar").show();}
		if(flagCerrar){
			$("#btnCerrar").show();}
			console.log(nombreSession) 
	if(permisoAdministrador != 1){
		$("#btnGuardar").attr('disabled',false);
	}	  
	if(!flagGuardar && !flagProcesar && !flagCerrar){
		$("#btnGuardar").hide();
		$("#btnReportar").hide();
		$("#btnCerrar").hide();
	}
		

}

//FUNCIÓN QUE SELECCIONA LA IMAGEN EN EL VISOR DE IMÁGENES
//RECIBE UN CONTADOR DE IMAGENES
function selectImage(contador){
$(".checked-img").css('border', '0')
$("#imagenmuestra"+contador).css('border','3px solid blue')
}

//FUNCION QUE GENERA UNA CADENA DE TEXTO ALEATORIA
//RECIBE UNA LONGITUD DE CARACTERES
function getRandomString(length){
	var text=""
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"
	for(var i=0; i < length; i++){
	text += possible.charAt(Math.floor(Math.random() * possible.length));

	}
return text;
}

//FUNCION QUE DETERMINA EL ÁREA DEL SUPERVISOR ELEGIDO
function setAreaNotificado(){
	var idpersona = $("#idoperario").val()

	$.post("../ajax/reporteIncidentes.php?op=setAreaNotificante&idpersona="+idpersona, function(r){
		data = JSON.parse(r)
		console.log(data.idsector)
		$("#idarea2").val(data.idsector)
		$("#idarea2").selectpicker('refresh')
		// $("#idarea2").attr('readonly','readonly')
});	



}

//FUNCION QUE MANEJA EL MODAL DE CIERRE 
function promptCierre(){
	var form = document.createElement("form");
	var fileInput = document.createElement("input");
	var textInput = document.createElement("input");
	
	fileInput.type = "file";
	textInput.type = "text";
	
	form.appendChild(fileInput);
	form.appendChild(textInput);

	bootbox.prompt({
		title: 'Cierre del incidente:',
		message:form,
		closeButton: false,
		buttons: {
			cancel: {
				className: 'btn_cancel' }
		},
		value:$('#cierre').val(),
		callback: function (result) {
		console.log(result);
		$('#cierre').val(result);
		if(result != ''){
		activeButtons(false,false,true)};
		}
		});
}

//FUNCION QUE VALIDA EL CIERRE DEL REPORTE
function handleCierre(){
	if($("#cierre").val() === '' || $("#cierre").val() === ' '){
		// $("#buttonsPanel").hide();
		activeButtons(false,false,false)
	}
	else{
		activeButtons(false,false,true)
		// $("#buttonsPanel").show();
	}
}

//FUNCION PARA ELEGIR VER EL REPORTE CON O SIN LOS DOCUMENTOS ENDORSADOS
function abrirDocumentos(archivosString, urlReporte){
	
	if(archivosString === "") {
		window.open(urlReporte,'_blank')
	}
	else {
		bootbox.confirm({
			message:"El reporte posee adjuntados multiples archivos, abrir todos?",
			buttons:{
				confirm:{
					label:'Abrir',
					className:'btn-success multiple-tab-button',
					}
					,
				cancel:{
					label:'Sólo Reporte',
					className:'btn-danger'
					}
				},
			callback: function(r){
				if(!r){
					window.open(urlReporte,'_blank')
				}
			}
		})
	}
	$(".multiple-tab-button").click(function(e){
		if(archivosString != null){
			archivosString = archivosString.slice(0, -1);
			var archivosArray = archivosString.split(',');
			console.log(archivosArray);
			for(let i = 0; i < archivosArray.length; i++){
			window.open('../files/reportes/documentos/'.concat(archivosArray[i]),'_blank')
			}
			window.open(urlReporte,'_blank')
		}
	})
	

}

//FUNCION QUE RECUERDA EL AGREGADO DE DOCUMENTACIÓN (EN CIERRE)
function confirmarDocumentos(){
	if($("#archivoCierre").val() === ''){
	bootbox.confirm({
		  message:"Desea añadir documentación?",
		  buttons:{
		    cancel:{
		      label:"Si",
		      className:"btn-success"
		      },
		      confirm:{
		        label:"No",
		        className:"btn-danger"
		        }
		  },
		  callback:function(result){
		    if(result){
				$('#modalCierre').modal('hide')

			}

	
			
		      }})}
			  else $('#modalCierre').modal('hide')
}

init();
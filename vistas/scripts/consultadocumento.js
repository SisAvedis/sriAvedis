var tabla;

//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select sector
    $.post("../ajax/documento.php?op=selectSector", function (r) {
        $("#idsector").html(r);
        $("#idsector").selectpicker("refresh");
    });	

}

function limpiar()
{
	//$("#iddocumento").val("");
	//$("#observacion").val("");
	//$("#idsector").val("");
	$(".filas").remove();
}

function listar()
{
    mostrarform(false);
	
	var idsector = $("#idsector").val();

	//console.log('Valor de idcategoria -> '+idcategoria);

    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/consultas.php?op=consultadocumento',
                    data:{idsector:idsector},
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

//Función mostrar formulario
function mostrarform(flag1)
{
	
	limpiar();
	if(flag1)
	{
		$("#listadoregistros").hide();
		$("#detalles").show();
		$("#btnCancelar").show();
		detalles=0;
	}

	else
    {
        $("#listadoregistros").show();
		$("#detalles").hide();
        $("#btnCancelar").hide();
    }
}

function cancelarform()
{
	limpiar();
	mostrarform(false);
}

function mostrar(iddocumento)
{
	
	mostrarform(true);
	
 	$.post("../ajax/consultas.php?op=listarDetalle&id="+iddocumento,function(r){
	        $("#detalles").html(r);
	});	
	
}

init();
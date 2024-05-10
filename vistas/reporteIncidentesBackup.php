<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['ABM']==1)
{
?>
<style>
  .form-control{
    height:2.8em;
  }
  .bootbox-input-textarea{
    min-height:25em;
  }
  .btn_cancel{
    display: none;
  }
</style>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Reporte de Incidentes <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true,true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>Acción</th>
                            
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Tiempo</th>
                            <th>Operario</th>
                            <th>Area afectada</th>
                            <th>Número</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Acción</th>
                            
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Tiempo</th>
                            <th>Operario</th>
                            <th>Area afectada</th>
                            <th>Número</th>
                            <th>Estado</th>
                           </tfoot>
                        </table>
                    </div>
		
					<div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST" onsubmit="return false">
                          <div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Área Afectada:</label>
                            <select name="areaAfectada" id="idarea1" class="form-control selectpicker" required="">
                            </select>
                            
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Título:</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" maxlength="50" placeholder="Titulo">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha_incidente" id="fecha_incidente" required>
                          </div>
                         
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero">
                          </div>
                          <!-- </div>
                          <div class="row"> -->
                          
                          </div>
                          <div class="row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Notificado Por:</label>
                            <input type="hidden" name="idreporte" id="idreporte">
                            <select title="<b>Seleccione un Operario</b>" id="idoperario" name="idoperario" class="form-control" data-live-search="true" required>
                              
                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Área:</label>
                            <select name="areaNotificado" id="idarea2" class="form-control selectpicker" required="">
                            </select>
                            
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Involucrados:</label>
                            <textarea  class="form-control" name="involucrados" id="involucrados" ></textarea>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Área:</label>
                            <select name="areaInvolucrados" id="idarea3" class="form-control selectpicker" required="">
                            </select>
                            
                          </div>
                          
                          </div>

                          <div class="row" id="rowFotos">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
                <!-- <input type="hidden" id="descripcion" name="descripcion" value="" > -->
                <a data-toggle="modal" href="#modalFotos" class="btn btn-primary" id="btnAgrFotos" ><i class="fa fa-plus"></i> Agregar Fotos</a>
             
                                </div>
              <div class="modal fade" id="modalFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Fotos: </h4>
        </div>
        <div class="modal-body">

<div class="row">
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Imagen 1:</label>
                              <button type="button" class="close" onclick="$('#imagen1').val('')" aria-hidden="true">&times;</button>
                              <input type="file" class="form-control" name="imagen1" id="imagen1">
                              <input type="hidden" class="form-control" name="imagenactual1" id="imagenactual1">
                              <!-- <img src="" width="150px" height="120px" id="imagenmuestra1"> -->
                            </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Imagen 2:</label>
                              <button type="button" class="close" onclick="$('#imagen2').val('')" aria-hidden="true">&times;</button>
                              <input type="file" class="form-control" name="imagen2" id="imagen2">
                              <input type="hidden" class="form-control" name="imagenactual2" id="imagenactual2">
                              <!-- <img src="" width="150px" height="120px" id="imagenmuestra2"> -->
                            <!-- </div> -->
                            </div>
                            <!-- <div class="row"> -->
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Imagen 3:</label>
                              <button type="button" class="close" onclick="$('#imagen3').val('')" aria-hidden="true">&times;</button>
                              <input type="file" class="form-control" name="imagen3" id="imagen3">
                              <input type="hidden" class="form-control" name="imagenactual3" id="imagenactual3">
                              <!-- <img src="" width="150px" height="120px" id="imagenmuestra3"> -->
                            </div>
                            <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        </div>  
                            </div>
                            
                            </div>
                            </div>
                          </div>
                          </div>
</div>
<!-- </div> -->

<!-- <div class="row"> -->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;"  >
                <!-- <input type="hidden" id="descripcion" name="descripcion" value="" > -->
                <a data-toggle="modal" href="#modalVerFotos" class="btn btn-primary"  id="btnVerFotos"><i class="fa fa-eye"></i> Ver Fotos</a>
             
                                </div>
              <div class="modal fade" id="modalVerFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 80% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Imágenes del Incidente: </h4>
        </div>
        <div class="modal-body" >

<div class="row" onmouseleave="$('#myresult2').hide();">
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- <label>Imagen 1:</label> -->
                              <input type="hidden" class="form-control" name="imagenactual1" id="imagenactual1">
                              <div class="img-zoom-container">
                              <img   width="100" height="100" id="imagenmuestra1" onclick="$('#imagenGrande').attr('src',$('#imagenmuestra1').attr('src'));">
                              </div>
                            <!-- </div> -->
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <!-- <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12"> -->
                              <!-- <label>Imagen 2:</label> -->
                              <input type="hidden" class="form-control" name="imagenactual2" id="imagenactual2">
                              <div class="img-zoom-container">
                              <img   width="100" height="100" id="imagenmuestra2" onclick="$('#imagenGrande').attr('src',$('#imagenmuestra2').attr('src'));"">
                              
                              </div>
                            <!-- </div> -->
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <!-- <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12"> -->
                              <!-- <label>Imagen 3:</label> -->
                              <input type="hidden" class="form-control" name="imagenactual3" id="imagenactual3">
                             
                              <img   width="100" height="100" id="imagenmuestra3" onclick="$('#imagenGrande').attr('src',$('#imagenmuestra3').attr('src'));">
                              
                            <!-- </div> -->
                          </div>
                          <div class="col-10">
                            <img  width="300" height="300"   id="imagenGrande"  onmouseover="$('#myresult2').show();imageZoom('imagenGrande', 'myresult2');">
                            <div class="img-zoom-container"> 
                            <div id="myresult2" class="img-zoom-result"></div>
                           </div>
                            </div>
                            </div>
                            </div>
                          </div>
                          </div>
</div>
</div>

                  <div class="row">
              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
                <!-- <input type="hidden" id="descripcion" name="descripcion" value="" > -->
                <a data-toggle="modal" href="#modalDescripcion" class="btn btn-warning" id="btnDescripcion"><i class="fa fa-save"></i> Descripción</a>
             
                                </div>
                               
                               
    <!-- **********************MODAL DESCRIPCION********************* -->
    
                                <div class="modal fade" id="modalDescripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 60% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Descripción del Incidente: </h4>
        </div>
        <div class="modal-body">
          <textarea class="d-flex justify-content-center"  id="descripcion" name="descripcion" readonly  cols="30" rows="10" style="width:100%"></textarea>
          <div class="form-group col-4">
          <button class="btn btn-warning" type="button" id="btnAgrDescripcion" onclick="bootbox.prompt({
                                title: 'Nueva Descripción:',
                                inputType: 'textarea',
                                // value:$('#descripcion').val(),
                                // buttons: {
                                //     cancel: {
                                //         className: 'btn_cancel' }
                                // },
                                closeButton: false,
                                callback: function (result) {
                                console.log(result);
                                fecha = new Date();
                               año = fecha.getFullYear();
                               mes = fecha.getMonth();
                               dia = fecha.getDate();
                               hora = fecha.toLocaleString().substr(10);
                                descripcionValor =  $('#descripcion').val();
                                if(result != '' && result != null && result != ' '){
                                  result = '['+dia+'/'+mes+'/'+año+hora+']'+' -'+result;
                                activeButtons(true,false,false)}
                                else{
                                  result = '';
                                }
                                if(descripcionValor != '' && result != '' 
                                && result != null && result != ' '){
                                  result = '\n'+result;
                                  $('#descripcion').val(descripcionValor+result);
                                }
                                else if (descripcionValor != '' && result === '' || descripcionValor != '' && result === null ){
                                  $('#descripcion').val(descripcionValor);
                                }
                                else{
                                  $('#descripcion').val(result);
                                }
                                  ;
                                $('.bootbox-input-textarea').attr('id', 'descripcion-text');
                                
                                $('#descripcion-text').val();
                                }
                              
                                });"><i class="fa fa-plus"></i>Agregar Item</button>
                                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div> <!-- FIN MODAL -->
  
  
  
  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
    <!-- <input type="hidden" id="analisis" name="analisis" value="" > -->
    <a data-toggle="modal" href="#modalAnalisis" class="btn btn-info" id="btnAnalisis"><i class="fa fa-save"></i>Análisis</a>
    
  </div>

             
             <div class="modal fade" id="modalAnalisis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
               <div class="modal-dialog" style="width: 80% !important;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Análisis del Incidente: </h4>
        </div>
        <div class="modal-body">
          <textarea  id="analisis" name="analisis" readonly  cols="30" rows="10" style="width:80%"></textarea>
          <div class="form-group col-4">
          <button class="btn btn-info " type="button" id="btnAgrAnalisis" onclick="bootbox.prompt({
                                title: 'Nuevo Análisis:',
                                inputType: 'textarea',
                                closeButton: false,
                                // buttons: {
                                //     cancel: {
                                //         className: 'btn_cancel' }
                                // },
                                // value:$('#analisis').val(),
                                callback: function (result) {
                                console.log(result);
                                fecha = new Date().toLocaleString('es-AR')
                                analisisValor =  $('#analisis').val();
                                if(result != '' && result != null && result != ' '){
                                  result = fecha+' -'+result;
                                activeButtons(false,true,false)}
                                else{
                                  result = '';
                                }
                                if(analisisValor != '' && result != '' && result != null && result != ' '){
                                  result = '\n'+result;
                                  $('#analisis').val(analisisValor+result);
                                }
                                else if (analisisValor != '' && result === '' || analisisValor != '' && result === null ){
                                  $('#analisis').val(analisisValor);
                                }
                                else{
                                  $('#analisis').val(result);
                                }
                                $('.bootbox-input-textarea').attr('id', 'analisis-text');
                                
                                $('#analisis-text').val();
                                }
                                });"><i class="fa fa-plus"></i>Agregar Item</button>
                                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div> 
            
                                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
              <input type="hidden" id="cierre" name="cierre" value="" >
              <button class="btn btn-success " type="button" id="btnCierre" onclick="bootbox.prompt({
                                title: 'Cierre del incidente:',
                                inputType: 'textarea',
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
                                });"><i class="fa fa-save"></i> Cierre</button>
							</div>
                              </div>
                            
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4" id="buttonsPanel">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-info" type="submit" id="btnReportar"><i class="fa fa-info"></i> Reportar</button>
                            <button class="btn btn-success" type="submit" id="btnCerrar"><i class="fa fa-check"></i> Cerrar</button>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">

                            <button id="btnCancelar" class="btn btn-danger" onclick="limpiar();cancelarform();" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                          
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<!--JQUERY VALIDATE -->
<script  src="../public/js/jquery-validate/dist/jquery.validate.js"></script>
<script type="text/javascript" src="scripts/reporteIncidentes.js"></script>
<script
  src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
  integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://10.10.0.104/sv/plugins/jquery-ui/jquery-ui.min.css">
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="../plugins/select2/css/select2.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
  <!-- <script src="../plugins/select2/js/select2.min.js"></script> -->
<!-- <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script> -->
<!-- <script src="../plugins/popper/popper.js"></script> -->
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> -->



<style>
  * {box-sizing: border-box;}

.img-zoom-container {
  position: relative;
}

#imagenGrande{
  position: absolute;
  left: 12em;
}

.img-zoom-lens {
  position: absolute;
  cursor:zoom-in;
  /* border: 1px solid #d4d4d4; */
  /*set the size of the lens:*/
  width: 40px;
  height: 40px;
}

.img-zoom-result {
  /* border: 1px solid #d4d4d4; */
  /*set the size of the result div:*/
  width: 300px;
  height: 300px;
  position: absolute;
  margin-left:42em;
}
.selected{
  border: 2px solid blue;
}

</style>
<script>
 

var sessionAdmin = "<?php echo $_SESSION["administracion"] ?>"
if(sessionAdmin != 1){
$("#btnAnalisis").hide();
$("#btnCierre").hide();

}

    
   $(document).ready(function() {
    
    $("#formulario").on("keypress", function (event) {
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                event.preventDefault();
                return false;
            }
        });

  $("#formulario").validate({
    ignore: [],
    rules: {
    'cantidad[]':{required:true},
    idoperario : {
      required: true,
      minlength: 1,
    },
  fecha_hora: {
    required: true,
    minlength: 3,
    },},
    /*checkForm: function() {
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
        if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
            }
        } else {
            this.check(elements[i]);
        }
    }
    return this.valid();
},*/
errorClass: "invalid"

  });
})
$("#btnGuardar").click( function(e) {
  $("#formulario").target = '_blank';
    console.log($("#formulario"));
  if ($('#formulario').valid()) {
    
  $("#formulario").submit();
  $("#formulario").on("submit",function(e)
  {
    //e.preventDefault();
    guardaryeditar(e);
   
    $("#formulario").validate().resetForm();
    /*bootbox.alert({
				message : "Extracción Registrada",
				timeOut : 5000
			})*/
  });
  }
});

$("#btnReportar").click( function(e) {
		$("#formulario").target = '_blank';
		console.log($("#formulario"));
    if ($('#formulario').valid()) {
     $("#formulario").submit();
		$("#formulario").on("submit",function(e)
  	{
      procesar(e, 'P');		
      $("#formulario").validate().resetForm();
    
  });
    }
	})

  $("#btnCerrar").click( function(e) {
		$("#formulario").target = '_blank';
		console.log($("#formulario"));
    if ($('#formulario').valid()) {
     $("#formulario").submit();
		$("#formulario").on("submit",function(e)
  	{
      procesar(e, 'C');		
      $("#formulario").validate().resetForm();
    
  });
    }
	})
jQuery.extend(jQuery.validator.messages,{
		required: "Este campo es obligatorio.",
		remote: "Please fix this field.",
		email: "Please enter a valid email address.",
		url: "Please enter a valid URL.",
		date: "Ingrese una fecha válida.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Ingrese un numero válido.",
		digits: "Please enter only digits.",
		equalTo: "Please enter the same value again.",
		maxlength: $.validator.format( "Ingrese no mas de {0} caracteres." ),
		minlength: $.validator.format( "Ingrese al menos {0} caracteres." ),
		rangelength: $.validator.format( "Please enter a value between {0} and {1} characters long." ),
		range: $.validator.format( "Ingrese un valor entre {0} y {1}." ),
		max: $.validator.format( "Ingrese un valor menor o igual a {0}." ),
		min: $.validator.format( "Ingrese un valor mayor o igual a {0}." ),
		step: $.validator.format( "Please enter a multiple of {0}." )
	},);

  $('.modal').css('overflow-y', 'auto');
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );


}

function getArray(callback){
 var operarios =[] ;
$.post("../ajax/reporteIncidentes.php?op=autoCliente", function(data){
  //console.log(data);
        var operarios = JSON.parse(data);
        callback(operarios);
            });	
  // console.log(operarios);
          }
  // $("#involucrados").autocomplete({
  //   source:"../ajax/venta.php?op=autoCliente",
  //   minLength: 1,
getArray(function(operarios){
// console.log(operarios)
  
  function split(val) {
    return val.split(",");
  }

    function extractLast(term) {
      return split(term).pop();
    }

  $("#involucrados")
    // don't navigate away from the field on tab when selecting an item
    .on("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB &&
        $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
    .autocomplete({
      minLength: 3,
      source: function(request, response) {
        // delegate back to autocomplete, but extract the last term
        response($.ui.autocomplete.filter(
          operarios, extractLast(request.term)));
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function(event, ui) {
        var terms = split(this.value);
        console.log(this)
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push(ui.item.value);
        // add placeholder to get the comma-and-space at the end
        terms.push("");
        this.value = terms.join(", ");
        return false;
      }
    });
})
  
function imageZoom(imgID, resultID) {
  var img, lens, result, cx, cy;
  img = document.getElementById(imgID);
  result = document.getElementById(resultID);
  /* Create lens: */
  lens = document.createElement("DIV");
  lens.setAttribute("class", "img-zoom-lens");
  /* Insert lens: */
  img.parentElement.insertBefore(lens, img);
  /* Calculate the ratio between result DIV and lens: */
  cx = result.offsetWidth / lens.offsetWidth;
  cy = result.offsetHeight / lens.offsetHeight;
  /* Set background properties for the result DIV */
  result.style.backgroundImage = "url('" + img.src + "')";
  result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
  /* Execute a function when someone moves the cursor over the image, or the lens: */
  lens.addEventListener("mousemove", moveLens);
  img.addEventListener("mousemove", moveLens);
  /* And also for touch screens: */
  lens.addEventListener("touchmove", moveLens);
  img.addEventListener("touchmove", moveLens);
  function moveLens(e) {
    var pos, x, y;
    /* Prevent any other actions that may occur when moving over the image */
    e.preventDefault();
    /* Get the cursor's x and y positions: */
    pos = getCursorPos(e);
    /* Calculate the position of the lens: */
    x = pos.x - (lens.offsetWidth / 2);
    y = pos.y - (lens.offsetHeight / 2);
    /* Prevent the lens from being positioned outside the image: */
    if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
    if (x < 0) {x = 0;}
    if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
    if (y < 0) {y = 0;}
    /* Set the position of the lens: */
    lens.style.left = x + "px";
    lens.style.top = y + "px";
    /* Display what the lens "sees": */
    result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
  }
  function getCursorPos(e) {
    var a, x = 0, y = 0;
    e = e || window.event;
    /* Get the x and y positions of the image: */
    a = img.getBoundingClientRect();
    /* Calculate the cursor's x and y coordinates, relative to the image: */
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    /* Consider any page scrolling: */
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {x : x, y : y};
  }
}

</script>


<?php 


}
ob_end_flush();
?>



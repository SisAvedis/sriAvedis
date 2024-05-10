<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT"); // Establecer una fecha de expiración en el pasado
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
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>Acción</th>
                            
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Tiempo</th>
                            <th>Creador</th>
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
                            <th>Creador</th>
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
                            <label>Área Afectada(*):</label>
                            <select name="areaAfectada" id="idarea1" class="form-control selectpicker" required="" data-live-search="true">
                            </select>
                            
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Título(*):</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" maxlength="50" placeholder="Titulo">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_incidente" id="fecha_incidente" required>
                          </div>
                         
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero">
                          </div>
                          
                          </div>
                          <div class="row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Notificado Por(*):</label>
                            <input type="hidden" name="idreporte" id="idreporte">
                            <select title="<b>Seleccione un Operario</b>" id="idoperario" name="idoperario" onchange="setAreaNotificado()" class="form-control" data-live-search="true" required>
                              
                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Área(*):</label>
                            <select name="areaNotificado" id="idarea2" class="form-control selectpicker" readonly required="">
                            </select>
                            
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Involucrados(*):</label>
                            <textarea  class="form-control" name="involucrados" id="involucrados" ></textarea>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Área(*):</label>
                            <select name="areaInvolucrados" id="idarea3" class="form-control selectpicker" required="" data-live-search="true">
                            </select>
                            
                          </div>
                          
                          </div>
<!-- **********************************************MODAL AGREGAR IMÁGENES************************************* -->
                          <div class="row" id="rowFotos">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12"  >
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
<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            <div  id="imagen-show" class="img-carrousel row">
            
              <div class="add-new-photo first" id="add-photo" onclick="$('#imagen1').click()">
                <span>
                  <i class="fa fa-camera"></i>
                  <p class="add-photo-title">Agregar<p>
                </span> 
              </div>

                <input type="file" class="form-control"  id="imagen1" onchange="handleUpload()" multiple>
             </div>
          </div>
                            <div class="modal-footer"> 
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                          </div>  
                            
                            </div>
                            </div>
                          </div>
                          </div>
</div>
<!-- ******************************************VISOR DE IMÁGENES********************************************* -->
                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"   >
                <a data-toggle="modal" href="#modalVerFotos" class="btn btn-primary"  id="btnVerFotos">
                  <i class="fa fa-eye"></i> Ver Fotos</a>
             
                                </div>
              <div class="modal fade" id="modalVerFotos" tabindex="-1" 
              role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 85% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Imágenes del Incidente: </h4>
        </div>
        <div class="modal-body" >

<div class="row img-vertical-slider" onmouseleave="$('#myresult2').hide();">
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="contenedor-vertical">
                              <div class="img-slider-vertical">
                                </div>
                          <div class="accionesImagen">
                            <div class="img-zoom-container"> 
                            <img  width="300" height="300"   id="imagenGrande"  onmouseover="$('#myresult2').show();imageZoom('imagenGrande', 'myresult2');">
                            <div id="myresult2" class="img-zoom-result"></div>
                           </div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                          </div>
    </div>
    </div>
    
    
    <!-- **************************************DESCRIPCIÓN DEL REPORTE********************* -->
    
    <div class="row">
      <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
      <a data-toggle="modal" href="#modalDescripcion" class="btn btn-warning" id="btnDescripcion"><i class="fa fa-save"></i> Descripción</a>
      </div>
       
      <!-- MODAL DESCRIPCIÓN -->
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
                                      closeButton: false,
                                      callback: function (result) {
                                      console.log(result);
                                      fecha = new Date();
                                    año = fecha.getFullYear();
                                    mes = fecha.getMonth();
                                    dia = fecha.getDate();
                                    hora = fecha.toLocaleString().substr(10);
                                    fechaStr = fecha.toLocaleString();
                                      descripcionValor =  $('#descripcion').val();
                                      if(result != '' && result != null && result != ' '){
                                        result = '['+fechaStr.replace(',', '')+' '+nombreSession+']'+' -'+result;
                                      activeButtons(true,false,false)}
                                      else{
                                        result = '';
                                      }
                                      if(descripcionValor != '' && result != '' && result != null && result != ' '){
                                        result = '\n'+result;
                                        activeButtons(true,false,false)
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
  
  
  <!-- ***************************************ANALISIS DE REPORTE********************************************** -->
  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
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
                                          callback: function (result) {
                                          console.log(result);
                                          fecha = new Date();
                                        año = fecha.getFullYear();
                                        mes = fecha.getMonth();
                                        dia = fecha.getDate();
                                        hora = fecha.toLocaleString().substr(10);
                                        fechaStr = fecha.toLocaleString();
                                          analisisValor =  $('#analisis').val();
                                          if(result != '' && result != null && result != ' '){
                                            result = '['+fechaStr.replace(',', '')+']'+' -'+result;
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
<!-- ****************************************CIERRE DE REPORTE************************************* -->
                                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" style="margin-top:2em;" >
              <a data-toggle="modal" href="#modalCierre"><button class="btn btn-success " type="button" id="btnCierre" ><i class="fa fa-save"></i> Cierre</button></a>
							</div>
              <div class="modal fade" id="modalCierre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
               <div class="modal-dialog" style="width: 80% !important;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" id="crossCerrarModalCierre" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Cierre del Incidente: </h4>
        </div>
        <div class="modal-body">
          <textarea  id="cierre" name="cierre" cols="30" rows="10" style="width:80%" onchange="handleCierre()"></textarea>
          <br>
          <input type="file" id="archivoCierre"  onchange="handlePdf()" multiple >
          <button class="btn btn-default" id="buttonArchivos" onclick="$('#archivoCierre').click();">Agregar Documentos 
            <i class="fa fa-folder"></i>
          </button>
          <ul id="listaArchivosCierre">
                                            
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnCerrarModalCierre" class="btn btn-default" >Cerrar</button>
        </div>        
      </div>
    </div>
  </div> 
<!-- ***********************************FIN MODALES DE REPORTE*************************************** -->
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
  src="../public/js/jquery-ui-1-13-2.js"
  ></script>
<!-- Latest compiled and minified CSS -->

<!-- Latest compiled and minified JavaScript -->

<!-- *********************************ESTILOS*************************************** -->

<style>
  * {box-sizing: border-box;}

.img-zoom-container {
  position: relative;
}

#imagenGrande{
  position: absolute;
  left: 12em;
  cursor:zoom-in;
}

.img-zoom-lens {
  position: absolute;
  cursor:zoom-in;
  width: 40px;
  height: 40px;
}

.img-zoom-result {
  width: 300px;
  height: 300px;
  position: absolute;
  margin-left:38em;
}
.selected{
  border: 2px solid blue;
}
.img-show{
  width: 100px;
  height: 100px;
  margin:5px;
}
/* Imágenes */

.img-carrousel figure {
    position: relative;
}

.img-carrousel img {
    height: 15em;
    width: 15em;
}

.img-carrousel figure figcaption {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.4);
    color: #fff;
    font-size: 44px;
    cursor: pointer;
    opacity: 0;
    transition: 0.3s all ease;
    -webkit-transition: 0.3s all ease;
    -moz-transition: 0.3s all ease;
    -ms-transition: 0.3s all ease;
    -o-transition: 0.3s all ease;
}

.img-carrousel figure figcaption:hover {
    opacity: 1;
}

/* ->Imágenes */

/* Selector de imágenes */

 .add-new-photo {
    text-align: center;
    display: flex;
    margin-right:5px;
    margin-top:3px;
    border: 4px dashed #3c8dbc;
    height: 4.2em;
    min-width: 4em;
    justify-content: center;
    align-items: center;
    font-size: 50px;
    color: #3c8dbc;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s all ease;
    -webkit-transition: 0.3s all ease;
    -moz-transition: 0.3s all ease;
    -ms-transition: 0.3s all ease;
    -o-transition: 0.3s all ease;
}
.add-new-photo i{
  margin: 0
}

.add-photo-title{
  font-size: .5em;
}

 .add-new-photo.first:hover {
    background: rgba(255, 255, 255, 0.17);
}

#add-photo-container input {
    display: none;
}

/* ->Selector de imágenes */

.img-carrousel{
  overflow-x: auto;
  display:flex;
  margin:5px;
}
.img-carrousel input{
  display:none
}
.img-slider-vertical{
  overflow-x: hidden;
  overflow-y: auto;
  width: 120px;
  height:30em;
}
.img-slider-vertical::-webkit-scrollbar-track {
  background-color: whitesmoke;
}
.img-slider-vertical::-webkit-scrollbar {
  width: 10px;
}
.img-slider-vertical::-webkit-scrollbar-thumb {
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.4);
  background-color: lightblue;
  border-radius: 5px;
}
.img-carrousel::-webkit-scrollbar-track {
  background-color: whitesmoke;
}
.img-carrousel::-webkit-scrollbar {
  width: 10px;
}
.img-carrousel::-webkit-scrollbar-thumb {
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.4);
  background-color: lightblue;
  border-radius: 5px;
}
.accionesImagen{
  position: absolute;
  top:10px;
}
.img-check{
  display: none;
}

input[type="checkbox"]:checked ~ .checked-img:before{
  border: 1px solid red;
}


</style>
<script>
 
//REPLICAS DE VARIABLES DE SESIÓN PHP 
var sessionAdmin = "<?php echo $_SESSION["administracion"] ?>"
if(sessionAdmin != 1){
$("#btnAnalisis").hide();
$("#btnCierre").hide();

}

    
   $(document).ready(function() {

    $("#fecha_incidente").on('change', function(e){
     
  // Parse the input string as a date
  var inputDate = new Date($("#fecha_incidente").val());

  // Get today's date
  var today = new Date();

  // Check if the input date is greater than today's date
  if (inputDate > today) {
    $("#fecha_incidente").val(today);
    bootbox.alert("Ingresar una fecha correcta")
  }

  // return true;

})
    
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
errorClass: "invalid"

  });
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

  //FUNCION PARA ERRORES EN FIREFOX
  $('.modal').css('overflow-y', 'auto');
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );


}
// **************************FUNCIÓN QUE AUTOCOMPLETA LOS INVOLUCRADOS******************************
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
    return val.split(", ");
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

//FUNCIÓN QUE HACE EL ZOOM EN LAS IMÁGENES Y LO PROYECTA EN LA LUPA
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

  //FUNCIÓN QUE TOMA LA POSICIÓN DEL CURSOR (QUE CONSUME LA PROYECCIÓN DE LUPA)
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
let formDataImagen = new FormData()
let formDataArchivos = new FormData()
var contadorPosiciones = 0 ;
// **********************************HANDLE DOCUMENTOS (CIERRE)****************************************
function handlePdf(){
  const input = document.getElementById("archivoCierre");
  const files = input.files
  var archivosSoportados = ["application/pdf"];
  var elementosNoValidos = false;
  let element;
  for (let i = 0; i < files.length; i++) {
  element = files[i];
  
  if(archivosSoportados.indexOf(element.type) != -1){
      rand = getRandomString(5);
      if(contadorPosiciones>0){
         $('#listaArchivosCierre').append('<li id="'+(contadorPosiciones+i)+'" >'+element.name+'   <button class="btn btn-default" onclick="deleteArchivo(\''+(contadorPosiciones+i)+'\');$(this).remove();"><i class="fa fa-trash"></i></button> </li>');
        //  $('#listaArchivosCierre').append('<li id="'+(contadorPosiciones+i)+'" onclick="deleteArchivo(\''+(contadorPosiciones+i)+'\');$(this).remove();"><input type="hidden" name="photo-'+rand+'" value="'+element.name+'">'+element.name+'<figure><img class="img-show img-delete"  src="'+URL.createObjectURL(element)+'" "> </li>');
        formDataArchivos.append('archivoCierre[]',element)
      }else{
        $('#listaArchivosCierre').append('<li id="'+(contadorPosiciones+i)+'" >'+element.name+'   <button class="btn btn-default" onclick="deleteArchivo(\''+(contadorPosiciones+i)+'\');$(this).remove();"><i class="fa fa-trash"></i></button> </li>');
        // $('#listaArchivosCierre').append('<li id="'+(contadorPosiciones+i)+'" onclick="deleteArchivo(\''+(contadorPosiciones+i)+'\');$(this).remove();"><input type="hidden" name="photo-'+rand+'" value="'+element.name+'"><figure><img class="img-show img-delete"  src="'+URL.createObjectURL(element)+'" "> </li>');
        formDataArchivos.append('archivoCierre[]',element)
      }
    }
    else{
      elementosNoValidos = true;
    }
  }
  if(elementosNoValidos){
    alert('El formato del documento no es válido');
  }
 for(var pair of formDataArchivos.entries()){
  console.log(pair[0])
  console.log(pair[1])
 }
}
// *************************************BORRADO DE ARCHIVOS****************************************
function deleteArchivo(id){
  var contadorArchivos = 0;
  valoresArray = []
  for (let [key, value] of formDataArchivos.entries()) {
    // Verifica si la clave coincide con el campo que deseamos obtener
    console.log("FormData: valor "+value+"indice "+key)
    // if (key.includes( 'imagen1')) {
      valoresArray.push(value);
      contadorArchivos++;
    // }
  }
  console.log('Before: '+valoresArray)
  valoresArray.splice(id, 1);
  console.log('After: '+valoresArray)
  formDataArchivos.delete('archivoCierre[]') 
  valoresArray.forEach((valor, indice) => {
    console.log("Valor: "+valor+",\n Indice:"+indice)
    formDataArchivos.append('archivoCierre[]', valor);
    // formDataArchivos.append('imagen1['+indice+']', valor);
  });
  contadorArchivos = (contadorArchivos-parseInt(id));
  console.log(contadorArchivos)
  var elementId = '#'
  $(elementId.concat(id)).remove()
  for(var i=0; i < contadorArchivos ; i++ ){
    console.log((parseInt(id)+1)+i)
    console.log(parseInt(parseInt(id)+i))
    $(elementId.concat((parseInt(id)+1)+i)).attr('onclick','deleteArchivo('+(parseInt(id)+i)+')')
    $(elementId.concat((parseInt(id)+1)+i)).attr('id',(parseInt(id)+i))
  }
  for(var pair of formDataArchivos.entries()){
    console.log(pair[0])
    console.log(pair[1])
  }
  valoresArray = []
}
// **********************************HANDLE IMAGENES****************************************
function handleUpload() {
  const input = document.getElementById("imagen1");
  const preview = document.getElementById("imagen-show");
 console.log(input.files);
  const files = input.files;
 var supportedImages = ["image/jpeg","image/gif","image/png","image/jpg"];
 var elementosNoValidos = false;
 var element;
 var rand = '';
  // preview.innerHTML = "";
  var dirCsv = ''; 
  contadorPosiciones = 0;
  // loop through selected files
  for (const [key, value] of formDataImagen.entries()) {
    // Verifica si la clave coincide con el campo que deseamos obtener
    // if (key.includes('imagen1')) {
      contadorPosiciones++;
    // }
  }
console.log(contadorPosiciones)
  for (let i = 0; i < files.length; i++) {
    element = files[i];
    if(supportedImages.indexOf(element.type) != -1){
      
      rand = getRandomString(5);
      if(contadorPosiciones>0){
        $('.img-carrousel').append('<div class="col-2"><div class="image-container" id="'+(contadorPosiciones+i)+'" onclick="deleteImage(\''+(contadorPosiciones+i)+'\');$(this).remove();"><input type="hidden" name="photo-'+rand+'" value="'+element.name+'"><figure><img class="img-show img-delete"  src="'+URL.createObjectURL(element)+'" "> <figcaption><i class="fa fa-trash"></i></figcaption></figure></div></div>');
        formDataImagen.append('imagen1[]',element)
        // formDataImagen.append('imagen1['+(contadorPosiciones+i)+']',element)
        
      }else{
        $('.img-carrousel').append('<div class="col2"><div class="image-container" id="'+i+'" onclick="deleteImage(\''+i+'\');$(this).remove();"><input type="hidden" name="photo-'+rand+'" value="'+element.name+'"><figure><img class="img-show img-delete"  src="'+URL.createObjectURL(element)+'" "> <figcaption><i class="fa fa-trash"></i></figcaption></figure></div></div>');
        formDataImagen.append('imagen1[]',element)
        // formDataImagen.append('imagen1['+i+']',element)
      }
    }
    else{
      elementosNoValidos = true;
    }
  }
  if(elementosNoValidos){
    alert('El formato de la imagen no es válido');
  }
 for(var pair of formDataImagen.entries()){
  console.log(pair[0])
  console.log(pair[1])
 }
}
var valoresArray = [];

// *************************************BORRADO DE IMAGENES****************************************
function deleteImage(id){
  var contadorImagenes = 0;
  valoresArray = []
  for (let [key, value] of formDataImagen.entries()) {
    // Verifica si la clave coincide con el campo que deseamos obtener
    console.log("FormData: valor "+value+"indice "+key)
    // if (key.includes( 'imagen1')) {
      valoresArray.push(value);
      contadorImagenes++;
    // }
  }
  console.log('Before: '+valoresArray)
  valoresArray.splice(id, 1);
  console.log('After: '+valoresArray)
  formDataImagen.delete('imagen1[]') 
  valoresArray.forEach((valor, indice) => {
    console.log("Valor: "+valor+",\n Indice:"+indice)
    formDataImagen.append('imagen1[]', valor);
    // formDataImagen.append('imagen1['+indice+']', valor);
  });
  contadorImagenes = (contadorImagenes-parseInt(id));
  console.log(contadorImagenes)
  var elementId = '#'
  $(elementId.concat(id)).remove()
  for(var i=0; i < contadorImagenes ; i++ ){
    console.log((parseInt(id)+1)+i)
    console.log(parseInt(parseInt(id)+i))
    $(elementId.concat((parseInt(id)+1)+i)).attr('onclick','deleteImage('+(parseInt(id)+i)+')')
    $(elementId.concat((parseInt(id)+1)+i)).attr('id',(parseInt(id)+i))
  }
  for(var pair of formDataImagen.entries()){
    console.log(pair[0])
    console.log(pair[1])
  }
  valoresArray = []
}
// **********************************SUBIDA FORMULARIO****************************************
$("#btnGuardar").click( function(e) {
  $("#formulario").target = '_blank';
    console.log($("#formulario"));
  if ($('#formulario').valid()) {

  $("#formulario").submit();
  $("#formulario").on("submit",function(e)
  {
    guardaryeditar(e, formDataImagen);
   
    $("#formulario").validate().resetForm();
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
          procesar(e, 'C',formDataArchivos);		
          $("#formulario").validate().resetForm();
          
        });
      }
      
    
	})
var nombreSession = "<?php echo $_SESSION["nombre"]; ?>"
var permisoAdministrador = "<?php echo $_SESSION["administracion"]; ?>"
</script>


<?php 


}
ob_end_flush();
?>



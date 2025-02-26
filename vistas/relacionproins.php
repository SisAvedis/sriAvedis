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
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Relación Procedimiento Instructivo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true,true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Procedimiento</th>
							<th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
							<th>Procedimiento</th>
							<th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
		
					<div class="panel-body" style="height: auto;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          
						  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Sector(*):</label>
                            <!--<input type="hidden" name="idventa" id="idventa">-->
                            <select id="idsector" name="idsector" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
						  
						  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">	
							<label>Procedimiento(*):</label>
                            <input type="hidden" name="idrelproins" id="idrelproins">
                            <select id="iddocumento" name="iddocumento" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          
                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-14">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observacion" id="observacion" maxlength="10000" placeholder="Observaciones">
                          </div>
						  
						  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary" onclick="consultarDetalle()"> 
								<span class="fa fa-plus"></span> Agregar Instructivo</button>
                            </a>
                          </div>
						  
						  
						  
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
									<th>Codigo</th>
                                    <th>Documento</th>
									<th>Descripcion</th>
									<th>Sector</th>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Instructivo</h4>
        </div>
        <div class="modal-body">
          <table id="tblinstructivos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
				<th>Código</th>
                <th>Nombre</th>
				<th>Descripcion</th>
                <th>Sector</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripcion</th>
				<th>Sector</th>
                <th>Código</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/relacionproins.js"></script>
<?php 
}
ob_end_flush();
?>



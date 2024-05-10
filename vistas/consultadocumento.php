<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  //iniciamos las variables de session
  session_start();

  if(!isset($_SESSION["nombre"]))
  {
    header("Location: login.html");
  }

  else  //Agrega toda la vista
  {
    require 'header.php';

    if($_SESSION['consulta'] == 1)
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
                        <h1 class="box-title">Consulta Documentos por Sector</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="">Sector</label>
                            <select title="--<b>Seleccione un Sector</b>--" name="idsector" id="idsector" onchange="listar()" class="form-control selectpicker" data-live-search="true" required></select>
                            <!-- <button class="btn btn-success" onclick="listar()">Mostrar</button> -->
                        </div>
						
						<table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
							<th>Sector</th>
                            <th>Codigo</th>
                            <th>Documento</th>
							<th>Descripcion</th>
							<th>Detalles</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Sector</th>
                            <th>Codigo</th>
                            <th>Documento</th>
							<th>Descripcion</th>
							<th>Detalles</th>
                          </tfoot>
                        </table>
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
						<button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php
  
  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>

<script src="./scripts/consultadocumento.js"></script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>
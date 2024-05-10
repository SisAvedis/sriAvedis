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

    if($_SESSION['escritorio'] == 1)
    {
        require_once '../modelos/Consultas.php';
        
        $consulta = new Consultas();
        $rsptap = $consulta->totalAceptados();
        $regp = $rsptap->fetch_object();
        $totalp = $regp->cantidad_procedimiento;

        $rsptai = $consulta->totalProcesados();
        $regi = $rsptai->fetch_object();
        $totali = $regi->cantidad_instructivo;

        $rsptac = $consulta->totalCerrados();
        $regc = $rsptac->fetch_object();
        $totalc = $regc->cantidad_instructivo;

        //Mostrar graficos 
        $reportes12 = $consulta->reportes12meses();
        $fechasp = '';
        $totalesp = '';

        while($regfechap = $reportes12->fetch_object())
        {
            $fechasp =  $fechasp.'"'.$regfechap->fecha.'",';
            $totalesp = $totalesp.$regfechap->total.',';
        }

        //Quitamos la ultima coma
        $fechasp = substr($fechasp,0,-1);
        $totalesp = substr($totalesp,0,-1);

        //Graficos Venta
        $procesados12 = $consulta->procesados12meses();
        $fechasi = '';
        $totalesi = '';

        while($regfechai = $procesados12->fetch_object())
        {
            $fechasi =  $fechasi.'"'.$regfechai->fecha.'",';
            $totalesi = $totalesi.$regfechai->total.',';
        }

        //Quitamos la ultima coma
        $fechasi = substr($fechasi,0,-1);
        $totalesi = substr($totalesi,0,-1);

            //Graficos Venta
            $cerrados12 = $consulta->cerrados12meses();
            $fechasc = '';
            $totalesc = '';
    
            while($regfechai = $cerrados12->fetch_object())
            {
                $fechasc =  $fechasc.'"'.$regfechai->fecha.'",';
                $totalesc = $totalesc.$regfechai->total.',';
            }
    
            //Quitamos la ultima coma
            $fechasc = substr($fechasc,0,-1);
            $totalesc = substr($totalesc,0,-1);
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
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>Total: <?php echo $totalp; ?></strong>
                                        <p>Reportes</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <!--<a href="ingreso.php" class="small-box-footer">-->
                                   Reportes Aceptados
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>Total: <?php echo $totali; ?></strong>
                                        <p>Reportes</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <!--<a href="venta.php" class="small-box-footer">-->
                                    Reportes en Proceso 
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>Total: <?php echo $totalc; ?></strong>
                                        <p>Reportes</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <!--<a href="venta.php" class="small-box-footer">-->
                                    Reportes Cerrados
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="panel-body">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                  Aceptados en los ultimos 12 meses
                                </div>
                                <div class="box body">
                                    <canvas id="procedimientos" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                Procesados en los ultimos 12 meses
                                </div>
                                <div class="box body">
                                    <canvas id="instructivos" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                Cerrados en los ultimos 12 meses
                                </div>
                                <div class="box body">
                                    <canvas id="cerrados" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
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

<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>

<script>

var ctx = document.getElementById("procedimientos").getContext('2d');
var procedimientos = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasp; ?>],
        datasets: [{
            label: 'Aceptados de los ultimos 12 meses',
            data: [<?php echo $totalesp; ?>],
            backgroundColor: [
                'rgba(	255, 80, 17, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                  'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctx = document.getElementById("instructivos").getContext('2d');
var instructivos = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasi; ?>],
        datasets: [{
            label: 'Procesados de los ultimos 12 meses',
            data: [<?php echo $totalesi; ?>],
            backgroundColor: [
                'rgba(	20, 1, 255, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                   'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("cerrados").getContext('2d');
var instructivos = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Cerrados de los ultimos 12 meses',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(	44, 176, 12, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                 'rgba(54, 162, 235, 0.2)',
                 'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                 'rgba(255, 99, 132, 0.2)',
                 'rgba(54, 162, 235, 0.2)',
                 'rgba(255, 206, 86, 0.2)',
                 'rgba(75, 192, 192, 0.2)',
                 'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)',
                'rgba(1,1,1,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

</script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>
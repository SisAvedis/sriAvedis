<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 

  if(!isset($_SESSION["nombre"]))
  {
    echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  }

  else  //Agrega toda la vista
  {

    // if($_SESSION['consultas'] == 0)
    // {
        //Incluimos archivo Factura.php
        require 'Factura.php';

        //Datos
        $logo = "VectorAvedis.png";
        $ext_logo = "png";
        $empresa = "avedis s_logo.png";
        $ext_empresa = "png";
        $documento = "Tecno Agro Vial S.A.";
        $direccion = "Ruta de la Tradición 4699 - Buenos Aires";
        $telefono = "011-4693-4008 / 4009 / 5226";
        $email = "info@avedis.com.ar";
        $codigoPostal = "(B1839FQF) 9 DE ABRIL - E. Echeverría - Bs. As.";

        //Obtenemos los datos de la cabecera
        require_once '../modelos/ReporteIncidentes.php';
        $reporte = new Reporte();

        $rsptav = $reporte->reporteCabecera($_GET['id']);

        //Recorremos los datos obtenidos
        $regv = $rsptav->fetch_object();

        $pdf = new PDF_Invoice('P','mm','A4');
        $pdf->AddPage();

        //Enviamos los datos de la empresa al metodo addSociete de la clase factura
        //Para ubicar los datos correspondientes
        $pdf->addSociete(
            utf8_decode($empresa),
            $ext_empresa,
            $documento."\n".
            utf8_decode("Dirección: ").utf8_decode($direccion)."\n".
            utf8_decode($codigoPostal)."\n".
            utf8_decode("Telefax: ").utf8_decode($telefono)."\n".
            "Email: ".$email
            ,
            $logo,
            $ext_logo,
            
        );
        
        $pdf->fact_dev(
            utf8_decode("Reporte Nº "),
            "$regv->num_comprobante"
        );

        $pdf->temporaire( "" ); //Marca de Agua
        $pdf->addDate($regv->fecha);

        if (strpos($regv->involucrados,",") !== false){
        
            $regv-> involucrados = substr_replace($regv->involucrados,"",-1);
        }
        
       
        //Enviar los datos del cliente al metodo addClienteAdresse de la clase Factura
        //  $pdf->addCabecera($regv->fechaIncidente, utf8_decode(str_replace('ñ', "n", iconv('UTF-8', 'windows-1252',$regv->areaAfectada))), utf8_decode($regv->notificante), utf8_decode(str_replace('ñ', "n", utf8_decode($regv->areaNotificante))), utf8_decode($regv->involucrados), utf8_decode(str_replace('ñ', "n", utf8_decode($regv->areaInvolucrada)))
         $pdf->addCabecera($regv->fechaIncidente, utf8_decode(str_replace('ñ', "n", utf8_decode($regv->areaAfectada))), utf8_decode($regv->notificante), utf8_decode(str_replace('ñ', "n", utf8_decode($regv->areaNotificante))), utf8_decode($regv->involucrados), utf8_decode(str_replace('ñ', "n", utf8_decode($regv->areaInvolucrada)))

         );

        //Establecemos las columnas que va a tener la seccion donde mostramos los detalles de la venta
        $cols=array(
            utf8_decode("DESCRIPCIÓN: ")=>185,
                // "RESULTADOS"=>61.6,
            // "ESPECIFICACIONES"=>61.6
        );
        $pdf->addDescripcion($cols);

        $cols = array(
            utf8_decode("DESCRIPCIÓN: ")=>"L", //Alineacion (Left)
            // "RESULTADOS"=>"C",
                // "ESPECIFICACIONES"=>"C"
        );
        $pdf->addLineFormat($cols);
        $pdf->addLineFormat($cols);

        //Actualizamos el valos de la coordenada "y", que sera la ubicacion desde donde empezaremos a mostrar los datos
        $y = 88;
        //Obtenemos todos los detalles de la venta actual
   
        //   while($regd = $rsptav->fetch_object())
        //   {

            $line2 = array(
                utf8_decode("DESCRIPCIÓN: ")=>utf8_decode($regv->descripcion),
                // "RESULTADOS"=>utf8_decode($regv->O2)." %",
                // "ESPECIFICACIONES"=>"Mayor o igual a 99.5% v/v O2"
            );
            $size = $pdf->addLine($y,$line2, 0);
            // $y += $size + 4;
            // $line2 = array(
            //     utf8_decode("DETERMINACIÓN")=>utf8_decode("CO (Monóxido de Carbono)"),
            //     "RESULTADOS"=>utf8_decode($regv->CO)." ppm",
            //     "ESPECIFICACIONES"=>"Menor a 5 ppm"
            // );
            // $size = $pdf->addLine($y,$line2, 'B');
            // $y += $size + 4;
            // $line2 = array(
            //     utf8_decode("DETERMINACIÓN")=>utf8_decode("CO2 (Dióxido de Carbono)"),
            //     "RESULTADOS"=>utf8_decode($regv->CO2)." ppm",
            //     "ESPECIFICACIONES"=>"Menor a 300 ppm"
            // );
            // $size = $pdf->addLine($y,$line2, 'B');
            // $y += $size + 4;
            // $line2 = array(
            //     utf8_decode("DETERMINACIÓN")=>"Humedad",
            //     "RESULTADOS"=>utf8_decode($regv->H2O)." ppm",
            //     "ESPECIFICACIONES"=>"Menor a 67 ppm"
            // );
            // $size = $pdf->addLine($y,$line2, 'B');
            // $y += $size + 4;
            // $line2 = array(
            //     utf8_decode("DETERMINACIÓN")=>utf8_decode(" "),
            //     "RESULTADOS"=>"-",
            //     "ESPECIFICACIONES"=>"No detecta"
            // );
            // $size = $pdf->addLine($y,$line2, 0);
            // $y += $size + 5;
           

        //   }
        if($regv->estado === 'En Proceso' ){
            $colsAnalisis=array(
                utf8_decode("ANÁLISIS: ")=>185,
                // "RESULTADOS"=>61.6,
                // "ESPECIFICACIONES"=>61.6
            );
            $pdf->addAnalisis($colsAnalisis);
            $cols = array(
                utf8_decode("ANÁLISIS: ")=>"L", //Alineacion (Left)
                // "RESULTADOS"=>"C",
                    // "ESPECIFICACIONES"=>"C"
            );
            $pdf->addLineFormat($colsAnalisis);
            $pdf->addLineFormat($colsAnalisis);
    
            //Actualizamos el valos de la coordenada "y", que sera la ubicacion desde donde empezaremos a mostrar los datos
            $y = 167;
            //Obtenemos todos los detalles de la venta actual
       
            //   while($regd = $rsptav->fetch_object())
            //   {
    
                $line3 = array(
                    utf8_decode("ANÁLISIS: ")=>utf8_decode($regv->analisis),
                    // "RESULTADOS"=>utf8_decode($regv->O2)." %",
                    // "ESPECIFICACIONES"=>"Mayor o igual a 99.5% v/v O2"
                );
                $size2 = $pdf->addLine($y,$line3, 0);
    
        }
          //Recorremos los datos obtenidos
        if($regv->estado === 'Cerrado' ){
            $colsAnalisis=array(
                utf8_decode("ANÁLISIS: ")=>185,
                // "RESULTADOS"=>61.6,
                // "ESPECIFICACIONES"=>61.6
            );
            $pdf->addAnalisis($colsAnalisis);
            $cols = array(
                utf8_decode("ANÁLISIS: ")=>"L", //Alineacion (Left)
                // "RESULTADOS"=>"C",
                    // "ESPECIFICACIONES"=>"C"
            );
            $pdf->addLineFormat($colsAnalisis);
            $pdf->addLineFormat($colsAnalisis);
    
            //Actualizamos el valos de la coordenada "y", que sera la ubicacion desde donde empezaremos a mostrar los datos
            $y = 167;
            //Obtenemos todos los detalles de la venta actual
       
            //   while($regd = $rsptav->fetch_object())
            //   {
    
                $lineAnalisis = array(
                    utf8_decode("ANÁLISIS: ")=>utf8_decode($regv->analisis),
                    // "RESULTADOS"=>utf8_decode($regv->O2)." %",
                    // "ESPECIFICACIONES"=>"Mayor o igual a 99.5% v/v O2"
                );
                $size2 = $pdf->addLine($y,$lineAnalisis, 0);


          $cols2=array(
            utf8_decode("CIERRE: ")=>185,
                // "RESULTADOS"=>61.6,
            // "ESPECIFICACIONES"=>61.6
        );


        $pdf->addCierre($cols2);

        $cols = array(
            utf8_decode("CIERRE: ")=>"L", //Alineacion (Left)
            // "RESULTADOS"=>"C",
                // "ESPECIFICACIONES"=>"C"
        );
        $pdf->addLineFormat($cols2);
        $pdf->addLineFormat($cols2);

        //Actualizamos el valos de la coordenada "y", que sera la ubicacion desde donde empezaremos a mostrar los datos
        $y = 237;
        //Obtenemos todos los detalles de la venta actual
   
        //   while($regd = $rsptav->fetch_object())
        //   {

            $line3 = array(
                utf8_decode("CIERRE: ")=>utf8_decode($regv->cierre),
                // "RESULTADOS"=>utf8_decode($regv->O2)." %",
                // "ESPECIFICACIONES"=>"Mayor o igual a 99.5% v/v O2"
            );
            $size2 = $pdf->addLine($y,$line3, 0);
            // $y += $size + 4;

        }
     // $rsptad = $reporte->reporteCabecera($_GET['id']);
    //  $pdf->addDescriptionText(
    //     utf8_decode("OLOR: no detectable"),
    //     utf8_decode("Ensayos de identificación: positivo"),
    //     utf8_decode("El producto fue obtenido por licuefacción del aire"),
    //     utf8_decode("y cumple con especificaciones descriptas"),
    //     utf8_decode("en Farmacopea Nacional Argentina"),
    //       utf8_decode("6ta Edición de 1978.")
        
    // );
    //  $pdf->addOperadorAdresse(
    //     utf8_decode($regv->analista)
        
    // );

    
    if($regv-> estado === 'Aceptado'  ){
        $pdf->addFirmaSupervisor(
            utf8_decode($regv->notificante), 'A'
        );
        
        if($regv->involucrados != ''){
            $pdf->addFirmaInvolucrados(utf8_decode($regv->involucrados),'A');
        }
    }
    else if($regv-> estado ===  'En Proceso'){
        $pdf->addFirmaSupervisor(
            utf8_decode($regv->notificante), 'P'
        );
        $pdf->addFirmaSupervisor(
            utf8_decode($regv->notificante), 'P'
        );
        if($regv->involucrados != ''){
            
            $pdf->addFirmaInvolucrados(utf8_decode($regv->involucrados),'P');
        }
    }
    else {
        // $pdf->addFirmaSupervisor(
            //     utf8_decode($regv->notificante), 'C'
            // );
            // $pdf->addFirmaResponsables();
            
        }
        
        if($regv->estado === 'Cerrado' ){
            $pdf->addArchivosAdjuntos(substr_replace($regv->archivos,"",-1));
            
            $pdf->AddPage();
            $pdf->addFirmaSupervisor(utf8_decode($regv->notificante), 'C' );
            
            $pdf->addFirmaResponsables(utf8_decode($regv->involucrados),'C');
        }
        
        
        $pdf->SetMargins(0,0,0);
        $pdf->SetAutoPageBreak(false,0);
        $nombreArchivo = "reporte ".strval($regv->num_comprobante).".pdf";
        
        $pdf->Output($nombreArchivo, "I");
        // } 
        
        // else
        // {
            //     echo 'No tiene permiso para visualizar el reporte';
            // }


   }
   ob_end_flush(); //liberar el espacio del buffer
?>
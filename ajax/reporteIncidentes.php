<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/ReporteIncidentes.php";

$reporte=new Reporte();

$idreporte=isset($_POST["idreporte"])? limpiarCadena($_POST["idreporte"]):"";
$idcliente=isset($_POST["idoperario"])? limpiarCadena($_POST["idoperario"]):"";

$idubi_origen= isset($_POST['idubi_origen']) ? $_POST['idubi_origen'] :"";
$idubi_destino= isset($_POST['idubi_destino']) ? $_POST['idubi_destino'] :"";
    
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_incidente=isset($_POST["fecha_incidente"])? limpiarCadena($_POST["fecha_incidente"]):"";
$idsectorAfectada = isset($_POST['areaAfectada']) ? $_POST['areaAfectada'] : "";
$idsectorNotificado = isset($_POST['areaNotificado']) ? $_POST['areaNotificado'] : "";
$idsectorInvolucrado = isset($_POST['areaInvolucrados']) ? $_POST['areaInvolucrados'] : "";
$idoperario=isset($_POST["idoperario"])? limpiarCadena($_POST["idoperario"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$titulo=isset($_POST["titulo"])? limpiarCadena($_POST["titulo"]):"";
$involucrados=isset($_POST["involucrados"])? limpiarCadena($_POST["involucrados"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$analisis=isset($_POST["analisis"])? limpiarCadena($_POST["analisis"]):"";
$cierre=isset($_POST["cierre"])? limpiarCadena($_POST["cierre"]):"";
$imagen1=isset($_POST["imagen1"])? limpiarCadena($_POST["imagen1"]):"";
$imagen2=isset($_POST["imagen2"])? limpiarCadena($_POST["imagen2"]):"";
$imagen3=isset($_POST["imagen3"])? limpiarCadena($_POST["imagen3"]):"";
$imagenArray = '';
$archivoArray = '';
switch ($_GET["op"]){
	case 'guardaryeditar':
		
		

		if (empty($idreporte)){
			
			if(!isset($_FILES["imagen1"]) )
			// if(!file_exists($_FILES['imagen1']['tmp_name'][0]) || !is_uploaded_file($_FILES['imagen1']['tmp_name'][0]))
			{
				$imagen1 = '';
				// $imagen1 = $_POST["imagenactual1"];
			}
			else
			{
				$files = array_filter($_FILES['imagen1']['name']);
				$total_count = count($_FILES['imagen1']['name']);
			for( $i=0 ; $i < $total_count ; $i++ ) {
				$tmpFilePath = $_FILES['imagen1']['tmp_name'][$i];
				$ext1 = explode(".",$_FILES["imagen1"]["name"][$i]);
				if($_FILES['imagen1']['type'][$i] == "image/jpg" || $_FILES['imagen1']['type'][$i] == "image/jpeg" || $_FILES['imagen1']['type'][$i] == "image/png")
				{
					$imagen1 = round(microtime(true)+$i).'.'.end($ext1);
					move_uploaded_file($_FILES['imagen1']['tmp_name'][$i], "../files/reportes/imagenes/" . $imagen1);
					$imagenArray .= $imagen1.',';
				}
			}}

			$rspta=$reporte->insertar($idusuario,$idsectorAfectada,$titulo,$idoperario,$fecha_incidente,$involucrados,$descripcion,$analisis,$cierre,$idsectorNotificado,$idsectorInvolucrado,$imagenArray);
			echo $rspta ? "Reporte registrado" : "No se pudieron registrar todos los datos del reporte";
		}
		else {
		$rspta=$reporte->editar($idreporte,$descripcion);
			echo $rspta ? "Reporte actualizado" : "Reporte no se pudo actualizar";
		}
	break;
	case 'procesar':
		
			$flag = $_GET["flag"] ;
			if ($flag === 'P'){
				$rspta=$reporte->procesar($idreporte,$analisis,$cierre, 'P', '');
				echo $rspta ? "Reporte procesado" : "No se pudieron procesar todos los datos del reporte";
			}
			else if($flag === 'C') {
				
					if(!isset($_FILES["archivoCierre"]))
					{
						$archivoCierre = '';
					}
					else
					{
						$files = array_filter($_FILES['archivoCierre']['name']);
						$total_count = count($_FILES['archivoCierre']['name']);
					for( $i=0 ; $i < $total_count ; $i++ ) {
						$tmpFilePath = $_FILES['archivoCierre']['tmp_name'][$i];
						$ext1 = explode(".",$_FILES["archivoCierre"]["name"][$i]);
						if($_FILES['archivoCierre']['type'][$i] == "application/pdf" )
						{
							$archivoCierre = round(microtime(true)+$i).'.'.end($ext1);
							move_uploaded_file($_FILES['archivoCierre']['tmp_name'][$i], "../files/reportes/documentos/" . $archivoCierre);
							$archivoArray .= $archivoCierre.',';
						}
					}}
				$rspta=$reporte->procesar($idreporte,$analisis,$cierre, 'C', $archivoArray);
				echo $rspta ? "Reporte cerrado" : "No se pudieron cerrar todos los datos del reporte";
			}
			break;

	case 'anular':
		$motivo=$_GET['motivo'];
		$idreporte=$_GET['idreporte'];
		$rspta=$reporte->anular($idreporte, $motivo ,$idusuario);
 		echo $rspta ? "Reporte anulado" : "Reporte no se puede anular";
	break;

	case 'mostrar':
		$rspta=$reporte->mostrar($idreporte);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];
		
		$rspta = $reporte->listarDetalle($id);
		echo json_encode($rspta);
		$total=0;
		$data = Array();
		// while ($reg = $rspta->fetch_object())
		// 		{
		// 			$data[]=array(
		// 				"0"=>$reg->fecha_incidente,
		// 				"1"=>$reg->idoperario,
		// 				"2"=>$reg->idsectorNotificado,
		// 				"3"=>$reg->idsectorInvolucrados,
		// 				"4"=>$reg->descripcion,
		// 				"5"=>$reg->analisis,
		// 				"6"=>$reg->cierre
		// 			);	
		// 		}
		// 		$results = array(
		// 			"sEcho"=>1, //Información para el datatables
		// 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		// 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		// 			"aaData"=>$data);
		;
	break;

	case 'listar':
		$rspta=$reporte->listar();
 		//Vamos a declarar un array
 		$data= Array();

		 while ($reg=$rspta->fetch_object())
		 {
		// 	if($reg->tipo_comprobante=='Ticket')
		// 	{
		// 		$url = '../reportes/exTicket.php?id='; //Ruta del archivo exTicket
		// 	}
		// 	else
		// 	{
				$url = '../reportes/exCertificado.php?id='; //Ruta del archivo exFactura
			// }

 			$data[]=array(
 				"0"=> (($reg->estado=='Aceptado' && $_SESSION["administracion"] == 0 && $reg->usuario == $_SESSION["nombre"] || $reg->estado=='Cerrado' && $_SESSION["administracion"] === 1  )?'<button class="btn btn-warning" onclick="mostrar('.$reg->idreporte.',\''.$reg->estado.'\',\''.$reg->usuario.'\')"><i class="fa fa-eye"></i></button>'.
						' <button class="btn btn-danger" onclick="anular('.$reg->idreporte.')"><i class="fa fa-close"></i></button>':
						(($reg->estado=='Aceptado' && $_SESSION["administracion"] === 1|| $reg->estado=='En Proceso' && $_SESSION["administracion"] === 1) ? '<button class="btn btn-warning" onclick="editar('.$reg->idreporte.',\''.$reg->estado.'\',\''.$reg->usuario.'\')"><i class="fa fa-pencil"></i></button>'.
						' <button class="btn btn-danger" onclick="anular('.$reg->idreporte.')"><i class="fa fa-close"></i></button>'
						:'<button class="btn btn-warning" onclick="mostrar('.$reg->idreporte.',\''.$reg->estado.'\',\''.$reg->usuario.'\')"><i class="fa fa-eye"></i></button>')).
					 
						  '<button class="btn btn-info" onclick="abrirDocumentos(\''.$reg->archivos.'\',\''.$url.$reg->idreporte.'\')">
						 <i class="fa fa-file"></i>
						 </button>'
					 ,
 				"1"=>$reg->fecha,
 				"2"=>$reg->titulo,
 				"3"=>(($reg->estado==='Aceptado' ||  $reg->estado==='En Proceso')?"Ult. Modificación: hace ".$reg->ultimaModificacion." días":($reg->estado==='Anulado'?"Duración: ".$reg->duracion." días."."\nAnulado Por: ".$reg->anulador.' <button class="btn btn-success " onclick="bootbox.alert(\'Motivo: '.$reg->motivoAnulacion.' <br>Fecha: '.$reg->fecha.'\')"><i class="fa fa-eye"></i></button>':"Duración: ".$reg->duracion." días")),
 				"4"=>$reg->usuario,
 				"5"=>$reg->areaAfectada,
 				"6"=>$reg->num_comprobante,
 				"7"=>($reg->estado==='Aceptado')?'<span class="label bg-yellow">Aceptado</span>':
				(($reg->estado==='En Proceso')?'<span class="label bg-blue">En Proceso</span>':
				(($reg->estado==='Cerrado')? '<span class="label bg-green">Cerrado</span>':
 				'<span class="label bg-red">Anulado</span>'))
		);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectMovDestino':
            require_once "../modelos/Movimiento.php";
            $movimiento = new Movimiento();

            $rspta = $movimiento->selectUno();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idubicacion.'>'
                        .$reg->codigo.' - '.$reg->descripcion.
                      '</option>';
            }
        break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();
	
			$rspta = $persona->listarcactivo();
	
			while ($reg = $rspta->fetch_object())
					{
					echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
					}
		break;
	
		
		case 'autoCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();
	
			$rspta = $persona->listarc();
			$data  = Array();
	
			while ($reg = $rspta->fetch_object())
					{
					 $data[]= $reg->nombre;
					}
				echo json_encode($data);
				//echo '<script>console.log('.$data.')</script>';
		break;
	
	case 'selectSector':
		require_once "../modelos/Sector.php";
		$sector = new Sector();

		$rspta = $sector->select();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idsector . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'setAreaNotificante':
		require_once "../modelos/Sector.php";
		$sector = new Sector();
		$idpersona = $_GET["idpersona"];

		$rspta = $sector->setAreaNotificante($idpersona);

		// while ($reg = $rspta->fetch_object())
				// {
				echo json_encode($rspta);
					// }
	break;
	
	case 'listarArticulos':

        require_once '../modelos/Articulo.php';
        $articulo = new Articulo();

        $rspta = $articulo->listarActivosUbi();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
               "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\',\''.$reg->c_ubi.'\','.$reg->cantidad.')">
                                <span class="fa fa-plus"></span>
                            </button>',
					
                "1"=>$reg->nombre,
				"2"=>$reg->descripcion,
                "3"=>$reg->categoria,
				"4"=>$reg->subcategoria,
                "5"=>$reg->codigo,
				"6"=>$reg->c_ubi,
                "7"=>$reg->cantidad,
                "8"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
             );
        }
        $results = array(
            "sEcho"=>1, //Informacion para el datable
            "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" =>$data
        );
        echo json_encode($results);

    break;
	
	case 'listarArticulosUno':

            require_once '../modelos/Articulo.php';
            $articulo = new Articulo();
			
			$idartubi=$_GET['idartubi'];	
			$rspta = $articulo->listarActivosUbiUno($idartubi);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.','.$reg->idubicacion.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.htmlspecialchars($reg->subcategoria).'\',\''.$reg->codigo.'\',\''.$reg->c_ubi.'\','.$reg->cantidad.')">
                                <span class="fa fa-plus"></span>
                            </button>',
					
                    "1"=>$reg->nombre,
					"2"=>$reg->descripcion,
                    "3"=>$reg->categoria,
					"4"=>$reg->subcategoria,
                    "5"=>$reg->codigo,
					"6"=>$reg->c_ubi,
                    "7"=>$reg->cantidad,
                    "8"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);

        break;
		
		case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.htmlspecialchars($reg->nombre).'\',\''.htmlspecialchars($reg->descripcion).'\',\''.htmlspecialchars($reg->categoria).'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
				"2"=>$reg->descripcion,
 				"3"=>$reg->categoria,
 				"4"=>$reg->codigo,
 				"5"=>$reg->stock,
 				"6"=>$reg->precio_venta,
 				"7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
	case 'getMaxReporte':
		$rspta = $reporte->getMaxReporte();
		while ($reg = $rspta->fetch_object())
			{
			echo $reg->num_planilla;
			}
		
	break;
	
}
?>
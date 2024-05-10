<?php
    
    require_once '../modelos/Documento.php';
	require_once '../classes/class.upload.php';
	require_once "../modelos/Archivo.php";
	//header('Content-Type: text/html; charset=utf-8');
	
	if(strlen(session_id()) < 1){
        session_start();
    }

	$documento = new Documento();

    $iddocumento=isset($_POST["iddocumento"])? limpiarCadena($_POST["iddocumento"]):"";
    $idsector=isset($_POST["idsector"])? limpiarCadena($_POST["idsector"]):"";
	$idtipo_documento=isset($_POST["idtipo_documento"])? limpiarCadena($_POST["idtipo_documento"]):"";
	$idusuario= $_COOKIE['idusuario'];
	$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    	
    switch($_GET["op"])
    {
        case 'guardaryeditar':
			
			if (empty($iddocumento)){
                $rspta=$documento->insertar($idsector,$idtipo_documento,$idusuario,$codigo,$nombre,$descripcion);
                if($rspta){
					while ($reg = $rspta->fetch_object())
						{
							$iddocumento = $reg->iddocumento;
						}
				}
				echo $rspta ? "Documento registrado"."</br>" : "Documento no se pudo registrar"."</br>";
            }
            else {
                $rspta=$documento->editar($iddocumento,$idsector,$idtipo_documento,$idusuario,$codigo,$nombre,$descripcion);
                echo $rspta ? "Documento actualizado"."</br>" : "Documento no se pudo actualizar"."</br>";
            }
					
			
			if(file_exists($_FILES["archivo"]['tmp_name']) || is_uploaded_file($_FILES["archivo"]['tmp_name']))
			{
				$handle = new Upload($_FILES["archivo"],'es_ES');
				$handle->file_auto_rename = false;
				if ($handle->uploaded) {
					$handle->Process("../uploads/");
					if ($handle->processed) {
						$archivo = new Archivo();
						$rspta = $archivo->insertar($iddocumento,"","../uploads/",$handle->file_dst_name);
						echo $rspta ? "Archivo subido" : "Archivo no se pudo subir";
					} else {
					echo 'Error: ' . $handle->error . '</br>';
					}
				} else {
					echo 'Error: ' . $handle->error . '</br>';
				}
			
			}	
			
			
            
        break;
		
		case 'eliminar':
			$archivo = new Archivo();
			$rspta = $archivo->mostrar($iddocumento);
			if($rspta){
				while ($reg = $rspta->fetch_object())
					{
						$ruta = $reg->carpeta.$reg->fuente;
					}
			}
			
			$rspta = $archivo->eliminar($iddocumento);
			if($rspta){
				unlink($ruta);
			}
			
			
			$rspta = $documento->mostrar($iddocumento);
			echo json_encode($rspta);
			//echo $rspta ? "Documento eliminado" : "Documento no se pudo eliminar";
        break;
		
		
        case 'desactivar':
                $rspta = $documento->desactivar($iddocumento);
                echo $rspta ? "Documento desactivado" : "Documento no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $documento->activar($iddocumento);
            echo $rspta ? "Documento activado" : "Documento no se pudo activar";
        break;
		
		case 'subir':
			require_once '../classes/class.upload.php';
			require_once "../modelos/Archivo.php";
            
			$handle = new Upload($_FILES["archivo"]);
			if ($handle->uploaded) {
				$handle->Process("../uploads/");
				if ($handle->processed) {
					$archivo = new archivo();
					$rspta = $archivo->insertar($iddocumento,"","../uploads/",$handle->file_dst_name);
					echo $rspta ? "Documento subido" : "Documento no se pudo subir";
					
					//insert_img("","uploads/",$handle->file_dst_name);
				} else {
				echo 'Error: ' . $handle->error;
				}
			} else {
				echo 'Error: ' . $handle->error;
			}
			unset($handle);
			
        break;
		
        case 'mostrar':
            $rspta = $documento->mostrar($iddocumento);
            echo json_encode($rspta);
        break;
		
		case 'listarDetalle':
			//Recibimos el idingreso
			$id=$_GET['id'];
	
			$rspta = $documento->listarDetalle($id);
			
			if($rspta){
				if($rspta->num_rows === 0){
					
					//echo '<thead><th><label id="lblarchivo">Archivo a subir:</label></th></thead>';
					//echo '<tbody><tr class="filas"><td><input type="file" class="form-control" name="archivo" id="archivo"></td></tr></tbody>';
					
				
				}
				else{
				
					while ($reg = $rspta->fetch_object())
						{
							//<input type="text" class="form-control" name="nombrearchivo" id="nombrearchivo" maxlength="256" placeholder="Nombre">
							//'<button class="btn btn-warning" onclick="mostrar('.$reg->idrelproins.')"><li class="fa fa-eye"></li></button>'.
							//' <button class="btn btn-danger" onclick="anular('.$reg->idrelproins.')"><li class="fa fa-close"></li></button>'
							//echo '<tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td>'.$reg->iddocumento.'</td><td>'.htmlspecialchars($reg->carpeta).'</td><td>'.htmlspecialchars($reg->fuente).'</td><td>';
							
							/*
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td><a target="_blank" href="'.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).'"><button class="btn btn-success" onclick="bostrar('.$reg->iddocumento.')"><li class="fa fa-eye"></li></button></a>'.'<button class="btn btn-danger" onclick="eliminar('.$reg->iddocumento.')"><li class="fa fa-eye"></li></button></td></tr></tbody>';
							*/
							/*
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'></td></tr><tr><td><button class="btn btn-success" onclick="ver('.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).')"><li class="fa fa-eye"></li></button>'.'<button class="btn btn-danger" onclick="ver('.$reg->iddocumento.')"><li class="fa fa-eye"></li></button></td></tr></tbody>';
							*/
							echo '<thead><th><label id="lblarchivosubido">Archivo subido:</label></th></thead>';
							echo '<tbody><tr class="filas"><td><input type="text" class="form-control" name="nombrearchivo" maxlength="256" placeholder='.htmlspecialchars($reg->fuente).'><input type="hidden" name="rutaarchivo" id="rutaarchivo" value="'.htmlspecialchars($reg->carpeta).htmlspecialchars($reg->fuente).'"></td></tr></tbody>';
						}
					}	
				}
		break;
		
        case 'listar':
            $rspta = $documento->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion == 1) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->iddocumento.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->iddocumento.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->iddocumento.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->iddocumento.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->fecha,
					"2"=>$reg->nombre,
					"3"=>'<td>'.htmlspecialchars($reg->descripcion).'</td>',
                    "4"=>'<td>'.htmlspecialchars($reg->sector).'</td>',
                    "5"=>'<td>'.htmlspecialchars($reg->tipodocumento).'</td>',
					"6"=>($reg->condicion == 1) ?
                         '<span class="label bg-green">Activado</span>'
                         :      
                         '<span class="label bg-red">Desactivado</span>'
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
	
        case 'selectSector':
            require_once "../modelos/Sector.php";
            $sector = new Sector();

            $rspta = $sector->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idsector.'>'
                        .$reg->nombre.
                      '</option>';
            }
        break;
		
		case 'selectTipoDocumento':
            require_once "../modelos/TipoDocumento.php";
            $tipodocumento = new TipoDocumento();

            $rspta = $tipodocumento->select();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtipo_documento.'>'
                        .$reg->descripcion.
                      '</option>';
            }
        break;

		case 'selectDocumento':
            $rspta = $documento->listarSimple();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->iddocumento.'>'
                        .$reg->codigo.' - '.$reg->nombre.' - '.$reg->descripcion.
                      '</option>';
            }
        break;
		
		case 'selectDocumentoSector':
            $rspta = $documento->listarDocumentoSector($idsector);

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->iddocumento.'>'
                        .$reg->codigo.' - '.$reg->nombre.' - '.$reg->descripcion.
                      '</option>';
            }
        break;

    }

?>
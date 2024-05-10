<?php
    
    require_once '../modelos/Consultas.php';

    $consulta = new Consultas();

    switch($_GET["op"])
    {

        case 'consultadocumento':
			$idsector = $_GET['idsector'];
            $rspta = $consulta->consultadocumento($idsector);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->sector,
                    "1"=>$reg->codigo,
                    "2"=>$reg->nombre,
                    "3"=>$reg->descripcion,
                    "4"=>($reg->condicion == '1') ?
						 '<button class="btn btn-warning" onclick="mostrar('.$reg->iddocumento.')"><li class="fa fa-eye"></li></button></a>'
						 //'<a target="_blank" href="'.$reg->carpeta.$reg->fuente.'" <button class="btn btn-success" ><li class="fa fa-eye"></li></button></a>'
						 //'<span class="label bg-green">Aceptado</span>'
                         :      
                         '<span class="label bg-red"></span>'
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
		
		case 'listarDetalle':
		//Recibimos el iddocumento
		$id=$_GET['id'];

		$rspta = $consulta->listarDetalle($id);
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Codigo</th>
                                    <th>Instructivo</th>
									<th>Fecha</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					if($reg->ruta == ''){
						echo '<tr class="filas"><td><td>'.$reg->nombre.'</td><td>'.htmlspecialchars($reg->nombre).'</td><td>'.htmlspecialchars($reg->descripcion).'</td>';
					}else{
                        //if($reg->idtipo_documento > 1){
						echo ($reg->idtipo_documento == 1)?'<tr class="filas" style="background-color:LemonChiffon; border: black 5px"><td><a target="_blank" href="'.$reg->ruta.'" <button class="btn btn-success" ><li class="fa fa-eye"></li></button></a></td><td>'.$reg->nombre.'</td><td>'.htmlspecialchars($reg->nombre).'</td><td>'.htmlspecialchars($reg->descripcion).'</td>'
                        :'<tr class="filas"><td><a target="_blank" href="'.$reg->ruta.'" <button class="btn btn-success" ><li class="fa fa-eye"></li></button></a></td><td>'.$reg->nombre.'</td><td>'.htmlspecialchars($reg->nombre).'</td><td>'.htmlspecialchars($reg->descripcion).'</td>';
                       /* }
                        else{
                          echo  '<tr class="filas"><td><a target="_blank" href="'.$reg->ruta.'" <button class="btn btn-success" ><li class="fa fa-eye"></li></button></a></td><td>'.$reg->nombre.'</td><td>'.htmlspecialchars($reg->nombre).'</td><td>'.htmlspecialchars($reg->descripcion).'</td>';
                        }*/
					}
						
					
					//echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.htmlspecialchars($reg->nombre).'</td><td>'.htmlspecialchars($reg->descripcion).'</td>';
				}
		;
	break;

    }

?>
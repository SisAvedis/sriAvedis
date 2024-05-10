<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexionTradicional.php";

Class Reporte
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$idsectorAfectada,$titulo,$idoperario,$fecha_incidente,$involucrados,$descripcion,$analisis,$cierre,$idsectorNotificado,$idsectorInvolucrado,$imagen)
	{	global $conexion;
		$conexion->begin_transaction();
		$sw = true;
			$sql = "SELECT valor FROM numerador_serie WHERE idnumerador = 8";
            //Devuelve serie comprobante
			$serie_comprobante =  ejecutarConsultaSimpleFila($sql);
			$sql = "SELECT valor + 1 AS valor FROM numerador_comprobante WHERE idnumerador = 8";
            //Devuelve número comprobante
			$num_comprobante =  ejecutarConsultaSimpleFila($sql);
			
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			

		try {
			$sql = "INSERT INTO reporteIncidentes (
				idusuario,
				num_comprobante,
				fecha_hora,
				fecha_modificacion,
				idsectorAfectada,
				titulo,
				imagen,
				estado
				)
				VALUES (
					'$idusuario',
                    '$num_comprobante[valor]',
                    '$fecha_hora[fechahora]',
                    '$fecha_hora[fechahora]',
					'$idsectorAfectada',
					'$titulo',
					'$imagen',
					'Aceptado')";

			$idreportenew = ejecutarConsulta_retornarID($sql) or $sw = false;
			echo '<script>console.log("'.$conexion->error.'");</script>';
		}
		catch(Error $e){
			echo $e->getMessage();
		}
		//echo 'Variable sql -> '.$sql.'</br>';
		//echo 'Variable idventanew -> '.$idventanew.'</br>';

		try {



			$sql = "UPDATE numerador_comprobante SET valor='$num_comprobante[valor]' 
                   WHERE idnumerador=8";
			//echo 'Variable sql -> '.$sql.'</br>';
			ejecutarConsulta($sql) or $sw = false;

			$num_elementos = 0;
			


			// while (is_countable($idoperario) && $num_elementos < count($idoperario)) {
				$sql_detalle = "INSERT INTO detalle_reporte (
								idreporte, 
								fecha_incidente, 
								idoperario,
								involucrados,
								descripcion,
								analisis,
								cierre,
								idsectorNotificado,
								idsectorInvolucrado
							   ) 
							   VALUES (
								   '$idreportenew', 
								   '$fecha_incidente', 
								   '$idoperario',
								   '$involucrados',
								   '$descripcion',
								   '$analisis',
								   '$cierre',
								   '$idsectorNotificado',
								   '$idsectorInvolucrado'
								   )";
				ejecutarConsulta($sql_detalle) or $sw = false;
				// $num_elementos = $num_elementos + 1;
			// }
			//echo 'Variable sql_detalle -> '.$sql_detalle.'</br>';
			if($sw){
				$conexion->commit();
					  $conexion->close();
					  return $sw;}
					  else{
						  echo '<script>console.log("'.$conexion->error.'");</script>';
						  //echo $e->getMessage();
						  $conexion->rollback();
						  $conexion->query("ALTER TABLE reporteIncidentes AUTO_INCREMENT = $idreportenew;");
						  $conexion->close();
					  }
		}
		catch(Error $e){

			echo $e->getMessage();

		}
		
	}

	public function editar($idreporte, $descripcion){
			$sw = true;

			$sql="UPDATE detalle_reporte SET descripcion = '$descripcion'
			WHERE idreporte = '$idreporte'";

			ejecutarConsulta($sql) or $sw = false;

			return $sw;

	}


	public function procesar($idreporte,$analisis,$cierre, $operacion, $archivoArray)
	{	global $conexion;
		
		$conexion->begin_transaction();
		$sw = true;
			$sql = "SELECT valor FROM numerador_serie WHERE idnumerador = 8";
            //Devuelve serie comprobante
			$serie_comprobante =  ejecutarConsultaSimpleFila($sql);
			$sql = "SELECT valor AS valor FROM numerador_comprobante WHERE idnumerador = 8";
            //Devuelve número comprobante
			$num_comprobante =  ejecutarConsultaSimpleFila($sql);
			
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			echo '<script>console.log("'.$operacion.'");</script>';

		try {
			if($operacion === 'P'){
			$sql = "UPDATE reporteIncidentes 
				
				SET estado ='En Proceso',
				fecha_modificacion='$fecha_hora[fechahora]'
				WHERE idreporte = '$idreporte'";

			ejecutarConsulta($sql) or $sw = false;
			echo '<script>console.log("'.$conexion->error.'");</script>';}
			else if($operacion === 'C'){
				$sql = "UPDATE reporteIncidentes 
					
					SET estado ='Cerrado', archivos = '$archivoArray',
					fecha_modificacion='$fecha_hora[fechahora]'
					WHERE idreporte = '$idreporte'";
	
				ejecutarConsulta($sql) or $sw = false;
				echo $conexion->error;}
		}
		catch(Error $e){
			echo $e->getMessage();
		}
		//echo 'Variable sql -> '.$sql.'</br>';
		//echo 'Variable idventanew -> '.$idventanew.'</br>';

		try {



			$sql = "UPDATE numerador_comprobante SET valor='$num_comprobante[valor]' 
                   WHERE idnumerador=8";
			//echo 'Variable sql -> '.$sql.'</br>';
			ejecutarConsulta($sql) or $sw = false;

			$num_elementos = 0;
			


			// while (is_countable($idoperario) && $num_elementos < count($idoperario)) {
				$sql_detalle = "UPDATE detalle_reporte SET  
								analisis =  '$analisis',
								cierre = '$cierre'
								    WHERE idreporte =  '$idreporte'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				// $num_elementos = $num_elementos + 1;
			// }
			//echo 'Variable sql_detalle -> '.$sql_detalle.'</br>';
			if($sw){
				$conexion->commit();
					  $conexion->close();
					  return $sw;}
					  else{
						  echo $conexion->error;
						  //echo $e->getMessage();
						  $conexion->rollback();
						  $conexion->close();
					  }
		}
		catch(Error $e){

			echo $e->getMessage();

		}
		
	}

	
	//Implementamos un método para anular la venta
	public function anular($idreporte,$motivo,$idusuario)
	{
		$sql="UPDATE reporteIncidentes
			  SET estado='Anulado', anuladoPor='$idusuario',
				motivoAnulacion='$motivo'
			  WHERE idreporte='$idreporte'";

		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idreporte)
	{
		$sql="SELECT 
		r.idreporte,
		DATE_FORMAT(r.fecha_hora,'%Y-%m-%d') as fecha,
		r.titulo,
		s.idsector as areaAfectada,
		u.idusuario,
		u.nombre as usuario,
		r.num_comprobante,
		r.imagen as imagen,
		r.estado
   FROM reporteIncidentes r 
   INNER JOIN usuario u 
   ON r.idusuario=u.idusuario 
   INNER JOIN sector s 
   ON s.idsector=r.idsectorAfectada
				WHERE r.idreporte='$idreporte'";

			return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idreporte)
	{
		$sql="SELECT 
		dr.idreporte,
		dr.fecha_incidente,
		p.idpersona as idoperario,
		dr.descripcion,
		dr.involucrados,
		dr.analisis,
		dr.cierre,
		sn.idsector AS idsectorNotificado,
		si.idsector AS idsectorInvolucrados
		FROM detalle_reporte dr 
		INNER JOIN persona p 
		ON dr.idoperario=p.idpersona
		INNER JOIN sector sn
		ON dr.idsectorNotificado = sn.idsector
		INNER JOIN sector si
		ON dr.idsectorinvolucrado = si.idsector
				where dr.idreporte='$idreporte'";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
					r.idreporte,
					DATE_FORMAT(r.fecha_hora,'%Y-%m-%d') as fecha,
					r.titulo,
					s.nombre as areaAfectada,
					DATEDIFF(DATE(NOW()), DATE_FORMAT(r.fecha_modificacion,'%Y-%m-%d')) AS ultimaModificacion,
					DATEDIFF(DATE_FORMAT(r.fecha_modificacion,'%Y-%m-%d'), DATE_FORMAT(r.fecha_hora,'%Y-%m-%d')) AS duracion,
					ua.nombre as anulador,
					u.idusuario,
					u.nombre as usuario,
					r.num_comprobante,
					r.motivoAnulacion,
					r.archivos,
					r.estado 
			   FROM reporteIncidentes r 
			   INNER JOIN usuario u 
			   ON r.idusuario=u.idusuario 
			   LEFT JOIN usuario ua 
			   ON r.anuladoPor=ua.idusuario 
			   INNER JOIN sector s 
			   ON s.idsector=r.idsectorAfectada
			   
			   ORDER by  FIELD(r.estado,'Aceptado','En Proceso','Cerrado'), r.fecha_hora DESC";
			   
		return ejecutarConsulta($sql);		
	}

	public function reporteCabecera($idreporte)
	{
		// $sql="SET NAMES 'UTF8'";
		// ejecutarConsulta($sql);
		$sql= "CALL prCabeceraReporte('$idreporte')";

		return ejecutarConsulta($sql);
	}
	
	public function ventaDetalle($idventa)
	{
		$sql = "SELECT
					a.nombre as articulo,
					a.descripcion as descripcion,
					a.codigo,
					dv.cantidad,
					uo.codigo AS cod_origen
					
				FROM
					detalle_venta dv
				INNER JOIN	
					articulo a
				ON
					dv.idarticulo = a.idarticulo
				INNER JOIN ubicacion uo
				ON 
					dv.idubi_origen = uo.idubicacion
				
				WHERE
					dv.idventa = '$idventa'";

		return ejecutarConsulta($sql);
	}
public function getMaxReporte(){

	$sql="SELECT LPAD(valor+1,8,'0') as num_planilla FROM numerador_comprobante WHERE idnumerador = 8";
	return ejecutarConsulta($sql);

}

}


?>
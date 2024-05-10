<?php
    require '../config/conexion.php';

    Class Consultas
    {
        public function __construct()
        {

        }

        public function consultadocumento($idsector)
        {
            $sql = "SELECT 
                        s.nombre as sector,
					CONCAT(td.codigo,'-00',d.iddocumento) AS codigo,
                    d.iddocumento,
                        d.nombre,
						d.descripcion,
						d.condicion
                    FROM
                        documento d
					INNER JOIN sector s
					ON d.idsector = s.idsector
                    INNER JOIN tipo_documento td 
				    ON d.idtipo_documento = td.idtipo_documento
					WHERE 
						d.idsector = '$idsector'
					AND
                        d.condicion = 1
					
                    
                    ";
			//echo $sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		public function muestradocumentos($iddocumento)
        {
            $sql = "CALL prTraerArchivos('".$iddocumento."')";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function listarDetalle($iddocumento)
        {
            $sql = "CALL prTraerArchivos('".$iddocumento."')";
			//echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function totalAceptados()
        {
            $sql= "SELECT 
                        IFNULL(COUNT(*),0) as cantidad_procedimiento
                    FROM
                        reporteIncidentes
                    WHERE
                        estado = 'Aceptado'";
            
            return ejecutarConsulta($sql);
        }
		
		public function totalProcesados()
        {
            $sql= "SELECT 
                        IFNULL(COUNT(*),0) as cantidad_instructivo
                        FROM
                        reporteIncidentes
                    WHERE
                        estado = 'En Proceso'";
            
            return ejecutarConsulta($sql);
        }
        public function totalCerrados()
        {
            $sql= "SELECT 
                        IFNULL(COUNT(*),0) as cantidad_instructivo
                        FROM
                        reporteIncidentes
                    WHERE
                        estado = 'Cerrado'";
            
            return ejecutarConsulta($sql);
        }
		
		public function reportes12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);
            $sql= "SELECT 
                        CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
                             LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
                        COUNT(idreporte) as total
                        FROM
                        reporteIncidentes
                    WHERE
                        estado = 'Aceptado'
					GROUP BY
                        MONTH(fecha_hora) 
                    ORDER BY
                        fecha_hora
                    ASC limit 0,12";
            
            return ejecutarConsulta($sql);
        }
		
		public function procesados12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);

            $sql= "SELECT 
                        CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
                             LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
                        COUNT(idreporte) as total
                        FROM
                        reporteIncidentes
                    WHERE
                        estado = 'En Proceso'
					GROUP BY
                        MONTH(fecha_hora) 
                    ORDER BY
                        fecha_hora
                    ASC limit 0,12";
            
            return ejecutarConsulta($sql);
        }
        public function cerrados12meses()
        {$sql = "SET lc_time_names = es_ES";
            ejecutarConsulta($sql);

            $sql= "SELECT 
                        CONCAT(UCASE(LEFT(DATE_FORMAT(fecha_hora,'%M'), 1)), 
                             LCASE(SUBSTRING(DATE_FORMAT(fecha_hora,'%M'), 2))) as fecha,
                        COUNT(idreporte) as total
                        FROM
                        reporteIncidentes
                    WHERE
                        estado = 'Cerrado'
					GROUP BY
                        MONTH(fecha_hora) 
                    ORDER BY
                        fecha_hora
                    ASC limit 0,12";
            
            return ejecutarConsulta($sql);
        }

    }

?>
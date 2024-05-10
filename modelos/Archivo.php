<?php
    require '../config/conexion.php';

    Class Archivo 
    {
        public function __construct()
        {

        }
		
		function insert_img($title, $folder, $image){
			$con = con();
			$con->query("insert into image (title, folder,src,created_at) value (\"$title\",\"$folder\",\"$image\",NOW())");
		}
		
		
		
        public function insertar($iddocumento, $titulo, $carpeta, $archivo)
        {
            
			$sql = "SELECT NOW() AS fechahora";
			//Devuelve fecha actual
			$fecha_hora = ejecutarConsultaSimpleFila($sql);
			
			
			$sql = "INSERT INTO archivo (
                    iddocumento,
					titulo,
                    carpeta,
					fuente,
                    fecha_hora
                   ) 
                    VALUES (
						'$iddocumento',
                        '$titulo',
                        '$carpeta',
						'$archivo',
                        '$fecha_hora[fechahora]'
                        )";
            //echo 'Variable sql -> '.$sql.'</br>';
            return ejecutarConsulta($sql);
        }
		
		//METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($iddocumento)
        {
            $sql = "SELECT * FROM archivo 
                    WHERE iddocumento='$iddocumento'";

            //echo 'Variable sql -> '.$sql.'</br>';
			return ejecutarConsulta($sql);
        }
		
		public function eliminar($iddocumento)
        {
            $sql= "DELETE FROM archivo 
                   WHERE iddocumento='$iddocumento'";
            
            return ejecutarConsulta($sql);
        }
		
		

    }

?>
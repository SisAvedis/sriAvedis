<?php
    require_once 'global.php';

    $conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    
   
    mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');

    if(mysqli_connect_errno())
    {
        printf("Fallo la conexion a la base de datos: %s\n",mysqli_connect_error());
        exit();
    }

    if(!function_exists('ejecutarConsulta'))
    {
        function ejecutarConsulta($sql)
        {
            // try{
                 global $conexion;
            // $conexion->options(MYSQLI_INIT_COMMAND, "SET SESSION sql_mode='TRADITIONAL'");
            // $conexion->begin_transaction();
            $query = $conexion->query($sql);
            // $conexion->commit();
            //$conexion->close();
            // }
            // catch(Exception $e){
                // echo $e->getMessage();
                // $conexion->rollback();
                // $conexion->close();
            // }
            return $query;
        }

        function ejecutarConsultaSimpleFila($sql)
        {
            //try{
            global $conexion;
           // mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');
           // $conexion->options(MYSQLI_INIT_COMMAND, "SET SESSION sql_mode='TRADITIONAL'");
            //$conexion->begin_transaction();
            $query = $conexion->query($sql);
            //while($row = $query->fetch_assoc()){
                $row = $query->fetch_assoc();
                return $row;
          //  }
           // $conexion->commit();
           // $conexion->close();
        //     }
        //     catch(Exception $e){
        //         echo $e->getMessage();
        //         $conexion->rollback();
        //         $conexion->close();
        //     }
        //    // return $row;
        }

        function ejecutarConsulta_retornarID($sql)
        {
            global $conexion;
            $query = $conexion->query($sql);

            return $conexion->insert_id;
        }

        function limpiarCadena($str)
        {
            global $conexion;
            $str = mysqli_real_escape_string($conexion,trim($str));

            return htmlspecialchars($str, ENT_NOQUOTES, "UTF-8");
			//return htmlspecialchars($str);
        }
    }
?>
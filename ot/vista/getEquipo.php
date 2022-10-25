<?php

    session_start();
        if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
    header("location: index.php");
    exit;
    }
    
$con=mysqli_connect("localhost","jv","Jason1234","imaq_schema");
$GLOBALS['con']=$con;

function getEquipos($index_id=NULL){
    
    if($index_id==null){
        $query=mysqli_query($GLOBALS['con'],"select index_id,nombre_modelo from equipos");
        $datos=array();

        while($row=mysqli_fetch_assoc($query)){
            array_push($datos,$row);
        }
        return $datos;
    }else{
      
            $query=mysqli_query($GLOBALS['con'],"select nombre_modelo from equipos where index_id='".$index_id."'");
            $datos=array();
    
            while($row=mysqli_fetch_assoc($query)){
                array_push($datos,$row);
            }

            return $datos;
    
    }
}
echo json_encode(getEquipos());
?>

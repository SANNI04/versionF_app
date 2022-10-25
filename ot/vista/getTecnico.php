<?php

    session_start();
    if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
        header("location: index.php");
    exit;
    }
    
$con=mysqli_connect("localhost","jv","Jason1234","imaq_schema");
$GLOBALS['con']=$con;

function getTecnico($index_id=NULL){
    
    if($index_id==null){
        $query=mysqli_query($GLOBALS['con'],"select index_id,primer_nombre from usuarios");
        $datos=array();

        while($row=mysqli_fetch_assoc($query)){
            array_push($datos,$row);
        }
        return $datos;
    }else{
        
            $query=mysqli_query($GLOBALS['con'],"select primer_nombre from usuarios where index_id='".$index_id."'");
            $datos=array();
    
            while($row=mysqli_fetch_assoc($query)){
                array_push($datos,$row);
            }
            return $datos;
     
    }
}
echo json_encode(getTecnico());
?>
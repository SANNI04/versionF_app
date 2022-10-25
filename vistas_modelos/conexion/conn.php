<?php

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	

class Conexion{
    const HOST = 'localhost';
    const USER = 'jv';
    const PASSWORD ='Jason1234';
    const DB = 'imaq_schema';
}

class Configuracion extends Conexion{

    public $mysql = NULL;

    public function conectar($db= Conexion::DB){
        $this->mysql= new mysqli(Conexion::HOST, Conexion::USER, Conexion::PASSWORD,$db);
        return $this->mysql;
    }

    public function generarConsulta($consulta){
        $result=array();
        $query=mysqli_query($this->mysql, $consulta) or die("Error de la consulta: $consulta".mysqli_error());

        while($row = $query->fetch_row()){
            $result=$row[0];
        }
        
        return $result;
    }

    public function generarConsulta2($consulta){
        $items=array();
        $query=mysqli_query($this->mysql,$consulta) or die("Error de la consulta: $consulta".mysqli_error());
        
        while($obj=$query->fetch_object()){
            array_push($items,$obj);
        }
        return $items;
    }

    public function desconectarDb(){
        mysqli_close($this->mysql);
    }

    public function consulta($query){
        $i=0;
        $contenedor= array();
        $result=mysqli_query($this->mysql,$query) or die("Error de la consulta: $query".mysqli_error());
  
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $contenedor[$i] = $row;
            $i++;
        }
        return $contenedor;
    }
}

?>
<?php

class Coon2{
    const HOST = 'localhost';
    const USER = 'jv';
    const PASSWORD ='Jason1234';
    const DB = 'imaq_schema';
}

class Main2 extends Coon2{
    public $mysql = NULL;

    public function conectar($db= Coon2::DB){
        $this->mysql= new mysqli(Coon2::HOST, Coon2::USER, Coon2::PASSWORD,$db);
        return $this->mysql;
    }

    public function consultaE($query){
        $i=0;
        $contenedor= array();
        $result=mysqli_query($this->mysql,$query) or die("Error de la consulta:");
  
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $contenedor[$i] = $row;
            $i++;
        }
        return $contenedor;
    }
    public function desconectarDb(){
        mysqli_close($this->mysql);
    }


}
$conf= new Main2();
$conf->conectar();

$query="SELECT codigo_referencia,cantidad from vista_cantidad";
$resultado=$conf->consultaE($query);

$ejecutar=mysqli_query($conf->conectar(),$query);
while($fila=mysqli_fetch_array($ejecutar)){
    if($fila['codigo_referencia']==$_GET['c']){
        echo "<option value='".$fila['codigo_referencia']."'>".$fila['cantidad']."</option>";
    }
}


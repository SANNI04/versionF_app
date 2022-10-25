<?php

    class Coon{
        const HOST = 'localhost';
        const USER = 'jv';
        const PASSWORD ='Jason1234';
        const DB = 'imaq_schema';
    }

    class Main extends Coon{
        public $mysql = NULL;

        public function conectar($db= Coon::DB){
            $this->mysql= new mysqli(Coon::HOST, Coon::USER, Coon::PASSWORD,$db);
            return $this->mysql;
        }

        public function consultaR($query){
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
    $conf= new Main();
    $conf->conectar();
    $query="SELECT index_id,codigo_referencia,nombre_referencia FROM referencias";
    $resultado=$conf->consultaR($query);
    
    $ejecutar=mysqli_query($conf->conectar(),$query);

    while($fila=mysqli_fetch_array($ejecutar)){
        echo "<option value='".$fila['codigo_referencia']."'>".$fila['nombre_referencia']."</option>";
    }

    $conf->desconectarDb();
?>
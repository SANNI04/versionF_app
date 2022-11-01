<?php
require('fpdf/fpdf.php');
require("conexion.php");
$conexion = retornarConexion();
$conexion->set_charset('utf8');
header('Content-Type: text/html; charset=UTF-8');

class PDF extends FPDF{

    var $angle=0;

    function consultaNoTrabajo($conexion){
        $data=mysqli_query($conexion, "SELECT * FROM orden_trabajo WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }
    
    function consultaNoTrabajoCliente($conexion){
        $data=mysqli_query($conexion,"SELECT * FROM orden_trabajo ot join clientes c on c.index_id=ot.cliente where ot.index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }

    function fecha_mes($conexion){
        $data=mysqli_query($conexion, "SELECT MONTH (fecha_orden_trabajo) as mes FROM orden_trabajo WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }

    function fecha_año($conexion){
        $data=mysqli_query($conexion, "SELECT YEAR (fecha_orden_trabajo) as año FROM orden_trabajo WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }

    function fecha_dia($conexion){
        $data=mysqli_query($conexion, "SELECT DAY (fecha_orden_trabajo) as dia FROM orden_trabajo WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }
/**/ 
    function firma_cliente($conexion){
        $data=mysqli_query($conexion, "SELECT firma_cliente from orden_trabajo WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    } /**/
    
    function firma_tecnico($conexion){
        $data=mysqli_query($conexion, "SELECT firma_tecnico from usuarios WHERE index_id=$_GET[index_id]") or die(mysqli_error($conexion));
        $resultado = mysqli_fetch_array($data);
        return $resultado;
    }

    function margen(){
        $this->SetMargins(1,1,1); // deja definida la margen izquierda, superior y derecha
        $this->SetAutoPageBreak(true,1);   // define la margen inferior
    }
    
    function margenImagen(){
        $this->rect(1,1,213,353);
    }
    
    function numeroPagina(){
        $this->PageNo();
    }

    function logo(){
        $this->Image('imagenes/logo.png', 10, 5,-150);
    }

    function titulo(){
        $this->SetFont('Arial','B',14);
        $this->Cell(190,5,'Mantenimiento',0,0,'C');
    }

    function tituloIzq($conexion){
        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->Cell(205,5,'Hoja de Trabajo ',0,0,'R');
        $this->setY($this->GetY()+5);
        //$res="consultaNoTrabajo";  forma de llamar la funcion creada para la consulta parte 1
        //$salida=$this->$res($conexion); forma de llamar la funcion creada para la consulta parte 2
        $salida=$this->consultaNoTrabajo($conexion); // forma de llamar la funcion de manera clasica 
        $this->Cell(365,5,'N'.$salida['index_id'],0,0,'C');
        //$resultado="consultaNoTrabajo";
        //$this->Cell(205,5,'Hoja'.$this->$resultado($conexion),1,0,'L');
    }

    function tituloInicial($conexion,$w){

        $salida=$this->consultaNoTrabajo($conexion);
        $encabezadoOrden = array();
        if ($salida['tipo_orden_trabajo']=='Mantenimiento'){
            $encabezadoOrden = array('Diagnostico','','Preventivo','X','Correctivo','','Horometro','','');
        }
        if ($salida['tipo_orden_trabajo']=='Correctivo'){
            $encabezadoOrden = array('Diagnostico','','Preventivo','','Correctivo','X','Horometro','','');
        }
        if ($salida['tipo_orden_trabajo']=='Diagnostico'){
            $encabezadoOrden = array('Diagnostico','X','Preventivo','X','Correctivo','','Horometro','','');
        }
        if ($salida['tipo_orden_trabajo']=='Horometro'){
            $encabezadoOrden = array('Diagnostico','','Preventivo','X','Correctivo','','Horometro','X','');
        }
        $this->GetY();
        $this->setY($this->GetY()+10);
        $this->GetX();
        $this->setX($this->GetX()+10);
        // captura la posicion de los objetos precedentes y suma valores para ordenar y definir la posicion de inicio

        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B','10');
        // Cabecera
        for($i=0;$i<count($encabezadoOrden);$i++)
        $this->Cell($w[$i],7,$encabezadoOrden [$i],1,0,'C',false);
        $this->Ln();
        // Restauración de colores y fuentes
        //$this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
    }


    function tituloCliente($header,$z){
        $this->SetFont('','B','10');
        $this->GetY();
        $this->setY($this->GetY()+1);
        $this->GetX();
        $this->setX($this->GetX()+10);
        for($i=0;$i<count($header);$i++)
        $this->Cell($z[$i],7,$header[$i],1,0,'C',false);
        $this->Ln();
        $this->SetTextColor(0);
        $this->SetFont('');
    }

    function datosCliente($conexion,$h){
        $this->SetFont('','B','10');
        $this->GetY();
        $this->setY($this->GetY()+1);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $resultadoCliente=$this->consultaNoTrabajoCliente($conexion);
        $resultadoFecha=$this->fecha_mes($conexion);
        $resultadoFechaAño=$this->fecha_año($conexion);
        $resultadoFechaDia=$this->fecha_dia($conexion);
       

        $header = array('Empresa:',$resultadoCliente['nombre_cliente'],'Voltaje:',$resultadoCliente['voltaje'],'Marca:',$resultadoCliente['marca'],'Dia:',$resultadoFechaDia['dia']);
        $header1 = array('Persona Encargada:',$resultadoCliente['persona_encargada'],'Amperaje:',$resultadoCliente['amperaje'],'Modelo:',$resultadoCliente['modelo'],'Mes:',$resultadoFecha['mes']);
        $header2 = array('Ubicacion:',$resultadoCliente['sucursal'],'Clavija',$resultadoCliente['clavija'],'Serie:',$resultadoCliente['serie'],'Año:',$resultadoFechaAño['año']);
        $header3 = array('Tecnico:',$resultadoCliente['tecnico'],'','','','','','');


        for($i=0;$i<count($header);$i++) 
                $this->Cell($h[$i],7,$header[$i],1,0,'C',false);
                $this->Ln();
                $this->setX($this->GetX()+10);
        for($i=0;$i<count($header1);$i++) 
                $this->Cell($h[$i],7,$header1[$i],1,0,'C',false);
                $this->Ln();
                $this->setX($this->GetX()+10);
        for($i=0;$i<count($header2);$i++) 
                $this->Cell($h[$i],7,$header2[$i],1,0,'C',false);
                $this->Ln();
                $this->setX($this->GetX()+10);    
        for($i=0;$i<count($header3);$i++) 
                $this->Cell($h[$i],7,$header3[$i],1,0,'C',false);
                $this->Ln();
                $this->setX($this->GetX()+10);       
            
            
        
        //$this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
    }

    function TextWithDirection($x, $y, $txt, $direction='R')    
    {
        if ($direction=='R')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='L')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='U')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='D')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        else
            $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        if ($this->ColorFlag)
            $s='q '.$this->TextColor.' '.$s.' Q';
        $this->_out($s);
    }

    function datosItems(){
        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->GetX();
        $this->setX($this->GetX()+10);

        $this->Cell(51,5,'',1,0,'C',false);  // lado derecho primer cuadro
        $this->Cell(47,5,'',1,0,'C',false);  // lado derecho segundo cuadro
        $this->Cell(49,5,'',1,0,'C',false);  // lado izquierdo primer cuadro
        $this->Cell(48,5,'',1,0,'C',false);  // lado izquierdo segundo cuadro

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->SetFont('','B','8');
        $texto1=$this->TextWithDirection(14,102,'Bastidos/Estructura','U');  // texto vertical cuadro 1 , setFont anterior setea tamaño de la letra
        $texto2=$this->TextWithDirection(112,102,'Mastil','U');  // texto vertical cuadro 1 , setFont anterior setea tamaño de la letra
        $texto3=$this->TextWithDirection(14,120,'Marcha','U');  // 
        $texto4=$this->TextWithDirection(112,148,'Hidraulica','U');  // 
        $texto5=$this->TextWithDirection(14,148,'Freno','U');  // 
        $texto6=$this->TextWithDirection(14,186,'Direccion','U');  // 
        $texto7=$this->TextWithDirection(112,182,'Bateria','U');  // 
        $texto8=$this->TextWithDirection(14,236,'Instalacion Electrica','U');  // 
        $texto9=$this->TextWithDirection(112,219,'Accesorios','U');  // 
        $texto10=$this->TextWithDirection(112,240,'Ruedas','U');  // 


        $this->Cell(4,30,$texto1,1,0,'C',false);  // cuadro 1 lado derecho pequeño hasta abajo 6 posiciones
        $this->Cell(47,5,'Estado chasis',1,0,'C',false);  // cuadro 2 lado derecho mitad
        $this->Cell(47,5,'',1,0,'C',false);  // cuadro 3 lado derecho otra mitad
        $this->Cell(4,50,$texto2,1,0,'C',false);  // cuadro 1 lado izquierdo pequeño hasta abajo 6 posiciones
        $this->Cell(45,5,'Fugas',1,0,'C',false);  // cuadro 2 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);  // cuadro 3 lado izquierdo otra mitad
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);

        $this->Cell(47,5,'Estado Cubiertas',1,0,'C',false);  // rectangulo 1 cuadro 2 lado derecho mitad
        $this->Cell(47,5,'',1,0,'C',false);  // rectangulo 1 lado derecho otra mitad
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estado Mangueras',1,0,'C',false);  // rectangulo 1 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);  // rectangulo 1 lado derecho otra  mitad


        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Pintura',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estado Poleas',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);  

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Golpes',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Elongacion Cadenas',1,0,'C',false);  // rectangulo 1 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);  // rectangulo 1 lado derecho otra  mitad

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Tornillos',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estado Cilindros',1,0,'C',false);  // rectangulo 1 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);  // rectangulo 1 lado derecho otra  mitad


        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Asientos',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Bloque Valvulas',1,0,'C',false);  // rectangulo 1 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);  // rectangulo 1 lado derecho otra  mitad
        

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->Cell(4,25,$texto3,1,0,'C',false);
        $this->Cell(47,5,'Estado Motores',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Funcionamiento',1,0,'C',false);  // cuadro 2 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado Escobillas',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Piezas Deslizantes',1,0,'C',false);  // cuadro 2 lado izquierdo mitad
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Nivel Aceite Transm',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Lubricacion Espejo',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado Transmision',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estados Horquillas',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Fugas',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+0);
        $this->Cell(4,35,$texto4,1,0,'C',false);
        $this->GetX();
        $this->setX($this->GetX()+0);
        $this->Cell(45,5,'Estado de Filtros',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+112);
        $this->Cell(45,5,'Fugas',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
    

        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->Cell(4,30,$texto5,1,0,'C',false);
        $this->Cell(47,5,'Estado de Frenos',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado de Bandas',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Nivel De Aceite',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Funcionamiento',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Tanque o Deposito',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Nivel de liquido',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Funcionamiento',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'ajuste de Frenos',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Motor de Elevacion',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Prueba de Frenado',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Escobillas',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
        
     
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->Cell(4,40,$texto6,1,0,'C',false);
        $this->setX($this->GetX()+94);
        $this->Cell(4,40,$texto7,1,0,'C',false);  

        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado del Motor',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estado Interconectores',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado Cadena',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Estado Tornillos',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado Piñon',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Voltaje',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Nivel De Aceite',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Caida De voltaje',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Lubricacion',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Cubiertas',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Escobillas',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Postes',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Eje De Direccion',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Sulfatacion',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Funcionamiento',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Nivel Electrolito',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->Cell(4,45,$texto8,1,0,'C',false);
        $this->setX($this->GetX()+94);
        $this->Cell(4,25,$texto9,1,0,'C',false); 
        

        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Fusibles',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Exploradoras',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Controladores',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Luz giratoria',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado de Cables',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Cinturon',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Funcionamiento',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Extintor',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Indicador o Display',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Cargador',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Multipiloto o Joystick',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Rueda Motriz',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+0);
        $this->GetX();
        $this->setX($this->GetX()+108);
        $this->Cell(4,20,$texto10,1,0,'C',false); 

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Estado Contactos',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Ruedas De Apoyo',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Contactor',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Ruedas de Direccion ',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+14);
        $this->Cell(47,5,'Otros',1,0,'C',false);
        $this->Cell(47,5,'',1,0,'C',false);
        $this->setX($this->GetX()+4);
        $this->Cell(45,5,'Ruedas de Carga',1,0,'C',false);  
        $this->Cell(48,5,'',1,0,'C',false);
    }


    function observaciones($conexion){

        $salida=$this->consultaNoTrabajo($conexion);
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->SetFont('','B','12');
        $this->Cell(195,10,'Observciones Generales',1,0,'C',false); 
        $this->GetY();
        $this->setY($this->GetY()+10);
        $this->GetX();
        $this->setX($this->GetX()+10); 
        $this->Cell(195,25,$salida['observaciones'],1,0,'C',false); 
        $this->GetY(); 
        $this->GetX();
    }

    function repuestosSugeridos(){
        $this->setY($this->GetY()+25);
        $this->setX($this->GetX()+10);
        $this->GetY(); 
        $this->GetX(); 
        $this->Cell(98,5,'Repuestos Sugeridos',1,0,'C',false);  // titulo
        $this->setY($this->GetY()+5);
        $this->setX($this->GetX()+10);
        $this->Cell(98,25,'',1,0,'C',false);
        $this->setY($this->GetY()+0);
    }

    function repuestosInstalados(){
        $this->setY($this->GetY()-5);
        $this->setX($this->GetX()+108); 
        $this->Cell(97,5,'Repuestos Instalados',1,0,'C',false);  // titulo
        $this->GetY(); 
        $this->GetX();
        $this->setY($this->GetY()+5);
        $this->setX($this->GetX()+108);  // titulo
        $this->Cell(97,25,'',1,0,'C',false);
    }

    function estados($conexion){
        $salida=$this->consultaNoTrabajo($conexion);
        $this->GetY();
        $this->setY($this->GetY()+25);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->SetFont('','B','8');

        $this->Cell(51,5,'Estado del Equipo:',1,0,'C',false);  // lado derecho primer cuadro
        $this->Cell(47,5,$salida['estado_equipo'],1,0,'C',false);  // lado derecho segundo cuadro
        $this->Cell(28,5,'Hora inicio:',1,0,'C',false); 
        $this->Cell(20,5,$salida['hora_inicio'],1,0,'C',false); 
        $this->Cell(28,5,'Hora Fin:',1,0,'C',false); 
        $this->Cell(21,5,$salida['hora_finalizacion'],1,0,'C',false);   
    }

    function firmaTitulo(){
   
        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
        $this->SetFont('','B','8');
        $this->Cell(98,5,'Firma Tecnico:',1,0,'C',false);
    /**/$this->Cell(97,5,'Firma Cliente:',1,0,'C',false);
    }

    function firma($conexion){
    /**/$resultadoFirmaCliente=$this->firma_cliente($conexion);
        $resultadoFirmaTecnico=$this->firma_tecnico($conexion);

        $this->GetY();
        $this->setY($this->GetY()+5);
        $this->GetX();
        $this->setX($this->GetX()+10);
       
        $this->Cell(98,25, $this->Image('imagenes/logo.png', 35, 323, -150),1,0,'C',false);
          /*NOTA: esta es la correcta trae las rutas de la base de datos pero como en el momento no tiene rutas lo dejo como estaba para que cargue
        $this->Cell(97,25, $this->Image($resultadoFirmaTecnico['firma_tecnico'], 140, 325,-150),1,0,'C',false);*/

        $this->Cell(97,25, $this->Image('imagenes/logo.png', 135, 323, -150),1,0,'C',false);
        /*NOTA: esta es la correcta trae las rutas de la base de datos pero como en el momento no tiene rutas lo dejo como estaba para que cargue
        $this->Cell(97,25, $this->Image($resultadoFirmaCliente['firma_cliente'], 140, 325,-150),1,0,'C',false);*/
    }


}

$pdf= new PDF('P', 'mm', 'Legal', true);
$pdf->AliasNbPages();
$pdf->AddPage('portrait', 'Legal');


$w = array(30, 5, 30, 5, 30, 5, 30, 5, 55);
$encabezadoDatos = array('Datos Cliente','Cargador/Bateria','Equipo','Fecha');
$z = array(80,45,40,30);
$h = array(36,44,18,27,18,22,14,16);

$pdf->margen();
$pdf->margenImagen();
$pdf->numeroPagina();
$pdf->logo();
$pdf->titulo();
$pdf->tituloIzq($conexion);
$pdf->tituloInicial($conexion,$w);
$pdf->tituloCliente($encabezadoDatos,$z);
$pdf->datosCliente($conexion,$h);
$pdf->datosItems();
$pdf->observaciones($conexion);
$pdf->repuestosSugeridos();
$pdf->repuestosInstalados();
$pdf->estados($conexion);
$pdf->firmaTitulo(); /**/ 
$pdf->firma($conexion); 
//$pdf->consultaNoTrabajo($conexion);


$pdf->OutPut();


<?php
require('fpdf/fpdf.php');
require("conexion.php");
$conexion = retornarConexion();
$conexion->set_charset('utf8');
header('Content-Type: text/html; charset=UTF-8');


$fpdf = new FPDF('P', 'mm', 'letter', true);
$fpdf->AddPage('portrait', 'letter');
$fpdf->SetMargins(10, 30, 20, 20);
cabecera($fpdf, $conexion);
piedepagina($fpdf);
titulosdetalle($fpdf);
imprimirdetalle($fpdf, $conexion);
piedepagina($fpdf);

$fpdf->OutPut();

function cabecera($fpdf, $conexion)
{
    
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->PageNo();
    $fpdf->Rect(0, 30, 220, 2, 'F');
    $fpdf->SetFont('Arial', 'B', 15);
    $fpdf->SetTextColor(255, 255, 255);
    $fpdf->Image('imagenes/logo.png', 10, 5);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetX(125);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(10,-5,utf8_decode("www.imaq.co"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,3,utf8_decode("NIT.901353314-0"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,11,utf8_decode("Carrera 13a #5a-20  Conjunto Industrial El Porvenir 2"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,19,utf8_decode("Mosquera-Cundinamarca"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,27,utf8_decode("®"));
    

    $datos = mysqli_query($conexion, "select concat(extract(month from fecha_cotizacion),concat(substring(extract(year from fecha_cotizacion),3),'-',cot.index_id)) as index_id,nombre_cliente,identificacion,direccion,telefono,email,contacto_cliente,
                                        date_format(fecha_cotizacion,'%Y-%m-%d') as fecha,vigencia,ciudad,origen
                                        from cotizaciones as cot
                                        join clientes as cli on cli.index_id=cot.codigocliente
                                        join detallecotizacion as deta on cot.cod_cotizacion=deta.codigocotizacion
                                        where deta.codigocotizacion=$_GET[cod_cotizacion]") or die(mysqli_error($conexion));
    $resultado = mysqli_fetch_array($datos);
    if($resultado){
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->SetTextColor(10, 10, 10);
    $fpdf->SetY(35);
    $fpdf->Cell(20,10,utf8_decode("Señores(as) : ").$resultado['nombre_cliente'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(0,20,"Nit : ".$resultado['identificacion'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,30,utf8_decode("Dirección : ").$resultado['direccion'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(180);
    $fpdf->Cell(10,10,utf8_decode("Cotización # : ").$resultado['index_id'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->setTextColor(0,0,0);
    $fpdf->Cell(20,40,utf8_decode("Teléfono : ").$resultado['telefono'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(177);
    $fpdf->Cell(10,20,"Fecha  : ".$resultado['fecha'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->setTextColor(0,0,0);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->Cell(20,50,"Ciudad : ".$resultado['ciudad'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(182);
    $fpdf->Cell(10,30,"Vigencia  : ".$resultado['vigencia'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->setTextColor(0,0,0);
    $fpdf->Cell(20,60,"Contacto Imaq : ".$resultado['contacto_cliente'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,70,"Email: ".$resultado['email'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,80,"Origen: ".$resultado['origen'],0,0,'L',0);
    }
else{
    
    $datos = mysqli_query($conexion, "select concat(extract(month from fecha_cotizacion),concat(substring(extract(year from fecha_cotizacion),3),'-',cot.index_id)) as index_id,nombre_cliente,identificacion,direccion,telefono,email,contacto_cliente,
                                        date_format(fecha_cotizacion,'%Y-%m-%d') as fecha,vigencia,ciudad,origen
                                        from cotizaciones as cot
                                        join clientes as cli on cli.index_id=cot.codigocliente
                                         where cot.cod_cotizacion=$_GET[cod_cotizacion]") or die(mysqli_error($conexion));
    $resultado = mysqli_fetch_array($datos);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->SetTextColor(10, 10, 10);
    $fpdf->SetY(35);
    $fpdf->Cell(20,10,utf8_decode("Señores(as) : ").$resultado['nombre_cliente'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(0,20,"Nit : ".$resultado['identificacion'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,30,utf8_decode("Dirección : ").$resultado['direccion'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(180);
    $fpdf->Cell(10,10,utf8_decode("Cotización # : ").$resultado['index_id'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->setTextColor(0,0,0);
    $fpdf->Cell(20,40,utf8_decode("Teléfono : ").$resultado['telefono'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(177);
    $fpdf->Cell(10,20,"Fecha  : ".$resultado['fecha'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->setTextColor(0,0,0);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->Cell(20,50,"Ciudad : ".$resultado['ciudad'],0,0,'L',0);
    $fpdf->setTextColor(255,0,0);
    $fpdf->SetFont('Arial', 'B', 13);
    $fpdf->SetX(182);
    $fpdf->Cell(10,30,"Vigencia  : ".$resultado['vigencia'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->setTextColor(0,0,0);
    $fpdf->Cell(20,60,"Contacto Imaq : ".$resultado['contacto_cliente'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,70,"Email: ".$resultado['email'],0,0,'L',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,80,"Origen: ".$resultado['origen'],0,0,'L',0);
}
}


function cabeceraPlus($fpdf, $conexion)
{
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->PageNo();
    $fpdf->Rect(0, 30, 220, 2, 'F');
    $fpdf->SetFont('Arial', 'B', 15);
    $fpdf->SetTextColor(255, 255, 255);
    $fpdf->Image('imagenes/logo.png', 10, 5);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetX(125);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(10,-5,utf8_decode("www.imaq.co"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,3,utf8_decode("NIT.901353314-0"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,11,utf8_decode("Carrera 13a #5a-20  Conjunto Industrial El Porvenir 2"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,19,utf8_decode("Mosquera-Cundinamarca"));
    $fpdf->SetX(125);
    $fpdf->Cell(10,27,utf8_decode("®"));
}
 

function titulosdetalle($fpdf)
{
 
    $fpdf->SetY(90);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->Cell(10, 10, 'Cod', 1, 0, 'C', 1);
    $fpdf->Cell(40, 10,utf8_decode('Descripción'), 1, 0, 'C', 1);
    $fpdf->Cell(25, 10, 'Cantidad', 1, 0, 'C', 1);
    $fpdf->Cell(20, 10, 'T Entrega', 1, 0, 'C', 1);
    $fpdf->Cell(25, 10, 'V unit', 1, 0, 'C', 1);
    $fpdf->Cell(25, 10, 'Subtotal', 1, 0, 'C', 1);
    $fpdf->Cell(15, 10, 'Dcto', 1, 0, 'C', 1);
    $fpdf->Cell(30, 10, 'Total', 1, 0, 'C', 1);
}


function titulosdetallePlus($fpdf)
{
    $fpdf->SetY(65);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(241, 237, 19);
}



function piedepagina($fpdf)
{
   
    $fpdf->SetY(220);
    $fpdf->SetFont('Arial','B',8); 
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->Cell(193,10,'TENER EN CUENTA QUE ESTOS PRECIOS SE SOSTIENEN DURANTE VIGENCIA DE LA MISMA A PARTIR DE LA FECHA (5 DIAS CALENDARIO)',0,1,'C','F');
    
    $fpdf->Image('imagenes/logo3.png', 8,247, 197 , 30);
   
    /* $fpdf->SetFillColor(242, 237, 19);
    $fpdf->Rect(0, 260, 220, 20, 'F');
    $fpdf->SetY(-40);*/
    $fpdf->SetFont('Arial', '', 12);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetY(235);
    $fpdf->Cell(0,10,'Page '.$fpdf->PageNo(),0,0,'C');
  
}


function imprimirdetalle($fpdf, $conexion)
{
    $datos = mysqli_query($conexion, "select pro.index_id as codigo,cot.cod_cotizacion,
                                             nombre_referencia,
                                             round(deta.precio,2) as precio,
                                             cantidad,
                                             descuento,
                                             5 entrega,
                                             19 as iva,
                                             (descuento/100) as descuentofinal,
                                             round (deta.precio*cantidad,2) as preciototal,
                                             deta.index_id as coddetalle,
                                             deta.activo
                                          from detallecotizacion as deta
                                          join referencias as pro on pro.index_id=deta.codigoproducto
                                          join cotizaciones as cot on deta.codigocotizacion = cot.cod_cotizacion
                                          where codigocotizacion=$_GET[cod_cotizacion] and deta.activo=1") or die(mysqli_error($conexion));
  
    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    if ($resultado){
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetFont('times', '', 10);
    $fpdf->SetY(100);
    $fpdf->SetLineWidth(0.2);
    $pago=0;
    $item=0;
    foreach ($resultado as $fila) {
        $fpdf->Cell(10, 10, $fila['codigo'], 1, 0, 'C', 1);
        $fpdf->Cell(40, 10, $fila['nombre_referencia'], 1, 0, 'L', 1);
        $fpdf->Cell(25, 10, $fila['cantidad'], 1, 0, 'R', 1);
        $fpdf->Cell(20, 10, $fila['entrega'], 1, 0, 'R', 1);
        $fpdf->Cell(25, 10, '$'.number_format($fila['precio'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(25, 10, '$'.number_format($fila['preciototal'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(15, 10, '%'.number_format($fila['descuentofinal'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(30, 10, '$'.number_format($fila['preciototal']-($fila['preciototal']*$fila['descuentofinal']),2,',','.'), 1, 0, 'R', 1);
        $fpdf->Ln(); 
        $pago= $pago+$fila['preciototal']-($fila['preciototal']*$fila['descuentofinal']);
        $item++;
        $iva=($pago*($fila['iva'])/100);
        $pagoFinal=$pago+$iva;

        //$descuentofinal= $descuento/100;
        //$pago= $fila['preciototal']-($fila['preciototal']*$fila['descuentofinal']);
        //$descuentofinal= ($precio*$descuento)+$precio;
        //$pago=$pago+$fila['preciototal'];
        //$item++;
       // $iva=($pago*$fila['iva'])/100;
       // $pagoFinal=$pago+$iva;

        if ($item==11) {
            $fpdf->AddPage('portrait', 'letter');
            $fpdf->SetMargins(10, 30, 20, 20);
            $fpdf->SetY(10); 
            cabeceraPlus($fpdf, $conexion);
            piedepagina($fpdf);            
            titulosdetallePlus($fpdf);
            $fpdf->SetTextColor(0, 0, 0);
            $fpdf->SetFillColor(255, 255, 255);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->SetY(45);  //ESPACIO DE LA SEGUNDA HOJA
            $fpdf->SetLineWidth(0.2);        
            $item=0;
        }
    }
    $fpdf->SetFont('Arial', 'B', 8);
    $fpdf->Cell(145, 20, "Observaciones: La entrega de repuestos se contara en dias habiles,".$fila['nombre_referencia'], 1, 0, 'L', 1);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(45, 20, "IVA 19%: $".number_format($iva,2,',','.'), 1, 0, 'R', 1);
    $fpdf->ln();
    $fpdf->SetY(170);
    $fpdf->Cell(120, 20, " ", 0, 0, 'L', 1);
    $fpdf->Cell(70, 20, "Total: $".number_format($pagoFinal,2,',','.'), 1, 0, 'R', 1);
}
else{
    
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetFont('times', '', 10);
    $fpdf->SetY(100);
    $fpdf->SetLineWidth(0.2);
    $pago=0;
    $item=0;
    foreach ($resultado as $fila) {
        $fpdf->Cell(30, 10, $fila['codigo'], 1, 0, 'C', 1);
        $fpdf->Cell(50, 10, $fila['nombre_referencia'], 1, 0, 'L', 1);
        $fpdf->Cell(20, 10, $fila['cantidad'], 1, 0, 'R', 1);
        $fpdf->Cell(20, 10, $fila['entrega'], 1, 0, 'R', 1);
        $fpdf->Cell(25, 10, '$'.number_format($fila['precio'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(15, 10, '%'.number_format($fila['descuento'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Cell(30, 10, '$'.number_format($fila['preciototal'],2,',','.'), 1, 0, 'R', 1);
        $fpdf->Ln();    
        $pago=$pago+$fila['preciototal'];
        $item++;
        $iva=($pago*$fila['iva'])/100;
        $pagoFinal=$pago+$iva;

        if ($item==14) {
            $fpdf->AddPage('portrait', 'letter');
            $fpdf->SetMargins(10, 30, 20, 20);
            cabeceraPlus($fpdf, $conexion);
            piedepagina($fpdf);            
            titulosdetallePlus($fpdf);
            $fpdf->SetTextColor(0, 0, 0);
            $fpdf->SetFillColor(255, 255, 255);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->SetY(45);  //ESPACIO DE LA SEGUNDA HOJA
            $fpdf->SetLineWidth(0.2);        
            $item=0;
        }
    }
    $fpdf->SetFont('Arial', 'B', 8);
    $fpdf->Cell(145, 20, "Observaciones: La entrega de repuestos se contara en dias habiles,", 1, 0, 'L', 1);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(45, 20, "IVA 19%: $", 1, 0, 'R', 1);
    $fpdf->ln();
    $fpdf->SetY(170);
    $fpdf->Cell(120, 20, " ", 0, 0, 'L', 1);
    $fpdf->Cell(70, 20, "Total: $", 1, 0, 'R', 1);

}
} 


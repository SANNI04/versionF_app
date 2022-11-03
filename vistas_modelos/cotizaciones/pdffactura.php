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

$fpdf->OutPut();


function cabecera($fpdf, $conexion)
{
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->PageNo();
    $fpdf->Rect(0, 30, 220, 2, 'F');
    $fpdf->SetFont('Arial', 'B', 15);
    $fpdf->SetTextColor(255, 255, 255);
    $fpdf->Image('imagenes/logo.png', 10, 2);
    $fpdf->Image('imagenes/logo2.png', 130, 2);
    $datos = mysqli_query($conexion, "select cot.index_id,nombre_cliente,identificacion,direccion,telefono,email,contacto_cliente,
                                             date_format(fecha_cotizacion,'%d/%m/%Y') as fecha,vigencia,ciudad
                                         from cotizaciones as cot
                                         join clientes as cli on cli.index_id=cot.codigocliente
                                         join detallefactura as deta on cot.cod_cotizacion=deta.codigocotizacion
                                         where deta.codigocotizacion=$_GET[cod_cotizacion]") or die(mysqli_error($conexion));
    $resultado = mysqli_fetch_array($datos);
    $fpdf->SetFont('Arial', '', 12);
    $fpdf->SetTextColor(10, 10, 10);
    $fpdf->SetY(35);
    $fpdf->Cell(20,10,"Señores(as) : ".$resultado['nombre_cliente'],0,0,'L',0);
    $fpdf->Cell(160,10,"Nit : ".$resultado['identificacion'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,20,"Direccion : ".$resultado['direccion'],0,0,'L',0);
    $fpdf->Cell(160,20,"Cotizacion # : ".$resultado['index_id'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,30,"Telefono : ".$resultado['telefono'],0,0,'L',0);
    $fpdf->Cell(160,30,"Fecha  : ".$resultado['fecha'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,40,"Ciudad : ".$resultado['ciudad'],0,0,'L',0); 
    $fpdf->Cell(160,40,"Vigencia  : ".$resultado['vigencia'],0,0,'R',0);
    $fpdf->SetY(35);
    $fpdf->Cell(20,50,"Contacto Imaq : ".$resultado['contacto_cliente'],0,0,'L',0);
    $fpdf->Cell(160,50,"Email: ".$resultado['email'],0,0,'R',0);
   
}


function cabeceraPlus($fpdf, $conexion)
{
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->PageNo();
    $fpdf->Rect(0, 30, 220, 2, 'F');
    $fpdf->SetFont('Arial', 'B', 15);
    $fpdf->SetTextColor(255, 255, 255);
    $fpdf->Image('imagenes/logo.png', 10, 2);
    $fpdf->Image('imagenes/logo2.png', 130, 2);


}


function titulosdetalle($fpdf)
{
    $fpdf->SetY(65);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->Cell(30, 10, 'Cod', 1, 0, 'C', 1);
    $fpdf->Cell(50, 10, 'Descripción', 1, 0, 'L', 1);
    $fpdf->Cell(20, 10, 'Cantidad', 1, 0, 'C', 1);
    $fpdf->Cell(20, 10, 'T Entrega', 1, 0, 'L', 1);
    $fpdf->Cell(25, 10, 'V unit', 1, 0, 'R', 1);
    $fpdf->Cell(15, 10, 'Dcto', 1, 0, 'R', 1);
    $fpdf->Cell(30, 10, 'Total', 1, 0, 'R', 1);
}


function titulosdetallePlus($fpdf)
{
    $fpdf->SetY(65);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(241, 237, 19);
}



function piedepagina($fpdf)
{
    $fpdf->SetFillColor(241, 237, 19);
    $fpdf->Rect(0, 265, 220, 20, 'F');
    $fpdf->SetY(-28);
    $fpdf->SetFont('Arial', '', 12);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetY(-32);
    $fpdf->Cell(0,10,'Page '.$fpdf->PageNo(),0,0,'C');
}


function imprimirdetalle($fpdf, $conexion)
{
    $datos = mysqli_query($conexion, "select pro.index_id as codigo,cot.cod_cotizacion,
                                             nombre_referencia,
                                             round(deta.precio,2) as precio,
                                             cantidad,
                                             0 as descuento,
                                             5 entrega,
                                             19 as iva,
                                             round(deta.precio*cantidad,2) as preciototal,
                                             deta.index_id as coddetalle
                                          from detallefactura as deta
                                          join referencias as pro on pro.index_id=deta.codigoproducto
                                          join cotizaciones as cot on deta.codigocotizacion = cot.cod_cotizacion
                                          where codigocotizacion=$_GET[cod_cotizacion]") or die(mysqli_error($conexion));
  
    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->SetFillColor(255, 255, 255);
    $fpdf->SetFont('times', '', 10);
    $fpdf->SetY(75);
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
            $fpdf->SetY(75);
            $fpdf->SetLineWidth(0.2);        
            $item=0;
           
        }
    }
    $fpdf->SetFont('Arial', 'B', 6);
    $fpdf->Cell(145, 20, "Observaciones: La entrega de repuestos se contara en dias habiles,".$fila['nombre_referencia'], 1, 0, 'L', 1);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(45, 20, "Iva 19%: $".number_format($iva,2,',','.'), 1, 0, 'R', 1);
    $fpdf->ln();
    $fpdf->SetY(225);
    $fpdf->Cell(120, 20, " ", 0, 0, 'L', 1);
    $fpdf->Cell(70, 20, "Total: $".number_format($pagoFinal,2,',','.'), 1, 0, 'R', 1);
   
} 
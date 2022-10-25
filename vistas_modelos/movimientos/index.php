<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

    include '../conexion/conn.php';

    $conf= new Configuracion();
    $conf->conectar();
    $query=mysqli_query($conf->conectar(), "SELECT codigo_referencia from referencias");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Application</title>
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/black/easyui.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/color.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../js/datagrid-export.js"></script>
</head>
</head>
<body>
<div style="margin:20px 0;">
        <a href="javascript:;" class="easyui-linkbutton" onclick="$('#dg').datagrid('toExcel','dg.xls')">ExportToExcel</a>
        <a href="javascript:;" class="easyui-linkbutton" onclick="$('#dg').datagrid('print','DataGrid')">Print</a>

    <table id="dg" title="Movimientos" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/movimientos/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
				<th field="index_id" width="50">Id</th>
                <th field="codigo_referencia" width="50">Codigo Referencia</th>
                <th field="cantidad" width="50">Cantidad</th>
                <th field="fecha_salida" width="50">Fecha Salida</th>
                <th field="fecha_entrada" width="50">Fecha Entrada</th>
            </tr>
        </thead>
    </table>
<script>
    $(function(){
            url = "../vistas_modelos/movimientos/get_users.php";
            $('#dg').datagrid({
                rownumbers: true,
                singleSelect: true,
                data: url
            });
        });
        function toPdf(){
            var body = $('#dg').datagrid('toArray');
            var docDefinition = {
                content: [{
                    table: {
                        headerRows: 1,
                        widths: ['*','*','*','*','*'],
                        body: body
                    }
                }]
            };
            pdfMake.createPdf(docDefinition).open();
        }
    </script>
</body>
</html>
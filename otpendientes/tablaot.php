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
    <script type="text/javascript" src="../js/datagrid-filter.js"></script>
</head>
<body>
<table id="dg" title="OT PENDIENTES" class="easyui-datagrid" style="width:1150px;height:500px"
            url="get_ot.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true"  data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
                <th field="codigo_orden_trabajo" width="50" data-options="sortable:true">Codigo Orden</th>
                <th field="tipo_orden_trabajo" width="50" data-options="sortable:true">Tipo Orden</th>
                <th field="codigo_factura" width="50" data-options="sortable:true">Factura</th>
                <th field="codigo_cotizacion" width="50" data-options="sortable:true">Cotizacion</th>
                <th field="repuestos" width="50">Repuestos Sugeridos</th>
                <th field="cod_orden_compra" width="50" data-options="sortable:true">Orden Compra</th>
                <th field="nota_entrada" width="50" data-options="sortable:true">Nota Entrada</th>
            </tr>
        </thead>
    </table>
</body>
<script>
$(function(){
            var dg = $('#dg').datagrid({
                filterBtnIconCls:'icon-filter'
            });
            dg.datagrid('enableFilter',[{

            }]);
        })
</script>
</html>    
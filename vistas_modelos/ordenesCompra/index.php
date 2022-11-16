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
    $query1=mysqli_query($conf->conectar(), "SELECT primer_nombre from usuarios");
    $query2=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes");
    $query3=mysqli_query($conf->conectar(), "SELECT cod_cotizacion from cotizaciones");
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
    <script type="text/javascript" src="../js/datagrid-filter.js"></script>
</head>
</head>
<body>

    <table id="dg" title="Ordenes de Compra" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/ordenesCompra/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true"  data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
		<th field="index_id" width="50">Id</th>
                <th field="codigo_orden" width="50" data-options="sortable:true">Codigo Orden</th>
                <th field="codigo_referencia" width="50" data-options="sortable:true">Codigo Referencia</th>
                <th field="cantidad" width="50" data-options="sortable:true">Cantidad</th>
                <th field="precio_unitario" width="50" data-options="sortable:true">Precio Unitario</th>
                <th field="precio_total" width="50" data-options="sortable:true">Precio Total</th>
                <th field="codigo_solicitante" width="50" data-options="sortable:true">Codigo Solicitante</th>
                <th field="concepto" width="50" data-options="sortable:true">Concepto</th>
                <th field="codigo_cliente_salida" width="50" data-options="sortable:true">Codigo Cliente Salida</th>
                <th field="fecha_ingreso" width="50" data-options="sortable:true">Fecha Ingreso</th>
                <th field="fecha_salida" width="50" data-options="sortable:true">Fecha Salida</th>
                <th field="estatus" width="50" data-options="sortable:true">Estatus</th>
                <th field="cod_cotizacion" width="50" data-options="sortable:true">Cod Cotizacion</th>
                <th field="cod_factura" width="50" data-options="sortable:true">Cod Factura</th>


            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Ordenes de Compra</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="codigo_orden" class="easyui-textbox" required="true" label="Codigo Orden:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_referencia" label="Codigo Referencia:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query))
                     {
                 ?>
                        <option value="<?php echo $datos['codigo_referencia']?>"> <?php echo $datos['codigo_referencia']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="cantidad" class="easyui-numberbox" required="true" label="Cantidad:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="number" name="precio_unitario" class="easyui-numberbox" data_options="min:0,presicion:2" required="true" label="Precio Unitario:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="number" name="precio_total" class="easyui-numberbox" data_options="min:0,presicion:2" required="true" label="Precio Total:" labelPosition="top" style="width:100%">
            </div>
           <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_solicitante" label="Solicitante:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query1))
                     {
                 ?>
                        <option value="<?php echo $datos['primer_nombre']?>"> <?php echo $datos['primer_nombre']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="concepto" class="easyui-textbox" required="true" label="Concepto" labelPosition="top" style="width:100%">
            </div>
           <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_cliente_salida" label="Cliente:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query2))
                     {
                 ?>
                        <option value="<?php echo $datos['nombre_cliente']?>"> <?php echo $datos['nombre_cliente']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input type="datetime-local" name="fecha_ingreso" class="easyui-textbox" required="true" label="Fecha Ingreso:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="datetime-local" name="fecha_salida" class="easyui-textbox" required="true" label="Fecha Salida:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="estatus" class="easyui-textbox" required="true" label="estatus" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="cod_cotizacion" label="Cod Cotizacion:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query3))
                     {
                 ?>
                        <option value="<?php echo $datos['cod_cotizacion']?>"> <?php echo $datos['cod_cotizacion']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="cod_factura" class="easyui-textbox" required="true" label="cod_factura" labelPosition="top" style="width:100%">
            </div>
            
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
            $('#fm').form('clear');
            url = '../vistas_modelos/ordenesCompra/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/ordenesCompra/update_user.php?index_id='+row.index_id;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        $(function(){
            var dg = $('#dg').datagrid({
                filterBtnIconCls:'icon-filter'
            });
            dg.datagrid('enableFilter',[{

            }]);
        })
    </script>
</body>
</html>
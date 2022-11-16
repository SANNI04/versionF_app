<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }	

    include '../conexion/conn.php';
    $conf= new Configuracion();
    $conf->conectar();
    $query=mysqli_query($conf->conectar(), "SELECT codigo_referencia FROM referencias");
    $query1=mysqli_query($conf->conectar(), "SELECT codigo_orden from ordenes_compra");
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
<body>

    <table id="dg" title="Existencias" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/existencias/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true" data-options="remoteSort:false,multiSort:true,singleSelect:true">

        <thead>
            <tr>
				<th field="index_id" width="50" data-options="sortable:true">Id</th>
                <th field="codigo_referencia" width="50" data-options="sortable:true">Codigo Referencia</th>
                <th field="cantidad" width="50" data-options="sortable:true">Cantidad</th>
                <th field="fecha_ingreso" width="50" data-options="sortable:true">Fecha Ingreso</th>
                <th field="codigo_orden_compra" width="50" data-options="sortable:true">Codigo Orden Compra</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Existencias</h3><br>
            <br>
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
                <input type="datetime-local" name="fecha_ingreso"  class="easyui-textbox" required="true" label="Fecha Ingreso:" labelPosition="top" style="width:100%">
            </div>
             <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_orden_compra" label="Codigo Orden Compra:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                <?php
                     while($datos = mysqli_fetch_array($query1))
                     {
                 ?>
                        <option value="<?php echo $datos['codigo_orden']?>"> <?php echo $datos['codigo_orden']?> </option>
                 <?php
                     }
                 ?>
            </select>
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
            url = '../vistas_modelos/existencias/save_user.php';
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
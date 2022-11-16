<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

    include '../conexion/conn.php';
    $conf = new Configuracion();
    $conf->conectar();

    $query=mysqli_query($conf->conectar(), "SELECT CONCAT(codigo_equipo,' ',nombre_modelo) as equipo from equipos");
    $query1=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes ") //me traje el nombre porq la identificacion no me dice nada

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
  
    <table id="dg" title="Renta Equipos" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/rentaEquipos/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true"  data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
		<th field="index_id" width="50" data-options="sortable:true">Id</th>
                <th field="cod_equipo" width="50" data-options="sortable:true">Codigo Equipo</th>
                <th field="identificacion_cliente" width="50" data-options="sortable:true">Identificacion Cliente</th>
                <th field="identificacion_comercial" width="50" data-options="sortable:true">Identificacion Comercial</th>
                <th field="fecha_alquiler" width="50" data-options="sortable:true">Fecha Alquiler</th>
                <th field="fecha_devolucion" width="50" data-options="sortable:true">Fecha Devolucion</th>
                <th field="fecha_mantenimiento" width="50" data-options="sortable:true">Fecha Mantenimiento</th>
                
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Renta Equipos</h3><br>
            <br>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="cod_equipo" label="Codigo Equipo:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query))
                     {
                 ?>
                        <option value="<?php echo $datos['equipo']?>"> <?php echo $datos['equipo']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="identificacion_cliente" label="Cliente:"  labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query1))
                     {
                 ?>
                        <option value="<?php echo $datos['nombre_cliente']?>"> <?php echo $datos['nombre_cliente']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="identificacion_comercial" class="easyui-textbox" required="true" label="Identificacion Comercial:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_alquiler" class="easyui-textbox" required="true" label="Fecha Alquiler:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_devolucion" class="easyui-textbox" required="true" label="Fecha Devolucion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_mantenimiento" class="easyui-textbox" required="true" label="Fecha Mantenimiento:" labelPosition="top" style="width:100%">
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
            url = '../vistas_modelos/rentaEquipos/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/rentaEquipos/update_user.php?index_id='+row.index_id;
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
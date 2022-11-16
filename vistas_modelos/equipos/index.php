<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

	
    include '../conexion/conn.php';

    $conf= new Configuracion();
    $conf->conectar();
    $query=mysqli_query($conf->conectar(), "SELECT marca from tipos_marca");
?>


<!DOCTYPE html>
<html>
<head>
<title>Application</title>
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/black/easyui.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/color.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../js/datagrid-filter.js"></script>
</head>
<body>

    <table id="dg" title="Equipos" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/equipos/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true" data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
				<th field="index_id" width="50">Id</th>
                <th field="codigo_equipo" width="50" data-options="sortable:true">Codigo Equipo</th>
                <th field="nombre_modelo" width="50" data-options="sortable:true">Nombre Modelo</th>
                <th field="codigo_marca" width="50" data-options="sortable:true">Codigo Marca</th>
                <th field="serial" width="50" data-options="sortable:true">Serial</th>
                <th field="referencia" width="50" data-options="sortable:true">Referencia</th>
                <th field="estado_fisico" width="50" data-options="sortable:true">Estado Fisico</th>
                <th field="estado_alquiler" width="50" data-options="sortable:true">Estado Alquiler</th>
                
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remover</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Equipos</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="codigo_equipo" class="easyui-textbox" required="true" label="Codigo Equipo:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nombre_modelo" class="easyui-textbox" required="true" label="Nombre Modelo:" labelPosition="top" style="width:100%">
            </div>
           <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_marca" label="Codigo Marca:" style="width:100%" labelPosition="top" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query))
                     {
                 ?>
                        <option value="<?php echo $datos['marca']?>"> <?php echo $datos['marca']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="cod_serial" class="easyui-textbox" required="true" label="Serial:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="referencia" class="easyui-textbox" required="true" label="Referencia:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="estado_fisico" class="easyui-textbox" required="true" label="Estado Fisico:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="estado_alquiler" class="easyui-textbox" required="true" label="Estado Alquiler:" labelPosition="top" style="width:100%">
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
            url = '../vistas_modelos/equipos/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/equipos/update_user.php?index_id='+row.index_id;
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
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    if (r){
                        $.post('../vistas_modelos/equipos/destroy_user.php',{index_id:row.index_id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
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
<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }
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
   
    <table id="dg" title="Usuarios" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/usuarios/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true"  data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
		<th field="index_id" width="50">Id</th>
                <th field="nombre" width="50" data-options="sortable:true">Nombre Usuario</th>
                <th field="identificacion_usuario" width="50" data-options="sortable:true">Identificacion</th>
                <th field="primer_nombre" width="50" data-options="sortable:true">Primer Nombre</th>
                <th field="segundo_nombre" width="50" data-options="sortable:true">Segundo Nombre</th>
                <th field="primer_apellido" width="50" data-options="sortable:true">Primer Apellido</th>
                <th field="segundo_apellido" width="50" data-options="sortable:true">Segundo Apellido</th>
                <th field="role_id" width="50">Role Id</th>
                
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remover</a>
    </div>
    <a href=".../logout.php"></a>
    <div id="dlg" class="easyui-dialog" style="width: 500px;; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion Registro Usuarios</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="nombre" class="easyui-textbox" required="true" label="Nombre Usuario:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="clave" class="easyui-passwordbox" propt="password" required="true" label="Clave:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="identificacion_usuario" class="easyui-textbox" required="true" label="Identificacion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="primer_nombre" class="easyui-textbox" required="true" label="Primer Nombre:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="segundo_nombre" class="easyui-textbox" required="false" label="Segundo Nombre:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="primer_apellido" class="easyui-textbox" required="true" label="Primer Apellido:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="segundo_apellido" class="easyui-textbox" required="true" label="Segundo Apellido:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="role_id" class="easyui-textbox" required="true" label="role_id:" labelPosition="top" style="width:100%">
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
            url = '../vistas_modelos/usuarios/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/usuarios/update_user.php?index_id='+row.index_id;
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
                        $.post('../vistas_modelos/usuarios/destroy_user.php',{index_id:row.index_id},function(result){
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
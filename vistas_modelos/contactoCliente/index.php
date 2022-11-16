<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

  include '../conexion/conn.php';
  $conf=new Configuracion();
  $conf->conectar();
  $query=mysqli_query($conf->conectar(),"SELECT nombre_cliente from CLIENTES");

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

    <table id="dg" title="Contactos Cliente" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/contactoCliente/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true" data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
				<th field="index_id" width="50" data-options="sortable:true">Id</th>
                <th field="identificacion" width="50" data-options="sortable:true">Identificacion Contacto</th>
                <th field="primer_nombre" width="50" data-options="sortable:true">Primer Nombre</th>
                <th field="segundo_nombre" width="50" data-options="sortable:true">Segundo Nombre</th>
                <th field="primer_apellido" width="50" data-options="sortable:true">Primer Apellido</th>
                <th field="segundo_apellido" width="50" data-options="sortable:true">Segundo Apellido</th>
                <th field="telefono" width="50" data-options="sortable:true">Telefono</th>
                <th field="email" width="50" data-options="sortable:true">Email</th>
                <th field="identificacion_cliente" width="50" data-options="sortable:true">Identificacion Cliente</th>
 
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remover</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width: 500px;; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Contacto Cliente</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="identificacion" class="easyui-textbox" required="true" label="Identificacion:" labelPosition="top" style="width:100%">
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
                <input name="segundo_apellido" class="easyui-textbox" required="true" label="Segundo Apellido:" labelPosition="top"  style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="telefono" class="easyui-maskedbox" mask="(999) 999-9999" required="true" label="Telefono:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="email" name="email" class="easyui-textbox" required="true" validType="email"  label="Email:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="identificacion_cliente" label="Identificacion Cliente:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query))
                     {
                 ?>
                        <option value="<?php echo $datos['nombre_cliente']?>"> <?php echo $datos['nombre_cliente']?> </option>
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
            url = '../vistas_modelos/contactoCliente/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/contactoCliente/update_user.php?index_id='+row.index_id;
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
                        $.post('../vistas_modelos/contactoCliente/destroy_user.php',{index_id:row.index_id},function(result){
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
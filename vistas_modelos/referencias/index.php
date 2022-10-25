<?php

  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

    include '../conexion/conn.php';
    $conf = new Configuracion();
    $conf->conectar();
    $query=mysqli_query($conf->conectar(), "SELECT marca FROM tipos_marca");

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
</head>
</head>
<body>
  
    <table id="dg" title="Referencias" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/referencias/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
		<th field="index_id" width="50">Id</th>
                <th field="nombre_referencia" width="50">Nombre Referencia</th>
                <th field="codigo_referencia" width="50">Codigo Referencia</th>
                <th field="alto" width="50">Alto</th>
                <th field="largo" width="50">Largo</th>
                <th field="ancho" width="50">Ancho</th>
                <th field="marca" width="50">Marca</th>
                <th field="descripcion" width="50">Descripcion</th>
                <th field="precio_inicial" width="50">Precio Inicial</th>
                <th field="ruta_foto" width="50">Ruta_foto</th>
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
        <h3>Informacion Registro Productos-Referencias</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="nombre_referencia" class="easyui-textbox" required="true" label="Nombre Referencia:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="codigo_referencia" class="easyui-textbox" required="true" label="Codigo Referencia:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="alto" class="easyui-textbox" label="Alto:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="largo" class="easyui-textbox" label="Largo:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="ancho" class="easyui-textbox" label="Ancho:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="marca" label="Marca:" labelPosition="top" style="width:100%" require="true">
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
                <input name="descripcion" class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="precio_inicial" class="easyui-numberbox" data_options="min:0,presicion:2"  required="true" label="Precio Inicial:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="ruta_foto" class="easyui-textbox" label="Foto:" labelPosition="top" style="width:100%">
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
            url = '../vistas_modelos/referencias/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/referencias/update_user.php?index_id='+row.index_id;
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
                        $.post('../vistas_modelos/referencias/destroy_user.php',{index_id:row.index_id},function(result){
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
    </script>
</body>
</html>
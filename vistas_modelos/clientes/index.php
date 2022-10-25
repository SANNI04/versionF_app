<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

  include '../conexion/conn.php';
    $conf = new Configuracion();
    $conf->conectar();
  $query1=mysqli_query($conf->conectar(),"SELECT primer_nombre From contacto_cliente")
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
<body>
    <table id="dg" title="Clientes" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/clientes/get_cliente.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
		        <th field="index_id" width="50">Id</th>
                <th field="nombre_cliente" width="50">Nombre Cliente</th>
                <th field="identificacion" width="50">Identificacion</th>
                <th field="tipo_identificacion" width="50">Tip Id</th>
                <th field="email" width="50">Email</th>
                <th field="telefono" width="50">Telefono</th>
                <th field="direccion" width="50">Direccion</th>
                <th field="contacto_cliente" width="50">Contacto_cliente</th>
                
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
        <h3>Informacion Registro Clientes</h3><br>
            <br>
            
            <div style="margin-bottom:10px">
                <input name="nombre_cliente" class="easyui-textbox" required="true" label="Nombre Cliente:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="identificacion" class="easyui-textbox" required="true" label="Identificacion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="tipo_identificacion" class="easyui-textbox" required="true" label="Tipo Identificacion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="email" name="email" class="easyui-textbox" validType="email" required="true" label="Email:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="telefono" class="easyui-maskedbox" mask="(999) 999-9999)" required="true" label="Telefono:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="direccion" class="easyui-textbox" required="true" label="Direccion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="contacto_cliente" label="Contacto Cliente:" labelPosition="top" style="width:100%" require="true">
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
            url = '../vistas_modelos/clientes/save_cliente.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/clientes/update_cliente.php?index_id='+row.index_id;
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
                        $.post('../vistas_modelos/clientes/destroy_cliente.php',{index_id:row.index_id},function(result){
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
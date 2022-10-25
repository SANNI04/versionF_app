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
    <!--<script type="text/javascript" src="popper.min.js"></script>-->
</head>
<body>

    <table id="dg" title="Salidas" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/salidas/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
		<th field="index_id" width="50">Id</th>
                <th field="codigo_referencia" width="50">Codigo Referencia</th>
                <th field="cantidad" width="50">Cantidad</th>
                <th field="fecha_salida" width="50">Fecha Salida</th>
                <th field="codigo_orden_salida" width="50">Codigo Orden Salida</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion Registro</h3>
            <div style="margin-bottom:10px">
            <label>Codigo Referencia </label>
           
                <select id ="codigo_referencia" name="codigo_referencia"  labelPosition="top" style="width:100%" require="true" onclick="muestraselect(this.value)">
                <?php include "../salidas/get_referencia.php" ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
            <label>Cantidad Existente </label>
            <select id ="id_cantidad"  name="cantidad_existente" labelPosition="top" style="width:100%" require="true">
            </select>
            </div>
           <div style="margin-bottom:10px">
           <input name="cantidad" class="easyui-textbox" required="true" label="Cantidad a Retirar:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input  type="datetime-local" name="fecha_salida" class="easyui-textbox" required="true" label="Fecha Salida:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="codigo_orden_salida" label="Codigo orden:" style="width:100%" labelPosition="top" require="true">
            <?php include "../salidas/get_orden_salida.php" ?>
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
            url = '../vistas_modelos/salidas/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/salidas/update_user.php?index_id='+row.index_id;
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

        function muestraselect(str){ //funcion para crear la conexion asincronica
			var conexion;

			if(str==""){
				document.getElementById("txtHint").innerHTML="";
				return;
			}
			if (window.XMLHttpRequest){
				conexion = new XMLHttpRequest();  // creamos una nueva instacion del obejeto XMLHttpRequest
			}

			// verificamos el onreadystatechange verifando que el estado sea de 4 y el estatus 200
			conexion.onreadystatechange=function(){  
				if(conexion.readyState==4 && conexion.status==200){
					//especificamos que en el elemento HTML cuyo id esa el de "div" vacie todos los datos de la respuesta 
					document.getElementById("id_cantidad").innerHTML=conexion.responseText; 
				}
			}
			//abrimos una conexion asincronica usando el metodo GET y le enviamos la variable c
			conexion.open("GET", "../vistas_modelos/salidas/get_existencia.php?c="+str, true);
			//po ultimo enviamos la conexion
			conexion.send();

		}
    </script>
</body>
</html>

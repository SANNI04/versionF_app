<?php

  session_start();

  $nombre =  $_SESSION["nombre"];

  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }	

    include '../conexion/conn.php';
    $conf= new Configuracion();
    $conf->conectar();
    //$query=mysqli_query($conf->conectar(), "SELECT codigo_referencia from referencias");

    $query=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes c join usuarios u on contacto_cliente=primer_nombre;");
    $query1=mysqli_query($conf->conectar(), "SELECT nombre_sucursal from sucursal_cliente s join usuarios u on contacto_cliente=primer_nombre;");
    $query2=mysqli_query($conf->conectar(), "SELECT primer_nombre from contacto_cliente c join clientes cl on c.primer_nombre=cl.contacto_cliente;");
    $query3=mysqli_query($conf->conectar(), "SELECT primer_nombre from usuarios where role_id =3;");
    $query4=mysqli_query($conf->conectar(), "SELECT nombre_modelo from equipos");
    $query5=mysqli_query($conf->conectar(), "SELECT marca from tipos_marca");
    
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

    <table id="dg" title="Orden Trabajo" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/ordenTrabajo/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
		        <th field="index_id" width="50">Id</th>
                <th field="codigo_orden_trabajo" width="50">Codigo Orden</th>
                <th field="tipo_orden_trabajo" width="50">Tipo Orden</th>
                <th field="cliente" width="50">Cliente</th>
                <th field="sucursal" width="50">Sucursal</th>
                <th field="persona_encargada" width="50">Persona Encargada</th>
                <th field="tecnico" width="50">Tecnico</th>
                <th field="observaciones" width="50">Observaciones</th>
                <th field="fecha_orden_trabajo" width="50">Fecha Orden</th>
                <th field="equipo" width="50">Equipo</th>
                <th field="marca" width="50">Marca</th>
                <th field="estado_equipo" width="50">Estado Equipo</th>
                <th field="hora_inicio" width="50">Hora Inicio</th>
                <th field="hora_finalizacion" width="50">Hora Finalizacion</th>

            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Orden Trabajo</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="codigo_orden_trabajo" class="easyui-textbox" required="true" label="Codigo Orden:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="tipo_orden_trabajo" class="easyui-textbox" required="true" label="Tipo Orden:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="cliente" label="Cliente:" labelPosition="top" style="width:100%" require="true">
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
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="sucursal" label="Sucursal:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query1))
                     {
                 ?>
                        <option value="<?php echo $datos['nombre_sucursal']?>"> <?php echo $datos['nombre_sucursal']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="persona_encargada" label="Persona Encargada:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query2))
                     {
                 ?>
                        <option value="<?php echo $datos['primer_nombre']?>"> <?php echo $datos['primer_nombre']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
           <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="tecnico" label="Tecnico:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query3))
                     {
                 ?>
                        <option value="<?php echo $datos['primer_nombre']?>"> <?php echo $datos['primer_nombre']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input type="text" name="observaciones" class="easyui-textbox" required="true" label="Observaciones:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_orden_trabajo" class="easyui-textbox" required="true" label="Fecha Orden Trabajo:" labelPosition="top" style="width:100%">
            </div>
           <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="equipo" label="Equipo:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query4))
                     {
                 ?>
                        <option value="<?php echo $datos['nombre_modelo']?>"> <?php echo $datos['nombre_modelo']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox" name="marca" label="Marca:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query5))
                     {
                 ?>
                        <option value="<?php echo $datos['marca']?>"> <?php echo $datos['marca']?> </option>
                 <?php
                     }
                 ?>
            </select>
            </div>
            <div style="margin-bottom:10px">
                <input type="text" name="estado_equipo" class="easyui-textbox" required="true" label="Estado Equipo" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type='time' name="hora_inicio" class="easyui-textbox" label="Hora Inicio" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type='time' name="hora_finalizacion" class="easyui-textbox" label="Hora Finalizacion" labelPosition="top" style="width:100%">
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
            url = '../vistas_modelos/ordenTrabajo/save_user.php';
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
    </script>
</body>
</html>
<?php
  session_start();

  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

  include '../conexion/conn.php';
  $conf= new Configuracion();
  $conf->conectar();
  $query=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes");
  $query1=mysqli_query($conf->conectar(), "SELECT nombre_sucursal from sucursal_cliente");
  $query2=mysqli_query($conf->conectar(), "SELECT primer_nombre from usuarios");
  $query3=mysqli_query($conf->conectar(), "SELECT nombre_referencia from referencias");
  $query4=mysqli_query($conf->conectar(), "SELECT cod_cotizacion from cotizaciones");
  $query5=mysqli_query($conf->conectar(), "SELECT codigo_orden from ordenes_compra");
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
   
    <table id="dg" title="Remisiones" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/remisiones/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="numero_remision" width="50">Numero Remision</th>
                <th field="fecha" width="50">Fecha</th>
                <th field="cliente" width="50">Cliente</th>
                <th field="sucursal" width="50">Sucursal</th>
                <th field="tecnico" width="50">Tecnico</th>
                <th field="nombre_referencia" width="50">nombre_referencia</th>
                <th field="cantidad" width="50">Cantidad</th>
                <th field="codigo_cotizacion" width="50">Codigo_cotizacion</th>
                <th field="codigo_ordenes_compra" width="50">Cod Orden Compra</th>
                <th field="codigo_factura" width="50">Cod Factura</th>
                <th field="fecha_caducado" width="50">Fecha Cad</th>
                <th field="alerta" data-options="styler:cellStyler, sortable:true" width="50">Alerta</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
    </div>
    <a href=".../logout.php"></a>
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion Registro Remisiones</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <input name="numero_remision" class="easyui-textbox" required="true" label="Numero Remision:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="fecha"  type="date" class="easyui-textbox" required="true" label="Fecha:" labelPosition="top" style="width:100%">
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
                <select class="easyui-combobox" name="tecnico" label="Tecnico:" labelPosition="top" style="width:100%" require="true">
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
                <select class="easyui-combobox" name="nombre_referencia" label="nombre_referencia:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                        <?php
                            while($datos = mysqli_fetch_array($query3))
                             {
                        ?>
                    <option value="<?php echo $datos['nombre_referencia']?>"> <?php echo $datos['nombre_referencia']?> </option>
                        <?php
                            }
                        ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="cantidad" class="easyui-numberbox" required="true" label="Cantidad:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="codigo_cotizacion" label="codigo_cotizacion:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                        <?php
                            while($datos = mysqli_fetch_array($query4))
                             {
                        ?>
                    <option value="<?php echo $datos['cod_cotizacion']?>"> <?php echo $datos['cod_cotizacion']?> </option>
                        <?php
                            }
                        ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="codigo_ordenes_compra" label="codigo_ordenes_compra:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                        <?php
                            while($datos = mysqli_fetch_array($query5))
                             {
                        ?>
                    <option value="<?php echo $datos['codigo_orden']?>"> <?php echo $datos['codigo_orden']?> </option>
                        <?php
                            }
                        ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="codigo_factura" class="easyui-textbox" required="true" label="Cod Factura:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="fecha_caducado" type='date' class="easyui-textbox" required="true" label="Fecha Caducado:" labelPosition="top" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        function cellStyler(value,row,index){
            if (value == 'Remision vigente'){
                return 'background-color:#70FF00;color:black;';
            }
            if (value == 'Remision poca vigencia'){
                return 'background-color:#FFee00;color:Black;';
            }
            if(value == 'Remision vencida'){
                return 'background-color:#FF0000;color:Black;';
            }
            if(value == 'Remision sin vigencia'){
                return 'background-color:#70FF00;color:Black;';
            }
        }
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
            $('#fm').form('clear');
            url =  '../vistas_modelos/remisiones/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url =  '../vistas_modelos/remisiones/update_user.php?index_id='+row.index_id;
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
    </script>
</body>
</html>
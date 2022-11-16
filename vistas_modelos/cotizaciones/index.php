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
    $query1=mysqli_query($conf->conectar(), "SELECT nombre_sucursal from sucursal_cliente");
    $query2=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes");
    $query3=mysqli_query($conf->conectar(), "SELECT nombre_modelo from equipos");
    $query4=mysqli_query($conf->conectar(), "SELECT cod_serial from equipos");
    $query5=mysqli_query($conf->conectar(), "SELECT codigo_orden from ordenes_compra");
    $query6=mysqli_query($conf->conectar(), "SELECT index_id,nombre_cliente from clientes");
    //$consulta=mysqli_query($conf->conectar(), "SELECT index_id as codigo from cotizaciones");
    //$fila = mysqli_fetch_all($consulta, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Cotizaciones</title>
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/black/easyui.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../vistas_modelos/themes/color.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../js/datagrid-filter.js"></script>
</head>
</head>
<body>

    <table id="dg" title="cotizaciones" class="easyui-datagrid" style="width: 1150px;;height:500px"
            url="../vistas_modelos/cotizaciones/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true" data-options="remoteSort:false,multiSort:true,singleSelect:true">
        <thead>
            <tr>
		
                <th field="cod_cotizacion" width="50" data-options="sortable:true">Codigo Cotización</th>
                <th field="fecha_cotizacion" width="50" data-options="sortable:true">Fecha Cotización</th>
                <th field="nombre_creador" width="50" data-options="sortable:true">Nombre Creador</th>
                <th field="cliente" width="50" data-options="sortable:true">Cliente</th>
                <th field="sucursal" width="50" data-options="sortable:true">Sucursal</th>
                <th field="marca" width="50" data-options="sortable:true">Marca</th>
                <th field="modelo" width="50" data-options="sortable:true">Modelo</th>
                <th field="serie" width="50" data-options="sortable:true">Serie</th>
                <th field="repuestos" width="50" data-options="sortable:true">Repuestos</th>
                
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
      <!--  <a href="javascript:void(0)" class="easyui-linkbutton botonimprimir" iconCls="icon-print" plain="true" role="button" data-codigo="<?/*php echo $fila['codigo'] */?>">PDF</a>-->
     <!--  <a href="javascript:void(0)" class="easyui-linkbutton botonimprimir" iconCls="icon-print" plain="true" onclick="Pdf(data-codigo='<?/*php echo $fila['codigo'] */?>'); ">PDF</a>-->
     
       <!-- <button class='btn btn-info' onclick='Pdf("  + data.codigo  + ");'><span class='fa fa-file-pdf'></span> PDF</button>-->
       <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="Pdf()">PDF</a>
       <a href="../vistas/detallescotizacion.php" target="_blank" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="newUser()">Detalle cotizacion</a>

    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons',maximizable:'false'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Informacion Registro Cotizaciones</h3><br>
            <br>
            
            <div style="margin-bottom:10px">
                <input name="cod_cotizacion" class="easyui-textbox" required="true" label="Cod Cotizacion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="fecha_cotizacion" type="date" class="easyui-textbox" required="true" label="Fecha Cotizacion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="hoja_trabajo" class="easyui-textbox" data_options="min:0,presicion:2" required="true" label="Hoja Trabajo:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nombre_creador" class="easyui-textbox" data_options="min:0,presicion:2" required="true" label="Nombre Creador:" labelPosition="top" style="width:100%">
            </div>
           <div style="margin-bottom:10px">
           <select class="easyui-combobox" name="cliente" label="Cliente:" labelPosition="top" style="width:100%" require="true">
                 <option value="Seleccione...">Seleccione...</option>
                 <?php
                     while($datos = mysqli_fetch_array($query2))
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
                <select class="easyui-combobox" name="modelo" label="Modelo:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                     <?php
                         while($datos = mysqli_fetch_array($query3))
                         {
                    ?>
                        <option value="<?php echo $datos['nombre_modelo']?>"> <?php echo $datos['nombre_modelo']?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="serie" label="Serie:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                     <?php
                         while($datos = mysqli_fetch_array($query4))
                         {
                    ?>
                        <option value="<?php echo $datos['cod_serial']?>"> <?php echo $datos['cod_serial']?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <input  name="repuestos" class="easyui-textbox" required="true" label="repuestos:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="valor" class="easyui-numberbox" required="true" label="Valor:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="ejecucion" class="easyui-textbox" required="true" label="Ejecución:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="cod_orden_compra" label="Cod Orden Compra:" labelPosition="top" style="width:100%" require="true">
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
                <input name="cod_factura" class="easyui-textbox" required="true" label="Cod Factura:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="codigocliente" label="Codigo Cliente" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                     <?php
                         while($datos = mysqli_fetch_array($query6))
                         {
                    ?>
                        <option value="<?php echo $datos['index_id']?>"> <?php echo $datos['nombre_cliente']?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <input name="vigencia" type="date" class="easyui-textbox" required="true" label="Vigencia:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="ciudad" class="easyui-textbox" required="true" label="Ciudad:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="origen" label="Origen" labelPosition="top" style="width:100%" require="true">
                    <option>OT</option>
                    <option>Creada</option>
                </select>
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
            url = '../vistas_modelos/cotizaciones/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/cotizaciones/update_user.php?index_id='+row.index_id;
            }
        }

        function Pdf(){

            var row = $('#dg').datagrid('getSelected');
            if (row){
                url = '../vistas_modelos/cotizaciones/pdfcotizacion.php?';
                window.open(url + '&cod_cotizacion='+ '"'+row.cod_cotizacion+'"', '_blank');
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
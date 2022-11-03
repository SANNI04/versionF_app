<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location:../../login/index.php");
    exit(0);
  }

  include '../conexion/conn.php';
  $conf= new Configuracion();
  $conf->conectar();
  $query=mysqli_query($conf->conectar(), "SELECT nombre_modelo from equipos");
  $query1=mysqli_query($conf->conectar(), "SELECT nombre_cliente from clientes");
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
    <table id="dg" title="Alquileres" class="easyui-datagrid" style="width:1150px;height:500px"
            url="../vistas_modelos/alquileres/get_alquileres.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true" data-options="remoteSort:false,multiSort:true">
        <thead>
            <tr>
		        <th field="index_id" width="50" data-options="sortable:true">Id</th>
                <th field="equipo" width="50" data-options="sortable:true">Equipo</th>
                <th field="cliente" width="50" data-options="sortable:true">Cliente</th>
                <th field="fecha_alquiler" width="50" data-options="sortable:true">Fecha Alquiler:</th>
                <th field="fecha_devolucion" width="50" data-options="sortable:true">Fecha Devolucion</th>
                <th field="fecha_alerta" width="50" data-options="sortable:true">Fecha Alerta</th>
                <th field="alerta" data-options="styler:cellStyler, sortable:true" width="50">Alerta</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:500px; height:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion Registro Alquileres</h3><br>
            <br>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="equipo" label="Equipo:" labelPosition="top" style="width:100%" require="true">
                    <option value="Seleccione...">Seleccione...</option>
                        <?php
                            while($datos = mysqli_fetch_array($query))
                             {
                        ?>
                    <option value="<?php echo $datos['nombre_modelo']?>"> <?php echo $datos['nombre_modelo']?> </option>
                        <?php
                            }
                        ?>
                </select>
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="cliente" label="Cliente" labelPosition="top" style="width:100%" required="true">
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
                <input name="fecha_alquiler" type="date" class="easyui-textbox" required="true" label="Fecha Alquiler:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_devolucion" class="easyui-textbox" required="true" label="Fecha Devolucion:" labelPosition="top" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="date" name="fecha_alerta" class="easyui-textbox" required="true" label="Fecha Alerta:" labelPosition="top" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        function cellStyler(value,row,index){
            if (value == 'Alquilado vigente'){
                return 'background-color:#70FF00;color:black;';
            }
            if (value == 'Alquilado poca vigencia'){
                return 'background-color:#FFee00;color:Black;';
            }
            if(value == 'Vencido'){
                return 'background-color:#FF0000;color:Black;';
            }
            if(value == 'Alquilado sin Vigencia'){
                return 'background-color:#70FF00;color:Black;';
            }
        }
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
            $('#fm').form('clear');
            url = '../vistas_modelos/alquileres/save_alquileres.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../vistas_modelos/alquileres/update_alquileres.php?index_id='+row.index_id;
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
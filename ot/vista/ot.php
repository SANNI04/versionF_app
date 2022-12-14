<?php
  session_start();
  if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
      header("location: index.php");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD PHP</title>

    <!--ESTILOS CSS BOOTSTRAP-->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!--ESTILOS CSS ICONOS FONTAWESOME-->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!--ESTILOS Sweet Alert-->
    <link rel="stylesheet" href="../assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <!--ESTILOS DATATABLES-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
     <!--ESTILOS GENERALES-->
    <link rel="stylesheet" href="../estilos/estilos.css">
 
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header bg-warning">
                <h2 class="text-dark"style="height:55px;text-align:center">Ordenes de Trabajo</h2>
            </div>
            <div class="card-body">
                <input type="hidden" name="index_id" id="index_id">
                
                <div class="row">
                    <div class="btn-group-sm">
                        <button class="btn btn-danger" style="margin-left:950px;height:33px;" role="link" onclick="window.location='../../login/logout.php'">Cerrar sesión</button> 
                        <button class="btn btn-outline-info" onclick="Consultar();"><span class="fa fa-search"></span> Consultar</button>
                        <button class="btn btn-outline-info" id="guardar" onclick="Guardar();"><span class="fa fa-save"></span> Guardar</button>
                        <button class="btn btn-outline-info" id="modificar" onclick="Modificar();" disabled="true"><span class="fa fa-pencil-alt"></span> Modificar</button>
                       <br><br>
                    </div>
                </div>

                <div class="row"> <!--fila dividida en 2 columnas-->
                    <div class="col-md-6">
                        <label for="tipo_orden_trabajo">Tipo Orden Trabajo:</label>
                        <select type="text" name="tipo_orden_trabajo" id="tipo_orden_trabajo" class="form-control"  autofocus>
                           <option>Mantenimiento</option>
                            <option>Correctivo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cliente">Cliente:</label>
                        <select  type ="text" class="form-control" id ="cliente" name="cliente"></select>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <label for="sucursal">Sucursal:</label>
                        <select  type ="text" class="form-control" id ="sucursal" name="sucursal"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="persona_encargada">Persona encargada:</label>
                        <input type="text" name="persona_encargada" id="persona_encargada" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="tecnico">Tecnico:</label>
                        <select type="text" name="tecnico" id="tecnico" class="form-control"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="observaciones">Observaciones::</label>
                        <input type="text" name="observaciones" id="observaciones" class="form-control">
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <label for="fecha_orden_trabajo">Fecha orden trabajo:</label>
                        <input type="date" name="fecha_orden_trabajo" id="fecha_orden_trabajo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="equipo">Equipo:</label>
                        <select type ="text" class="form-control" id ="equipo" name="equipo"></select>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <label for="marca">Marca:</label>
                        <select type="text" name="marca" id="marca" class="form-control"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="estado_equipo">Estado equipo:</label>
                        <input type="text" name="estado_equipo" id="estado_equipo" class="form-control">
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <label for="hora_inicio">Hora inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="hora_finalizacion">Hora finalizacion:</label>
                        <input type="time" name="hora_finalizacion" id="hora_finalizacion" class="form-control">
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <input type="hidden" class="form-control" id ="codigo_orden_trabajo" name="codigo_orden_trabajo">
                        <!--atributo autofocus HTML5. La función de este atributo es poner el cursor de manera activa en un input del formulario sin necesidad de hacer click en él-->
                    </div>
                </div>
            </div>  
            <br><br>
            <div class="card-footer">
                <table class="table table-striped" id="tablaOrdenTrabajo" width="100%"> 
                    <thead class="thead-dark">
                        <tr>
                            <th>Codigo_orden_trabajo</th>
                            <th>Tipo_orden_trabajo</th>
                            <th>Cliente</th>
                            <th>Sucursal</th>
                            <th>Tecnico </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos">
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
<script src="http://localhost/ot/vista/js_multi_level_dropdown.js"></script>
</body>

<!-- JAVASCRIPT -->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/all.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="../js/ot.js"></script>
<script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>

</html>
<!--TODO FUNCIONA-->
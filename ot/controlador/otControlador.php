<?php
    require '../modelo/otModelo.php';

    if($_POST){
        $orden_trabajo = new OrdenTrabajo();
        
        switch($_POST["accion"]){
            case "CONSULTAR":
                echo json_encode($orden_trabajo->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($orden_trabajo->ConsultarPorId($_POST["index_id"]));
            break;
            case "GUARDAR":
             $codigo_orden_trabajo = $_POST["codigo_orden_trabajo"];  //se obtienen los datos directamente del post
             $tipo_orden_trabajo = $_POST["tipo_orden_trabajo"];
             $cliente = $_POST["cliente"];
             $sucursal = $_POST["sucursal"];
             $persona_encargada = $_POST["persona_encargada"];
             $tecnico = $_POST["tecnico"];
             $observaciones = $_POST["observaciones"];
             $fecha_orden_trabajo = $_POST["fecha_orden_trabajo"];
             $equipo = $_POST["equipo"];
             $marca = $_POST["marca"];
             $estado_equipo = $_POST["estado_equipo"];
             $hora_inicio = $_POST["hora_inicio"];
             $hora_finalizacion = $_POST["hora_finalizacion"];
             $voltaje = $_POST["voltaje"];
             $amperaje = $_POST["amperaje"];
             $clavija = $_POST["clavija"];
             $modelo = $_POST["modelo"];
             $serie = $_POST["serie"];
          
             //VERIFICANDO DATOS OBLIGATORIOS.

            if($tipo_orden_trabajo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($cliente == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($sucursal == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($persona_encargada == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
            
            if($observaciones == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($fecha_orden_trabajo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($equipo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($marca == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($estado_equipo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
            
            $respuesta = $orden_trabajo->Guardar($codigo_orden_trabajo,$tipo_orden_trabajo,$cliente,$sucursal,$persona_encargada,$tecnico,$observaciones,$fecha_orden_trabajo,$equipo,$marca,$estado_equipo,$hora_inicio,$hora_finalizacion,$voltaje,$amperaje,$clavija,$modelo,$serie);
            echo json_encode($respuesta);
            break;
            case "MODIFICAR":
            $codigo_orden_trabajo = $_POST["codigo_orden_trabajo"];
            $tipo_orden_trabajo = $_POST["tipo_orden_trabajo"];
            $cliente = $_POST["cliente"];
            $sucursal = $_POST["sucursal"];
            $persona_encargada = $_POST["persona_encargada"];
            $tecnico = $_POST["tecnico"];
            $observaciones = $_POST["observaciones"];
            $fecha_orden_trabajo = $_POST["fecha_orden_trabajo"];
            $equipo = $_POST["equipo"];
            $marca = $_POST["marca"];
            $estado_equipo = $_POST["estado_equipo"];
            $hora_inicio = $_POST["hora_inicio"];
            $hora_finalizacion = $_POST["hora_finalizacion"];
            $voltaje = $_POST["voltaje"];
            $amperaje = $_POST["amperaje"];
            $clavija = $_POST["clavija"];
            $modelo = $_POST["modelo"];
            $serie = $_POST["serie"];
            $index_id = $_POST["index_id"];

            if($tipo_orden_trabajo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($cliente == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($persona_encargada == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($observaciones == ""){
                echo json_encode("Dato obligatorio");
                return;
            }

            if($fecha_orden_trabajo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($equipo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($marca == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
                
            if($estado_equipo == ""){
                echo json_encode("Dato obligatorio");
                return;
            }
            
            $respuesta = $orden_trabajo->Modificar($index_id,$codigo_orden_trabajo,$tipo_orden_trabajo,$cliente,$sucursal,$persona_encargada,$tecnico,$observaciones,$fecha_orden_trabajo,$equipo,$marca,$estado_equipo,$hora_inicio,$hora_finalizacion,$voltaje,$amperaje,$clavija,$modelo,$serie);
            echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $index_id = $_POST["index_id"];
                $respuesta = $orden_trabajo->Eliminar($index_id);
                echo json_encode($respuesta);
            break;
        }
    }

?>
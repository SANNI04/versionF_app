<?php
    require 'conexion.php';

    class OrdenTrabajo{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM nombre_cliente where activo=1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($index_id){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM orden_trabajo WHERE index_id = :index_id");
            $stmt->bindValue(":index_id", $index_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function Guardar($codigo_orden_trabajo,$tipo_orden_trabajo,$cliente,$sucursal,$persona_encargada,$tecnico,$observaciones,$fecha_orden_trabajo,$equipo,$marca,$estado_equipo,$hora_inicio,$hora_finalizacion,$voltaje,$amperaje,$clavija,$modelo,$serie,$fecha_ot_cierre,$categoria,$codigo_cotizacion,$codigo_factura,$cod_orden_compra,$nota_entrada){

            $conexion = new Conexion();

            $stmt = $conexion->prepare("INSERT INTO orden_trabajo (codigo_orden_trabajo,tipo_orden_trabajo,cliente,sucursal,persona_encargada,tecnico,observaciones,fecha_orden_trabajo,equipo,marca,estado_equipo,hora_inicio,hora_finalizacion,voltaje,amperaje,clavija,modelo,serie,fecha_ot_cierre,categoria,codigo_cotizacion,codigo_factura,cod_orden_compra,nota_entrada) values ((select consecutivo as :consecutivo from consecutivoot),:tipo_orden_trabajo,:cliente,:sucursal,:persona_encargada,:tecnico,:observaciones,:fecha_orden_trabajo,:equipo,:marca,:estado_equipo,:hora_inicio,:hora_finalizacion,:voltaje,:amperaje,:clavija,:modelo,:serie,:fecha_ot_cierre,:categoria,:codigo_cotizacion,:codigo_factura,:cod_orden_compra,:nota_entrada);");
            $stmt->bindValue(":consecutivo",$codigo_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":tipo_orden_trabajo",$tipo_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":cliente",$cliente, PDO::PARAM_STR);
            $stmt->bindValue(":sucursal",$sucursal, PDO::PARAM_STR);
            $stmt->bindValue(":persona_encargada",$persona_encargada, PDO::PARAM_STR);
            $stmt->bindValue(":tecnico",$tecnico, PDO::PARAM_STR);
            $stmt->bindValue(":observaciones",$observaciones, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_orden_trabajo",$fecha_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":equipo",$equipo, PDO::PARAM_STR);
            $stmt->bindValue(":marca",$marca, PDO::PARAM_STR);
            $stmt->bindValue(":estado_equipo",$estado_equipo, PDO::PARAM_STR);
            $stmt->bindValue(":hora_inicio",$hora_inicio, PDO::PARAM_STR);
            $stmt->bindValue(":hora_finalizacion",$hora_finalizacion, PDO::PARAM_STR);
            $stmt->bindValue(":voltaje",$voltaje, PDO::PARAM_STR);
            $stmt->bindValue(":amperaje",$amperaje, PDO::PARAM_STR);
            $stmt->bindValue(":clavija",$clavija, PDO::PARAM_STR);
            $stmt->bindValue(":modelo",$modelo, PDO::PARAM_STR);
            $stmt->bindValue(":serie",$serie, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_ot_cierre",$fecha_ot_cierre, PDO::PARAM_STR);
            $stmt->bindValue(":categoria",$categoria, PDO::PARAM_STR);
            $stmt->bindValue(":codigo_cotizacion",$codigo_cotizacion, PDO::PARAM_STR);
            $stmt->bindValue(":codigo_factura",$codigo_factura, PDO::PARAM_STR);
            $stmt->bindValue(":cod_orden_compra",$cod_orden_compra, PDO::PARAM_STR);
            $stmt->bindValue(":nota_entrada",$nota_entrada, PDO::PARAM_STR);

            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }

        }

        public function Modificar($index_id,$codigo_orden_trabajo,$tipo_orden_trabajo,$cliente,$sucursal,$persona_encargada,$tecnico,$observaciones,$fecha_orden_trabajo,$equipo,$marca,$estado_equipo,$hora_inicio,$hora_finalizacion,$voltaje,$amperaje,$clavija,$modelo,$serie,$fecha_ot_cierre,$categoria,$codigo_cotizacion,$codigo_factura,$cod_orden_compra,$nota_entrada){

            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE orden_trabajo SET codigo_orden_trabajo = :codigo_orden_trabajo,tipo_orden_trabajo = :tipo_orden_trabajo,cliente = :cliente,sucursal = :sucursal,persona_encargada = :persona_encargada,tecnico  = :tecnico,observaciones = :observaciones,fecha_orden_trabajo = :fecha_orden_trabajo,equipo = :equipo,marca = :marca,estado_equipo = :estado_equipo,hora_inicio = :hora_inicio,hora_finalizacion =:hora_finalizacion,voltaje =:voltaje,amperaje =:amperaje,clavija =:clavija,modelo =:modelo,serie =:serie,fecha_ot_cierre =:fecha_ot_cierre,categoria =:categoria,codigo_cotizacion =:codigo_cotizacion,codigo_factura =:codigo_factura,cod_orden_compra =:cod_orden_compra,nota_entrada =:nota_entrada where index_id = :index_id;");
            
            $stmt->bindValue(":codigo_orden_trabajo",$codigo_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":tipo_orden_trabajo",$tipo_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":cliente",$cliente, PDO::PARAM_STR);
            $stmt->bindValue(":sucursal",$sucursal, PDO::PARAM_STR);
            $stmt->bindValue(":persona_encargada",$persona_encargada, PDO::PARAM_STR);
            $stmt->bindValue(":tecnico",$tecnico, PDO::PARAM_STR);
            $stmt->bindValue(":observaciones",$observaciones, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_orden_trabajo",$fecha_orden_trabajo, PDO::PARAM_STR);
            $stmt->bindValue(":equipo",$equipo, PDO::PARAM_STR);
            $stmt->bindValue(":marca",$marca, PDO::PARAM_STR);
            $stmt->bindValue(":estado_equipo",$estado_equipo, PDO::PARAM_STR);
            $stmt->bindValue(":hora_inicio",$hora_inicio, PDO::PARAM_STR);
            $stmt->bindValue(":hora_finalizacion",$hora_finalizacion, PDO::PARAM_STR);
            $stmt->bindValue(":voltaje",$voltaje, PDO::PARAM_STR);
            $stmt->bindValue(":amperaje",$amperaje, PDO::PARAM_STR);
            $stmt->bindValue(":clavija",$clavija, PDO::PARAM_STR);
            $stmt->bindValue(":modelo",$modelo, PDO::PARAM_STR);
            $stmt->bindValue(":serie",$serie, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_ot_cierre",$fecha_ot_cierre, PDO::PARAM_STR);
            $stmt->bindValue(":categoria",$categoria, PDO::PARAM_STR);
            $stmt->bindValue(":codigo_cotizacion",$codigo_cotizacion, PDO::PARAM_STR);
            $stmt->bindValue(":codigo_factura",$codigo_factura, PDO::PARAM_STR);
            $stmt->bindValue(":cod_orden_compra",$cod_orden_compra, PDO::PARAM_STR);
            $stmt->bindValue(":nota_entrada",$nota_entrada, PDO::PARAM_STR);
            $stmt->bindValue(":index_id",$index_id, PDO::PARAM_INT);

            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }

        }

        public function Eliminar($index_id){

            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE orden_trabajo SET activo=0 WHERE index_id=:index_id");
            $stmt->bindValue(":index_id", $index_id, PDO::PARAM_INT);

            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar la información";
            }
        }
    }
?>
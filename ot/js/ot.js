var url = "./../controlador/otControlador.php";

$(document).ready(function() {
    Consultar();
})

function Consultar() {
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        var html = ""; //creamos un html 
        $.each(response, function(index, data) { 
         html += "<tr>" //define una fila en una tabla y concatenamos de la tada los valores que necesitamos
            html += "<td>" + data.codigo_orden_trabajo + "</td>";  //los datos que contiene
            html += "<td>" + data.tipo_orden_trabajo + "</td>";
            html += "<td>" + data.nombre_cliente + "</td>";
            html += "<td>" + data.sucursal + "</td>";
            html += "<td>" + data.tecnico + "</td>";
            html += "<td>";
            html += "<button class='btn btn-warning' onclick='ConsultarPorId(" + data.index_id + ");'><span class='fa fa-edit'></span>Modificar</button>"
            html += "<button class='btn btn-danger' onclick='Eliminar(" + data.index_id + ");'><span class='fa fa-trash'></span>Eliminar</button>"
            html += "<button class='btn btn-info' onclick='Pdf("  + data.index_id  + ");'><span class='fa fa-file-pdf'></span> PDF</button>"
            html += "</td>";
            html += "</tr>";
    });
        document.getElementById("datos").innerHTML = html; //trae la data y le concatena el html que se acabo de armar. 
        
        $('#tablaOrdenTrabajo').DataTable();
        
    }).fail(function(response) {
        console.log(response);
    });

}

function ConsultarPorId(index_id) {
    $.ajax({
        url: url,
        data: {"index_id": index_id, "accion": "CONSULTAR_ID" },
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        document.getElementById('codigo_orden_trabajo').value=response.codigo_orden_trabajo;
        document.getElementById('tipo_orden_trabajo').value=response.tipo_orden_trabajo;
        document.getElementById('cliente').value=response.cliente;
        document.getElementById('sucursal').value=response.sucursal;
        document.getElementById('persona_encargada').value=response.persona_encargada;
        document.getElementById('tecnico').value=response.tecnico;
        document.getElementById('observaciones').value=response.observaciones;
        document.getElementById('fecha_orden_trabajo').value=response.fecha_orden_trabajo;
        document.getElementById('equipo').value=response.equipo;
        document.getElementById('marca').value=response.marca;
        document.getElementById('estado_equipo').value=response.estado_equipo;
        document.getElementById('hora_inicio').value=response.hora_inicio;
        document.getElementById('hora_finalizacion').value=response.hora_finalizacion;
        document.getElementById('voltaje').value=response.voltaje;
        document.getElementById('amperaje').value=response.amperaje;
        document.getElementById('clavija').value=response.clavija;
        document.getElementById('modelo').value=response.modelo;
        document.getElementById('serie').value=response.serie;
        document.getElementById('index_id').value=response.index_id; 
        BloquearBotones(false);
    }).fail(function(response) {
        console.log(response);
    });
}



function Guardar() {
    $.ajax({
        url: url,
        data: retornarDatos("GUARDAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Limpiar();
        Consultar();//refresca la tabla
    }).fail(function(response) {
        console.log(response);
    });
    console.log(response);

    Limpiar(); 
}

function Modificar() {

    $.ajax({
        url: url,
        data: retornarDatos("MODIFICAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos modificados con éxito", "success");
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Limpiar();
        Consultar();
    }).fail(function(response) {
        console.log(response);
    });
}

function Eliminar(index_id) {
    $.ajax({
        url: url,
        data: { "index_id": index_id, "accion": "ELIMINAR" },
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos eliminados con éxito", "success");
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Consultar();
    }).fail(function(response) {
        console.log(response);
    });
}

function Validar() {
    codigo_orden_trabajo = document.getElementById('codigo_orden_trabajo').value;
    tipo_orden_trabajo = document.getElementById('tipo_orden_trabajo').value;   
    cliente = document.getElementById('cliente').value;
    sucursal = document.getElementById('sucursal').value;
    persona_encargada = document.getElementById('persona_encargada').value;
    tecnico = document.getElementById('tecnico').value;
    observaciones = document.getElementById('observaciones').value;
    fecha_orden_trabajo = document.getElementById('fecha_orden_trabajo').value;
    equipo = document.getElementById('equipo').value;
    marca = document.getElementById('marca').value;
    estado_equipo = document.getElementById('estado_equipo').value;
    hora_inicio = document.getElementById('hora_inicio').value;
    hora_finalizacion = document.getElementById('hora_finalizacion').value;
    voltaje = document.getElementById('voltaje').value;
    amperaje = document.getElementById('amperaje').value;
    clavija = document.getElementById('clavija').value;
    modelo = document.getElementById('modelo').value;
    serie = document.getElementById('serie').value;
   
if(codigo_orden_trabajo == "" || tipo_orden_trabajo =="" || cliente== "" || sucursal== "" || persona_encargada=="" || tecnico=="" || observaciones=="" || fecha_orden_trabajo=="" || equipo=="" || marca =="" || estado_equipo=="" || hora_inicio=="" || hora_finalizacion=="" || voltaje=="" || amperaje=="" || clavija=="" || modelo=="" || serie=="") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "codigo_orden_trabajo": document.getElementById('codigo_orden_trabajo').value,
        "tipo_orden_trabajo": document.getElementById('tipo_orden_trabajo').value,  
        "cliente": document.getElementById('cliente').value,
        "sucursal": document.getElementById('sucursal').value,
        "persona_encargada": document.getElementById('persona_encargada').value,
        "tecnico": document.getElementById('tecnico').value,
        "observaciones": document.getElementById('observaciones').value,
        "fecha_orden_trabajo": document.getElementById('fecha_orden_trabajo').value,
        "equipo": document.getElementById('equipo').value,
        "marca": document.getElementById('marca').value,
        "estado_equipo": document.getElementById('estado_equipo').value,
        "hora_inicio": document.getElementById('hora_inicio').value,
        "hora_finalizacion": document.getElementById('hora_finalizacion').value,
        "voltaje": document.getElementById('voltaje').value,
        "amperaje": document.getElementById('amperaje').value,
        "clavija": document.getElementById('clavija').value,
        "modelo": document.getElementById('modelo').value,
        "serie": document.getElementById('serie').value,
        "accion": accion,
        "index_id":  document.getElementById('index_id').value
    };
}

function Limpiar() {
        document.getElementById('codigo_orden_trabajo').value = "";
        document.getElementById('tipo_orden_trabajo').value = "";
        document.getElementById('cliente').value = "";
        document.getElementById('sucursal').value = "";
        document.getElementById('persona_encargada').value = "";
        document.getElementById('tecnico').value = "";
        document.getElementById('observaciones').value = "";
        document.getElementById('fecha_orden_trabajo').value = "";
        document.getElementById('equipo').value = "";
        document.getElementById('marca').value = "";
        document.getElementById('estado_equipo').value = "";
        document.getElementById('hora_inicio').value = "";
        document.getElementById('hora_finalizacion').value = "";
        document.getElementById('voltaje').value = "";
        document.getElementById('amperaje').value = "";
        document.getElementById('clavija').value = "";
        document.getElementById('modelo').value = "";
        document.getElementById('serie').value = "";
    BloquearBotones(true);
}

function BloquearBotones(guardar) {
    if (guardar) {
        document.getElementById('guardar').disabled = false;
        document.getElementById('modificar').disabled = true;
    } else {
        document.getElementById('guardar').disabled = true;
        document.getElementById('modificar').disabled = false;
    }
}
 //dispara cada alerta dependiendo de la accion
function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}


/*$('.Pdf').click(function(){
    window.location('../../../prefacturas/pdforden.php?' + '&index_id=' + $(this).get(0).data.index_id, '_blank')
});*/

/*
function Pdf() {
    var url = "localhost/prefacturas/pdforden.php?";
    window.open(url + '&index_id=' + $(this).get(0).dataset.index_id, '_blank');

}*/

/*
function Pdf(){
    var url = "localhost/prefacturas/pdforden.php?";
    $.ajax({
        type: 'POST',
        url: url + '&index_id='+ index_id,
        data: json,
        success: function(msg){
            window.open(url + '&index_id='+ index_id, '_blank');
            window.location = '../vista/ot.php';
        },
        error: function(){
            alert ("Hay un error");
        }
    });
}*/
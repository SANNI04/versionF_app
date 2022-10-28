console.log("Javascript Multi Level Dropdown");
 
var cliente_dropdown=document.getElementById("cliente");
var sucursal_dropdown=document.getElementById("sucursal");
var equipo_dropdown=document.getElementById("equipo");
var marca_dropdown=document.getElementById("marca");
var tecnico_dropdown=document.getElementById("tecnico");
var consecutivo_dropdown=document.getElementById("codigo_orden_trabajo");


async function getCliente(){
    
    //El operador await es usado para esperar a una Promise. Sólo puede ser usado dentro de una función async function.
    var response = await fetch("http://localhost/ot/vista/getCliente.php");
    var json_data = await response.json();
    console.log(json_data);
    cliente_dropdown.innerHTML="";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        option.text=item.nombre_cliente;
        option.value=item.index_id;

        cliente_dropdown.appendChild(option);
    });
}
getCliente();


async function getSucursal(){
    
    //El operador await es usado para esperar a una Promise. Sólo puede ser usado dentro de una función async function.
    var response = await fetch("http://localhost/ot/vista/getSucursal.php");
    var json_data = await response.json();
    console.log(json_data);
    sucursal_dropdown.innerHTML= "";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        
        option.text=item.nombre_sucursal;
        //option.value=item.index_id;

        sucursal_dropdown.appendChild(option);  
    });
}
getSucursal();

async function getEquipos(){
   
    var response = await fetch("http://localhost/ot/vista/getEquipo.php");
    var json_data = await response.json();
    console.log(json_data);
    equipo_dropdown.innerHTML= "";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        option.text=item.nombre_modelo;
        //option.value=item.index_id;

        equipo_dropdown.appendChild(option);  
    });
}

getEquipos();


async function getMarca(){
   
    var response = await fetch("http://localhost/ot/vista/getMarca.php");
    var json_data = await response.json();
    console.log(json_data);
    marca_dropdown.innerHTML= "";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        option.text=item.marca;
        //option.value=item.index_id;

        marca_dropdown.appendChild(option);  
    });
}

getMarca();


async function getTecnico(){

    console.log("Hola Mundo")    ;
    var response = await fetch("http://localhost/ot/vista/getTecnico.php");
    var json_data = await response.json();
    console.log(json_data);

    tecnico_dropdown.innerHTML= "";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        option.text=item.primer_nombre;
        //option.value=item.index_id;

        tecnico_dropdown.appendChild(option);  
    }); 
}

getTecnico();


async function getConsecutivo(){

    console.log("Hola Mundo")    ;
    var response = await fetch("http://localhost/ot/vista/getConsecutivo.php");
    var json_data = await response.json();
    console.log(json_data);

    consecutivo_dropdown.innerHTML= "";

    json_data.forEach((item,index) => {
        var option=document.createElement("option");
        option.text=item.consecutivo;
        //option.value=item.index_id;

        consecutivo_dropdown.appendChild(option);
    });
}

getConsecutivo();



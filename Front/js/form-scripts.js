

function buscaPatente() {
    // Initiate Variables With Form Content
    var patente = $("#patente").val();
    $.ajax({
        type: "GET",
        url: "http://localhost/multas-rest-api/api/single_read.php?patente=" + patente,
        contentType: "application/json",
        dataType: "json",
        success: function (data) {

            $.each(data, function (i, item) {
                if (i=="valor_permiso")
                    $("#valor_permiso").val(item);

               if (i=="vehiculo")
                    $("#vehiculo").val(item);

                    if (i=="interes_reajuste")
                    $("#interes_reajuste").val(item);

                    if (i=="multas")
                    $("#multas").val(item);

                    if (i=="subtotal")
                    $("#monto").val(item);
                
            });
            buscaPagos();
        },
        failure: function (data) 
        { alert("failure"); }, error: function (data) { alert("Patente no encontrada"); limpiarFormulario();}
    });
}

/*valida si es actualizacion o insercion de datos*/
function Valida(){

    if(document.getElementById('pago').checked){
        GeneraPago();
    }

    if(document.getElementById('multa').checked){
        ActualizaPatente();
        buscaPatente()
    }
}

/*Busca los pagos realizados*/

function buscaPagos() {
    // Initiate Variables With Form Content
    var patente = $("#patente").val();
    $.ajax({
        type: "GET",
        url: "http://localhost/multas-rest-api/api/read.php?patente=" + patente,
        contentType: "application/json",
        dataType: "json",
        success: function (data) {
            $.each(data, function (i, item) {
                if (i=="fecha_pago")
                    alert("Esta patente, ya fue pagada el " + item);
                    limpiarFormulario();
            });

        },
        failure: function (data) 
        { alert("failure"); }, error: function (data){}
    });
}


function ActualizaPatente() {

    $.ajax({
       url : "http://localhost/multas-rest-api/api/update.php?",
         dataType : 'json',
          type : 'POST',
          contentType : 'application/json',
           data : JSON.stringify(
                    { "patente" : $('#patente').val(),
                    "valor_permiso" : $('#valor_permiso').val(),
                    "interes_reajuste" : $('#interes_reajuste').val(),
                    "multas" : $('#multas').val()
                     }
                ),
                complete: function(xhr, textStatus) {
			        console.log(xhr.status);
			        if(xhr.status == 200){
			        	
                        alert("Datos Actualizados correctamente");
                        buscaPatente() 
			        }else{
			        	
                        alert("Datos no actualizados");
			        }
			} });

}

function GeneraPago() {

    $.ajax({
       url : "http://localhost/multas-rest-api/api/create.php?",
         dataType : 'json',
          type : 'POST',
          contentType : 'application/json',
           data : JSON.stringify(
                    { "patente" : $('#patente').val(),
                    "valor_permiso" : $('#valor_permiso').val(),
                    "interes_reajuste" : $('#interes_reajuste').val(),
                    "multas" : $('#multas').val()
                     }
                ),
                processData : false,
                complete: function(xhr, textStatus) {
			        console.log(xhr.status);
			        if(xhr.status == 200){
			        	
                        alert("Pago realizado con exito");
                        limpiarFormulario();
			        }else{
			        	
                        alert("Pago no realizado");
			        }
			} });

}

function limpiarFormulario() {
    document.getElementById("permisoForm").reset();
  }
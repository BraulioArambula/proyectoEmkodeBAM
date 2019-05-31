$( document ).ready(function() {

    var pagina = 1;
    var pagina_actual = 1;
    var total_pagina = 0;
    var is_ajax_fire = 0;

    administraInfo();

    function administraInfo(){
        $.ajax({
            dataType: 'json',
            url: url+'res/api/obtenerInfo.php',
            data: {pagina:pagina}
        }).done(function(data){
            total_pagina = Math.ceil(data.total/10);
            pagina_actual = pagina;
            $('#pagination').twbsPagination({
                totalPages: total_pagina,
                visiblePages: pagina_actual,
                next: '>>',
                prev: '<<',
                onPageClick: function (event, pageL) {
                    pagina = pageL;
                    if(is_ajax_fire != 0){
                        obtenerInfoPagina();
                    }
                }
            });

        	administraFila(data.data);
            is_ajax_fire = 1;
        });
    }

    function obtenerInfoPagina() {
    	$.ajax({
            dataType: 'json',
            url: url+'res/api/obtenerInfo.php',
    	   data: {pagina:pagina}
        }).done(function(data){
            administraFila(data.data);
        });
    }

    function obtenerInfoPaginaEsp(busqueda) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url+'res/api/obtenerInfoEsp.php',
           data: {pagina:pagina,busqueda:busqueda}
        }).done(function(data){
            administraFila(data.data);
        });
    }

    function administraFila(data) {
        var	rows = '';
        if(jQuery.isEmptyObject(data)){
            alert("Sin resultados de busqueda");
            obtenerInfoPagina();
        }
        else{
        $.each( data, function( key, value ) {
            rows = rows + '<tr>';
            rows = rows + '<td>'+value.nombre+'</td>';
            rows = rows + '<td>'+value.apellido+'</td>';
            rows = rows + '<td>'+value.email+'</td>';
            rows = rows + '<td>'+value.telefono+'</td>';
            rows = rows + '<td data-id="'+value.id+'">';
            rows = rows + '<button data-toggle="modal" data-target="#actEmpleado" class="btn btn-primary actEmpleado" onclick="document.getElementById(\'inputActNombre\').focus();">ACTUALIZAR</button> ';
            rows = rows + '<button class="btn btn-danger eliminaEmpleado">ELIMINAR</button>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });        
        
        $("tbody").html(rows);
    }
    }

    /* AGREGA EMPLEADO */
    $(".crud-submit").click(function(e){
        e.preventDefault();
        var form_action = $("#nuevoEmpleado").find("form").attr("action");
        var nombre = $("#nuevoEmpleado").find("input[name='inputNombre']").val();
        var apellido = $("#nuevoEmpleado").find("input[name='inputApellido']").val();
        var email = $("#nuevoEmpleado").find("input[name='inputEmail']").val();
        var telefono = $("#nuevoEmpleado").find("input[name='inputTelefono']").val();

        if(nombre != '' && apellido != '' && email !='' && telefono != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url + form_action,
                data:{nombre:nombre, apellido:apellido, email:email, telefono:telefono}
            }).done(function(data){
                $("#nuevoEmpleado").find("input[name='inputNombre']").val('');
                $("#nuevoEmpleado").find("input[name='inputApellido']").val('');
                $("#nuevoEmpleado").find("input[name='inputEmail']").val('');
                $("#nuevoEmpleado").find("input[name='inputTelefono']").val('');
                obtenerInfoPagina();
                $(".modal").modal('hide');
                toastr.success('Empleado dado de alta.',
                                '¡ÉXITO!',
                                {"closeButton": true,"debug": false,"newestOnTop": false,"progressBar": false,
                                "positionClass": "toast-top-center","preventDuplicates": false,"onclick": null,
                                "showDuration": "300","hideDuration": "1000","timeOut": "5000",
                                "extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear",
                                "showMethod": "fadeIn","hideMethod": "fadeOut","progressBar": true,});
            }).fail(function(){
                alert("FALLA INTERNA DEL SERVIDOR");
            });
        }
        else
            alert('Rellena todos los campos obligatorios');
    });

    /* BUSCA EMPLEADO */
    $(".crud-submit-show").click(function(e){
        e.preventDefault();
        var form_action = $("#busquedaEmpleado").find("form").attr("action");
        var busqueda = $("#busquedaEmpleado").find("input[name='inputBusqueda']").val();
        if(busqueda != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url + form_action,
                data:{busqueda:busqueda}
            }).done(function(data){
                $("#busquedaEmpleado").find("input[name='inputBusqueda']").val('');
                obtenerInfoPaginaEsp(busqueda);
            }).fail(function(){
                alert("FALLA INTERNA DEL SERVIDOR");
            });
        }
        else
            alert('Nada que buscar');
    });

    /* ELIMINA EMPLEADO */
    $("body").on("click",".eliminaEmpleado",function(){
        var id = $(this).parent("td").data('id');
        var c_obj = $(this).parents("tr");

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + 'res/api/elimina.php',
            data:{id:id}
        }).done(function(data){
            c_obj.remove();
            toastr.success('Empleado eliminado satisfactoriamente',
                            '¡ÉXITO!',
                            {"closeButton": true,"debug": false,"newestOnTop": false,"progressBar": false,
                            "positionClass": "toast-top-center","preventDuplicates": false,"onclick": null,
                            "showDuration": "300","hideDuration": "1000","timeOut": "5000",
                            "extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear",
                            "showMethod": "fadeIn","hideMethod": "fadeOut","progressBar": true,});
            obtenerInfoPagina();
        });
    });

    /* ACTUALIZAR EMPLEADO */
    $("body").on("click",".actEmpleado",function(){

        var id = $(this).parent("td").data('id');
        var nombre = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
        var apellido = $(this).parent("td").prev("td").prev("td").prev("td").text();
        var email = $(this).parent("td").prev("td").prev("td").text();
        var telefono = $(this).parent("td").prev("td").text();

        
        $("#actEmpleado").find("input[name='inputActNombre']").val(nombre);
        $("#actEmpleado").find("input[name='inputActApellido']").val(apellido);
        $("#actEmpleado").find("input[name='inputActEmail']").val(email);
        $("#actEmpleado").find("input[name='inputActTelefono']").val(telefono);
        $("#actEmpleado").find(".idEditar").val(id);
    });

    /* ACTUALIZAR NUEVO EMPLEADO */
    $(".crud-submit-edit").click(function(e){

        e.preventDefault();
        var form_action = $("#actEmpleado").find("form").attr("action");
        var nombre = $("#actEmpleado").find("input[name='inputActNombre']").val();
        var apellido = $("#actEmpleado").find("input[name='inputActApellido']").val();
        var email = $("#actEmpleado").find("input[name='inputActEmail']").val();
        var telefono = $("#actEmpleado").find("input[name='inputActTelefono']").val();
        var id = $("#actEmpleado").find(".idEditar").val();

        if(nombre != '' && apellido != '' && email !='' && telefono != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url + form_action,
                data:{nombre:nombre, apellido:apellido, email:email, telefono:telefono,id:id}
            }).done(function(data){
                obtenerInfoPagina();
                $(".modal").modal('hide');
                toastr.success('Empleado actualizado correctamente.',
                                '¡ÉXITO!',
                                {"closeButton": true,"debug": false,"newestOnTop": false,"progressBar": false,
                                "positionClass": "toast-top-center","preventDuplicates": false,"onclick": null,
                                "showDuration": "300","hideDuration": "1000","timeOut": "5000",
                                "extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear",
                                "showMethod": "fadeIn","hideMethod": "fadeOut","progressBar": true,});
            });
        }
        else
            alert('Rellena todos los campos obligatorios');
    });
});
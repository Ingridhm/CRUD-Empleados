<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
        <title> Empleados </title>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron mt-5">
                <div class="table-responsive">
                <table id="tabla-empleados" class="table table-hover table-light">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th scope="col"> Nombre </th>
                            <th scope="col"> Apellido </th>
                            <th scope="col"> Email </th>
                            <th scope="col"> Teléfono </th>
                            <th scope="col"> Acciones </th>
                        </tr>
                        <tr class="table-light" id="filtros">
                            <form id="form-filtros">
                                <th scope="col"> <input type="text" class="form-control" id="nombre-filtro" name="nombre-filtro"> </th>
                                <th scope="col"> <input type="text" class="form-control" id="apellido-filtro" name="apellido-filtro"> </th>            
                                <th scope="col"> <input type="text" class="form-control" id="email-filtro" name="email-filtro"> </th>
                                <th scope="col"> <input type="text" class="form-control" id="telefono-filtro" name="telefono-filtro"> </th>
                                <th scope="col"> <button id="limpiar-filtros" type="button" class="btn btn-primary"> Limpiar Filtros </button> </th>
                            </form>
                        </tr>
                    </thead>
                    <tbody id="lista-empleados">                
                    </tbody>
                </table>
                </div>
                <button id="nuevo-empleado" class="btn btn-success" data-toggle="modal" data-target="#modal-empleado"> Agregar Empleado </button>
            </div>
        </div>
        <!-- MODAL EMPLEADO -->
        <div class="modal fade" id="modal-empleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="titulo-modal"> Editar Empleado </h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-empleado">
                            <div class="form-group">
                                <label for="nombre-empleado"> Nombre </label>
                                <input type="text" class="form-control" id="nombre-empleado" name="nombre-empleado">
                            </div>
                            <div class="form-group">
                                <label for="apellido-empleado"> Apellido </label>
                                <input type="text" class="form-control" id="apellido-empleado" name="apellido-empleado">
                            </div>
                            <div class="form-group">
                                <label for="email-empleado"> Email </label>
                                <input type="email" class="form-control" id="email-empleado" name="email-empleado">
                            </div>
                            <div class="form-group">
                                <label for="telefono-empleado"> Teléfono </label>
                                <input type="tel" class="form-control" id="telefono-empleado" name="telefono-empleado">
                            </div>
                        <form>
                        <div class="modal-footer">
                            <input style="display: none;" type="text" class="form-control" id="id-empleado" name="id-empleado">
                            <button style="display: none;" id="guardar-nuevo-empleado" type="button" class="btn btn-primary" onclick="Agregar()"> Agregar </button>
                            <button style="display: none;" id="guardar-editar-empleado" type="button" class="btn btn-primary"> Guardar </button>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    Cargar();

    $("#modal-empleado").on("hidden.bs.modal", function() {
        $(this).find("form").trigger("reset");
        $("#guardar-nuevo-empleado").hide();
        $("#guardar-editar-empleado").hide();
    });

    $("#nuevo-empleado").click(function() {
        $("#guardar-nuevo-empleado").show();
    });

    $("#filtros").on("input", function(){
        var datos = $("#form-filtros").serialize();
        $.ajax({
            url: 'controller.php',
            data: {action: 'filtrar-empleados', datos: datos},
            type: 'POST',
            success: function(result) {
                $("#lista-empleados").html(result);
            }
        });
    });

    $("#limpiar-filtros").click(function() {
        $("#nombre-filtro").val("");
        $("#apellido-filtro").val("");
        $("#email-filtro").val("");
        $("#telefono-filtro").val("");
        Cargar();
    });

    function Cargar() {
        $.ajax({
            url: 'controller.php',
            data: {action: 'cargar-empleados'},
            type: 'POST',
            success: function(result) {
                $("#lista-empleados").html(result);
            }
        });
    }

    function Agregar() {
        var datos = $("#form-empleado").serialize();
        $.ajax({
            url: 'controller.php',
            data: {action: 'agregar-empleado', datos: datos},
            type: 'POST',
            success: function(result) {
                $("#modal-empleado").modal("hide");
                Cargar();
            }
        });
    }

    function Eliminar(id_empleado) {
        $.ajax({
            url: 'controller.php',
            data: {action: 'eliminar-empleado', datos: id_empleado},
            type: 'POST',
            success: function(result) {
                Cargar();
            }
        });
    }

    function ModalEditar(id_empleado) {
        $("#guardar-editar-empleado").show();
        $("#id-empleado").val(id_empleado);
        $.ajax({
            url: 'controller.php',
            data: {action: 'buscar-empleado', datos: id_empleado},
            type: 'POST',
            success: function(result) {
                var empleado = JSON.parse(result);
                $("#nombre-empleado").val(empleado.name);
                $("#apellido-empleado").val(empleado.last_name);
                $("#email-empleado").val(empleado.email);
                $("#telefono-empleado").val(empleado.phone);
            }
        });
    }

    $("#guardar-editar-empleado").click( function() {
        var datos = $("#form-empleado").serialize();
        $.ajax({
            url: 'controller.php',
            data: {action: 'editar-empleado', datos: datos},
            type: 'POST',
            success: function(result) {
                $("#modal-empleado").modal("hide");             
                Cargar();
            }
        });
    });

</script>
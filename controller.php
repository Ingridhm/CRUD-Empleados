<?php
    require_once('manejadorBD.php');
    $manejador = new manejadorBD();

    if (isset($_POST['action']) && !empty($_POST['action'])) {
        if ($_POST['action'] == "cargar-empleados") {
            $manejador -> CargarEmpleados();
        }

        if ($_POST['action'] == "agregar-empleado") {
            parse_str($_POST['datos'], $datos);
            $nombre = $datos['nombre-empleado'];
            $apellido = $datos['apellido-empleado'];
            $email = $datos['email-empleado'];
            $telefono = $datos['telefono-empleado'];
            $manejador -> NuevoEmpleado($nombre, $apellido, $email, $telefono);
        }

        if ($_POST['action'] == "eliminar-empleado") {
            $id_empleado = $_POST['datos'];
            $manejador -> EliminarEmpleado($id_empleado);
        }

        if ($_POST['action'] == "editar-empleado") {
            parse_str($_POST['datos'], $datos);
            $id_empleado = $datos['id-empleado'];
            $nombre = $datos['nombre-empleado'];
            $apellido = $datos['apellido-empleado'];
            $email = $datos['email-empleado'];
            $telefono = $datos['telefono-empleado'];
            $manejador -> EditarEmpleado($id_empleado, $nombre, $apellido, $email, $telefono);
        }

        if ($_POST['action'] == "buscar-empleado") {
            $id_empleado = $_POST['datos'];
            $manejador -> BuscarEmpleado($id_empleado);
        }

        if ($_POST['action'] == "filtrar-empleados") {
            parse_str($_POST['datos'], $datos);
            $nombre = $datos['nombre-filtro'];
            $apellido = $datos['apellido-filtro'];
            $email = $datos['email-filtro'];
            $telefono = $datos['telefono-filtro'];
            $manejador -> FiltrarEmpleados($nombre, $apellido, $email, $telefono);
        }
    }
    
?>
<?php
    require_once('conexion.php');

    class manejadorBD {

        public function __construct() {

        }
    
        //--> CARGAR EMPLEADOS
        public function CargarEmpleados() {
            $db = Db::conectar();
            $select = $db -> prepare('SELECT * FROM empleado');
            $select -> execute();
            $empleados = $select -> fetchAll();
            $this -> ListaEmpleados($empleados);
        }

        //--> FILTRO EMPLEADOS
        public function FiltrarEmpleados($nombre, $apellido, $email, $telefono) {
            $db = Db::conectar();
            $select = $db -> prepare('SELECT * FROM empleado WHERE name LIKE "%'.$nombre.'%" AND last_name LIKE "%'.$apellido.'%" AND email LIKE "%'.$email.'%" AND phone LIKE "%'.$telefono.'%"');
            $select -> execute();
            $empleados = $select -> fetchAll();
            $this -> ListaEmpleados($empleados);
        }

        public function ListaEmpleados($empleados) {
            if (!empty($empleados)) {
                foreach ($empleados as $empleado) {
                    echo('<tr>
                    <td>'.$empleado["name"].'</td>
                    <td>'.$empleado["last_name"].'</td>
                    <td>'.$empleado["email"].'</td>
                    <td>'.$empleado["phone"].'</td>
                    <td>
                    <button id="editar-empleado" class="btn btn-warning" data-toggle="modal" data-target="#modal-empleado" onclick="ModalEditar('.$empleado["id_empleado"].')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </button>
                    <button id="eliminar-empleado" class="btn btn-danger" onclick="Eliminar('.$empleado["id_empleado"].')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </button>
                    </td>
                    </tr>');
                }
            }
            else {
                echo('<tr>
                    <td> Sin resultados </td>
                </tr>');
            }
        }

        //--> AGREGAR EMPLEADO
        public function NuevoEmpleado($nombre, $apellido, $email, $telefono) {
            $db = Db::conectar();
            $select = $db -> prepare('INSERT INTO empleado(name, last_name, email, phone) VALUES ("'.$nombre.'", "'.$apellido.'", "'.$email.'", "'.$telefono.'")');
            $select -> execute();
        }

        //--> ELIMINAR EMPLEDO
        public function EliminarEmpleado($id_empleado) {
            $db = DB::conectar();
            $select = $db -> prepare('DELETE FROM empleado WHERE id_empleado="'.$id_empleado.'"');
            $select -> execute();
        }

        //-->OBTENER EMPLEADO
        public function BuscarEmpleado($id_empleado) {
            $db = DB::conectar();
            $select = $db -> prepare('SELECT * FROM empleado WHERE id_empleado="'.$id_empleado.'"');
            $select -> execute();
            $empleado = $select -> fetch();
            $resultado = json_encode($empleado);
            echo ($resultado);
        }

        //--> EDITAR EMPLEADO
        public function EditarEmpleado($id_empleado, $nombre, $apellido, $email, $telefono) {
            $db = Db::conectar();
            $select = $db -> prepare('UPDATE empleado SET name="'.$nombre.'", last_name="'.$apellido.'", email="'.$email.'", phone="'.$telefono.'" WHERE id_empleado="'.$id_empleado.'"');
            $select -> execute();
        }
    }
?>
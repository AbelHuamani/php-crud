<?php
require_once 'crud.php';
require_once 'nanvar.php';

$host = "ep-dark-boat-a5upd43k.us-east-2.aws.neon.tech";
$dbname = "dbphp";
$username = "dbphp_owner";
$password = "sJjPoUiI18rT";
$endpoint = "ep-dark-boat-a5upd43k";

$crud = new CrudController($host, $dbname, $username, $password, $endpoint);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        $nombre = $_POST["nombre"];
        $apellidocompleto = $_POST["apellidocompleto"];
        $dni = $_POST["dni"];
        $crud->create($nombre, $apellidocompleto, $dni);
    } elseif (isset($_POST["update"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellidocompleto = $_POST["apellidocompleto"];
        $dni = $_POST["dni"];
        $crud->update($id, $nombre, $apellidocompleto, $dni);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $crud->delete($id);
    }
}

$usuarios = $crud->read();
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD con PHP y Bootstrap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Estilo para el pie de página fijo en la parte inferior */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #000;
            color: aliceblue;
            text-align: center;
            padding: 0px 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid row">
        <h1 class="text-center">Registro de trabajador</h1>
        <!-- Crear (Create) -->
        <h2>Crear usuario</h2>
        <form class="col-4 p-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellidocompleto" class="form-label">Apellido completo:</label>
                <input type="text" class="form-control" id="apellidocompleto" name="apellidocompleto" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <button type="submit" class="btn btn-primary" name="create">Crear</button>
        </form>

        <!-- Leer (Read) -->
        <div class="col-8 p-4">
            <h2>Usuarios</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido completo</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td><?php echo $usuario["id"]; ?></td>
                            <td><?php echo $usuario["nombre"]; ?></td>
                            <td><?php echo $usuario["apellidocompleto"]; ?></td>
                            <td><?php echo $usuario["dni"]; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $usuario["id"]; ?>" data-nombre="<?php echo $usuario["nombre"]; ?>" data-apellidocompleto="<?php echo $usuario["apellidocompleto"]; ?>" data-dni="<?php echo $usuario["dni"]; ?>">Actualizar</button>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario["id"]; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Modal de Actualización -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Actualizar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="id" id="updateId">
                            <div class="mb-3">
                                <label for="updateNombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="updateNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateApellidocompleto" class="form-label">Apellido completo:</label>
                                <input type="text" class="form-control" id="updateApellidocompleto" name="apellidocompleto" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateDni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="updateDni" name="dni" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para cargar datos en el modal -->
        <script>
            var updateModal = document.getElementById('updateModal');
            updateModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nombre = button.getAttribute('data-nombre');
                var apellidocompleto = button.getAttribute('data-apellidocompleto');
                var dni = button.getAttribute('data-dni');

                var modalTitle = updateModal.querySelector('.modal-title');
                var updateId = updateModal.querySelector('#updateId');
                var updateNombre = updateModal.querySelector('#updateNombre');
                var updateApellidocompleto = updateModal.querySelector('#updateApellidocompleto');
                var updateDni = updateModal.querySelector('#updateDni');

                modalTitle.textContent = 'Actualizar usuario: ' + nombre;
                updateId.value = id;
                updateNombre.value = nombre;
                updateApellidocompleto.value = apellidocompleto;
                updateDni.value = dni;
            });
        </script>
    </div>

    <footer class="footer text-center bg-dark text-white">
    <div class="container pt-4">
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="fab fa-facebook-f"></i>
            </a>
            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="fab fa-twitter"></i>
            </a>
            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="fab fa-instagram"></i>
            </a>
            <!-- Linkedin -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                <i class="fab fa-github"></i>
            </a>
        </section>
    </div>

    <div class="text-center p-3">
        © <?php echo date('Y'); ?> Desarrollado por @Abel huamani
    </div>
</footer>
    

</body>

</html>

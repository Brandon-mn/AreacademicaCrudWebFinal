<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

// Obtén datos para los selectores (combobox)
$groups = $employees = $subjects = $classrooms = [];

// Obtén grupos
$sqlGroups = "SELECT * FROM groupp WHERE status = 1";
$resultGroups = $connection->query($sqlGroups);
while ($row = $resultGroups->fetch_assoc()) {
    $groups[] = $row;
}

// Obtén empleados
$sqlEmployees = "SELECT * FROM employee WHERE status = 1";
$resultEmployees = $connection->query($sqlEmployees);
while ($row = $resultEmployees->fetch_assoc()) {
    $employees[] = $row;
}

// Obtén materias
$sqlSubjects = "SELECT * FROM subject WHERE status = 1";
$resultSubjects = $connection->query($sqlSubjects);
while ($row = $resultSubjects->fetch_assoc()) {
    $subjects[] = $row;
}

// Obtén aulas
$sqlClassrooms = "SELECT * FROM classroom WHERE status = 1";
$resultClassrooms = $connection->query($sqlClassrooms);
while ($row = $resultClassrooms->fetch_assoc()) {
    $classrooms[] = $row;
}

$idGroup = $idEmployee = $idSubject = $idClassroom = $status = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idGroup = $_POST["idGroup"];
    $idEmployee = $_POST["idEmployee"];
    $idSubject = $_POST["idSubject"];
    $idClassroom = $_POST["idClassroom"];
    $status = $_POST["status"];

    do {
        // Validaciones y lógica de negocio aquí (por ejemplo, campos requeridos)

        // Insertar en la tabla class
        $sql = "INSERT INTO class (idGroup, idEmployee, idSubject, idClassroom, status) VALUES ('$idGroup', '$idEmployee', '$idSubject', '$idClassroom', '$status')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Se añadió la clase";

        // Limpiar variables después de la inserción exitosa
        $idGroup = $idEmployee = $idSubject = $idClassroom = $status = "";

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Clase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Agregar Clase</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Grupo</label>
                <select class="form-select" name="idGroup" required>
                    <option value="" disabled selected>Selecciona un grupo</option>
                    <?php foreach ($groups as $group) : ?>
                        <option value="<?php echo $group['idGroup']; ?>"><?php echo $group['groupName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Profesor</label>
                <select class="form-select" name="idEmployee" required>
                    <option value="" disabled selected>Selecciona un profesor</option>
                    <?php foreach ($employees as $employee) : ?>
                        <option value="<?php echo $employee['idEmployee']; ?>"><?php echo $employee['name'] . ' ' . $employee['lastName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Materia</label>
                <select class="form-select" name="idSubject" required>
                    <option value="" disabled selected>Selecciona una materia</option>
                    <?php foreach ($subjects as $subject) : ?>
                        <option value="<?php echo $subject['idSubject']; ?>"><?php echo $subject['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Aula</label>
                <select class="form-select" name="idClassroom" required>
                    <option value="" disabled selected>Selecciona un aula</option>
                    <?php foreach ($classrooms as $classroom) : ?>
                        <option value="<?php echo $classroom['idClassroom']; ?>"><?php echo $classroom['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="status" required>
                    <option value="" disabled selected>Selecciona un estado</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-light">Agregar Clase</button>
        </form>
    </div>
</body>

</html>

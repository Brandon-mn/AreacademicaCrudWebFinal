<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idClass = $idGroup = $idEmployee = $idSubject = $idClassroom = $status = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idClass"])) {
        header("location: tableClass.php");
        exit;
    }

    $idClass = $_GET["idClass"];
    $sql = "SELECT * FROM class WHERE idClass=$idClass";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: tableClass.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo
} else {
    extract($_POST);

    do {
        // Verificar campos obligatorios
        if (empty($idClass) || empty($idGroup) || empty($idEmployee) || empty($idSubject) || empty($idClassroom)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        // Actualizar datos en la tabla class
        $sql = "UPDATE class " .
            "SET idGroup = '$idGroup', idEmployee = '$idEmployee', idSubject = '$idSubject', idClassroom = '$idClassroom' " .
            "WHERE idClass = $idClass";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Registro Actualizado";

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
    <title>Modificar Clase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Modificar Clase</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idClass" value="<?php echo $idClass; ?>">
            
            <!-- Agrega los campos específicos de la tabla class con opciones seleccionadas automáticamente -->
            <div class="mb-3">
                <label class="form-label">Grupo</label>
                <select class="form-select" name="idGroup" required>
                    <?php
                    $sqlGroups = "SELECT * FROM groupp WHERE status = 1";
                    $resultGroups = $connection->query($sqlGroups);
                    while ($group = $resultGroups->fetch_assoc()) {
                        $selected = ($idGroup == $group['idGroup']) ? 'selected' : '';
                        echo "<option value='{$group['idGroup']}' $selected>{$group['groupName']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Profesor</label>
                <select class="form-select" name="idEmployee" required>
                    <?php
                    $sqlEmployees = "SELECT * FROM employee WHERE status = 1";
                    $resultEmployees = $connection->query($sqlEmployees);
                    while ($employee = $resultEmployees->fetch_assoc()) {
                        $selected = ($idEmployee == $employee['idEmployee']) ? 'selected' : '';
                        echo "<option value='{$employee['idEmployee']}' $selected>{$employee['name']} {$employee['lastname']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Materia</label>
                <select class="form-select" name="idSubject" required>
                    <?php
                    $sqlSubjects = "SELECT * FROM subject WHERE status = 1";
                    $resultSubjects = $connection->query($sqlSubjects);
                    while ($subject = $resultSubjects->fetch_assoc()) {
                        $selected = ($idSubject == $subject['idSubject']) ? 'selected' : '';
                        echo "<option value='{$subject['idSubject']}' $selected>{$subject['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Aula</label>
                <select class="form-select" name="idClassroom" required>
                    <?php
                    $sqlClassrooms = "SELECT * FROM classroom WHERE status = 1";
                    $resultClassrooms = $connection->query($sqlClassrooms);
                    while ($classroom = $resultClassrooms->fetch_assoc()) {
                        $selected = ($idClassroom == $classroom['idClassroom']) ? 'selected' : '';
                        echo "<option value='{$classroom['idClassroom']}' $selected>{$classroom['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong><?php echo $successMessage; ?></strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-6 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Modificar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="tableClass.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

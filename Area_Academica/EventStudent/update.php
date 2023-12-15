<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idEventStudent = $idEvent = $idStudent = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idEventStudent"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idEventStudent = $_GET["idEventStudent"];
    $sql = "SELECT * FROM eventstudent WHERE idEventStudent=$idEventStudent";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo
} else {
    extract($_POST);

    do {
        if (empty($idEventStudent) || empty($idEvent) || empty($idStudent)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE eventstudent " .
            "SET idEvent = '$idEvent', idStudent = '$idStudent' " .
            "WHERE idEventStudent = $idEventStudent";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Registro Actualizado";

    } while (false);
}

// Obtener opciones para los combobox
$sqlEvents = "SELECT idEvent, name FROM event";
$resultEvents = $connection->query($sqlEvents);

$sqlStudents = "SELECT idStudent, CONCAT(name, ' ', lastName) AS fullName FROM student";
$resultStudents = $connection->query($sqlStudents);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Modificar Evento y Estudiante</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idEventStudent" value="<?php echo $idEventStudent; ?>">

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Evento</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idEvent">
                        <?php
                        while ($event = $resultEvents->fetch_assoc()) {
                            $selected = ($event['idEvent'] == $idEvent) ? 'selected' : '';
                            echo "<option value='{$event['idEvent']}' $selected>{$event['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Estudiante</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idStudent">
                        <?php
                        while ($student = $resultStudents->fetch_assoc()) {
                            $selected = ($student['idStudent'] == $idStudent) ? 'selected' : '';
                            echo "<option value='{$student['idStudent']}' $selected>{$student['fullName']}</option>";
                        }
                        ?>
                    </select>
                </div>
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
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Modificar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\EventStudent\tableEventStudent.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idDegreeRequirements = $semester = $tipo = $idSubject = $idCareer = $errorMessage = $successMessage = "";

// Obtener opciones para el combo de Materia
$sqlSubjects = "SELECT idSubject, name FROM subject WHERE status = 1";
$resultSubjects = $connection->query($sqlSubjects);

// Obtener opciones para el combo de Carrera
$sqlCareers = "SELECT idCareer, careerName FROM career WHERE status = 1";
$resultCareers = $connection->query($sqlCareers);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idDegreeRequirements"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idDegreeRequirements = $_GET["idDegreeRequirements"];
    $sql = "SELECT * FROM degreerequirements WHERE idDegreeRequirements=$idDegreeRequirements";
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
        if (empty($idDegreeRequirements) || empty($semester) || empty($tipo) || empty($idSubject) || empty($idCareer)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE degreerequirements " .
            "SET semester = '$semester', tipo = '$tipo', idSubject = '$idSubject', idCareer = '$idCareer' " .
            "WHERE idDegreeRequirements = $idDegreeRequirements";

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
    <title>Final Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Modificar Requisitos de Grado</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idDegreeRequirements" value="<?php echo $idDegreeRequirements; ?>">

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Semestre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="semester" value="<?php echo $semester; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Tipo</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="tipo" value="<?php echo $tipo; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Materia</label>
                <div class="col-sm-6">
                    <!-- Combo para seleccionar la Materia con sugerencias -->
                    <select class="form-select" name="idSubject" required>
                        <?php
                        while ($subject = $resultSubjects->fetch_assoc()) {
                            $selected = ($idSubject == $subject['idSubject']) ? "selected" : "";
                            echo "<option value='{$subject['idSubject']}' $selected>{$subject['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Carrera</label>
                <div class="col-sm-6">
                    <!-- Combo para seleccionar la Carrera con sugerencias -->
                    <select class="form-select" name="idCareer" required>
                        <?php
                        while ($career = $resultCareers->fetch_assoc()) {
                            $selected = ($idCareer == $career['idCareer']) ? "selected" : "";
                            echo "<option value='{$career['idCareer']}' $selected>{$career['careerName']}</option>";
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
                    <a class="btn btn-light btn-sm" href="DegreeRequirements/tableDegreeRequirments.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

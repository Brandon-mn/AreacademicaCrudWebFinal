<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idTeacherEvaluation = $date = $calification = $idSubject = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idTeacherEvaluation"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idTeacherEvaluation = $_GET["idTeacherEvaluation"];
    $sql = "SELECT * FROM teacherevaluation WHERE idTeacherEvaluation=$idTeacherEvaluation";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo

    // Obtener las materias para el combobox
    $sqlMaterias = "SELECT * FROM subject";
    $resultMaterias = $connection->query($sqlMaterias);
} else {
    extract($_POST);

    do {
        if (empty($idTeacherEvaluation) || empty($date) || empty($calification) || empty($idSubject)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        // No se actualiza el campo 'status' en la base de datos

        $sql = "UPDATE teacherevaluation " .
            "SET date = '$date', calification = '$calification', idSubject = '$idSubject' " .
            "WHERE idTeacherEvaluation = $idTeacherEvaluation";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Registro Actualizado";
        header("location: /web/Area_Academica/TeacherEvaluation/tableTeacherEvaluation.php");

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
        <h2>Modificar Evaluación del Profesor</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idTeacherEvaluation" value="<?php echo $idTeacherEvaluation; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Calificación</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="calification" value="<?php echo $calification; ?>">
                </div>
            </div>



            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Materia</label>
                <div class="col-sm-6">
                    <!-- Combobox para seleccionar la materia -->
                    <select class="form-control" name="idSubject">
                        <?php
                        while ($rowMateria = $resultMaterias->fetch_assoc()) {
                            $selected = ($rowMateria['idSubject'] == $idSubject) ? "selected" : "";
                            echo "<option value='{$rowMateria['idSubject']}' $selected>{$rowMateria['name']}</option>";
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\TeacherEvaluation\tableTeacherEvaluation.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

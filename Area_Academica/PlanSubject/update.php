<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idPlanSubject = $idPlan = $idSubject = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idPlanSubject"])) {
        header("location: Tables\plansubject.php");
        exit;
    }

    $idPlanSubject = $_GET["idPlanSubject"];
    $sql = "SELECT * FROM plansubject WHERE idPlanSubject=$idPlanSubject";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: Tables\plansubject.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo

    // Obtener las opciones disponibles para studyplan
    $studyPlanOptions = "";
    $sqlStudyPlan = "SELECT idPlan, description FROM studyplan";
    $resultStudyPlan = $connection->query($sqlStudyPlan);
    while ($rowStudyPlan = $resultStudyPlan->fetch_assoc()) {
        $selected = ($rowStudyPlan['idPlan'] == $idPlan) ? "selected" : "";
        $studyPlanOptions .= "<option value='{$rowStudyPlan['idPlan']}' {$selected}>{$rowStudyPlan['description']}</option>";
    }

    // Obtener las opciones disponibles para subject
    $subjectOptions = "";
    $sqlSubject = "SELECT idSubject, name FROM subject";
    $resultSubject = $connection->query($sqlSubject);
    while ($rowSubject = $resultSubject->fetch_assoc()) {
        $selected = ($rowSubject['idSubject'] == $idSubject) ? "selected" : "";
        $subjectOptions .= "<option value='{$rowSubject['idSubject']}' {$selected}>{$rowSubject['name']}</option>";
    }
} else {
    extract($_POST);

    do {
        if (empty($idPlanSubject) || empty($idPlan) || empty($idSubject)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE plansubject " .
            "SET idPlan = $idPlan, idSubject = $idSubject " .
            "WHERE idPlanSubject = $idPlanSubject";

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
        <h2>Modificar Plan y Materia</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idPlanSubject" value="<?php echo $idPlanSubject; ?>">
            
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Plan</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idPlan">
                        <?php echo $studyPlanOptions; ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Materia</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idSubject">
                        <?php echo $subjectOptions; ?>
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\PlanSubject\tablePlanSubject.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$idPlan = $idSubject = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPlan = $_POST["idPlan"];
    $idSubject = $_POST["idSubject"];

    do {
        if (empty($idPlan) || empty($idSubject)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        // Cambios en la consulta para incluir el status
        $sql = "INSERT INTO plansubject (idPlan, idSubject, status)" .
                "VALUES ($idPlan, $idSubject, 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $idPlan = $idSubject = "";
        $successMessage = "Se añadió el plan y materia correctamente";

    } while (false);
}

// Obtener las opciones disponibles para studyplan
$studyPlanOptions = "";
$sqlStudyPlan = "SELECT idPlan, description FROM studyplan";
$resultStudyPlan = $connection->query($sqlStudyPlan);
while ($rowStudyPlan = $resultStudyPlan->fetch_assoc()) {
    $studyPlanOptions .= "<option value='{$rowStudyPlan['idPlan']}'>{$rowStudyPlan['description']}</option>";
}

// Obtener las opciones disponibles para subject
$subjectOptions = "";
$sqlSubject = "SELECT idSubject, name FROM subject";
$resultSubject = $connection->query($sqlSubject);
while ($rowSubject = $resultSubject->fetch_assoc()) {
    $subjectOptions .= "<option value='{$rowSubject['idSubject']}'>{$rowSubject['name']}</option>";
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
</head>
<body>
    <div class="container my-5">
        <h2>Nuevo Plan y Materia</h2>
        <?php
        if (!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            "; 
        }
        ?>
        <form method="post">
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
            <?php
            if (!empty($successMessage)){
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Registro Correcto</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid" >
                    <button type="submit" class="btn btn-light btn-sm'">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid" >
                <a class="btn btn-light btn-sm'" href="/web/Area_Academica/PlanSubject/tablePlanSubject.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

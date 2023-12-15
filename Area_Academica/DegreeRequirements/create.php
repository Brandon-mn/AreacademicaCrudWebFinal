<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$semester = "";
$tipo = "";
$idSubject = "";
$idCareer = "";
$errorMessage = "";
$successMessage = "";

// Obtener opciones para el combo de Materia
$sqlSubjects = "SELECT idSubject, name FROM subject WHERE status = 1";
$resultSubjects = $connection->query($sqlSubjects);

// Obtener opciones para el combo de Carrera
$sqlCareers = "SELECT idCareer, careerName FROM career WHERE status = 1";
$resultCareers = $connection->query($sqlCareers);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST["semester"];
    $tipo = $_POST["tipo"];
    $idSubject = $_POST["idSubject"];
    $idCareer = $_POST["idCareer"];

    do {
        if (empty($semester) || empty($tipo) || empty($idSubject) || empty($idCareer)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO degreerequirements (semester, tipo, idSubject, idCareer, status)" .
                "VALUES ('$semester', '$tipo', '$idSubject', '$idCareer', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $semester = "";
        $tipo = "";
        $idSubject = "";
        $idCareer = "";
        $successMessage = "Se añadieron los requisitos de grado";

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
    <!-- Agregado el siguiente script para el selector de fecha -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nuevos Requisitos de Grado</h2>
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
                    <!-- Combo para seleccionar la Materia -->
                    <select class="form-select" name="idSubject" required>
                        <?php
                        while ($subject = $resultSubjects->fetch_assoc()) {
                            echo "<option value='{$subject['idSubject']}'>{$subject['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Carrera</label>
                <div class="col-sm-6">
                    <!-- Combo para seleccionar la Carrera -->
                    <select class="form-select" name="idCareer" required>
                        <?php
                        while ($career = $resultCareers->fetch_assoc()) {
                            echo "<option value='{$career['idCareer']}'>{$career['careerName']}</option>";
                        }
                        ?>
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
                    <button type="submit" class="btn btn-light btn-sm">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid" >
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\DegreeRequirements\tableDegreeRequirments.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Script para inicializar el selector de fecha -->
    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
</body>
</html>

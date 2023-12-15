<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idDropout = $dropoutDate = $Reason = $idStudent = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idDropout"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idDropout = $_GET["idDropout"];
    $sql = "SELECT * FROM dropout WHERE idDropout=$idDropout";
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
        if (empty($idDropout) || empty($dropoutDate) || empty($Reason) || empty($idStudent)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE dropout " .
            "SET dropoutDate = '$dropoutDate', Reason = '$Reason', idStudent = $idStudent " .
            "WHERE idDropout = $idDropout";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Registro Actualizado";

    } while (false);
}

// Obtener la lista de estudiantes para la combobox
$sqlStudents = "SELECT idStudent, CONCAT(name, ' ', lastName) AS studentName FROM student";
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
    <!-- Agregado el siguiente script para el selector de fecha -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Modificar Dropout</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idDropout" value="<?php echo $idDropout; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Dropout</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de dropout con el selector -->
                    <input type="text" class="form-control datepicker" name="dropoutDate" value="<?php echo $dropoutDate; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Razón</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Reason" value="<?php echo $Reason; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Estudiante</label>
                <div class="col-sm-6">
                    <!-- Combobox para seleccionar el estudiante -->
                    <select class="form-select" name="idStudent">
                        <option value="" disabled selected>Selecciona un estudiante</option>
                        <?php
                        while ($rowStudent = $resultStudents->fetch_assoc()) {
                            $selected = ($idStudent == $rowStudent['idStudent']) ? 'selected' : '';
                            echo "<option value='{$rowStudent['idStudent']}' $selected>{$rowStudent['studentName']}</option>";
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
                    <a class="btn btn-light btn-sm" href="/web/Area_Academica/DropOut/tableDropOut.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Script para inicializar el selector de fecha -->
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
</body>

</html>

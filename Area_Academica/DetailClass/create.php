<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idDetailClass = $startTime = $endTime = $days = $idClass = $errorMessage = $successMessage = "";

// Obtener los IDs de la tabla class
$sqlClass = "SELECT idClass FROM class";
$resultClass = $connection->query($sqlClass);
$classOptions = "";

while ($rowClass = $resultClass->fetch_assoc()) {
    $classId = $rowClass['idClass'];
    $classOptions .= "<option value='$classId'>$classId</option>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $days = $_POST["days"];
    $idClass = $_POST["idClass"];

    do {
        if (empty($startTime) || empty($endTime) || empty($days) || empty($idClass)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $status = 1; // Establecer el status en 1

        $sql = "INSERT INTO detailclass (startTime, endTime, days, idClass, status)" .
                "VALUES ('$startTime', '$endTime', '$days', '$idClass', '$status')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $startTime = "";
        $endTime = "";
        $days = "";
        $idClass = "";
        $successMessage = "Se añadió el detalle de clase";

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
        <h2>Nuevo Detalle de Clase</h2>
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
                <label class="col-sm-3 col-form-label">Hora de Inicio</label>
                <div class="col-sm-6">
                    <input type="time" class="form-control" name="startTime" value="<?php echo $startTime; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Hora de Fin</label>
                <div class="col-sm-6">
                    <input type="time" class="form-control" name="endTime" value="<?php echo $endTime; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Días</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="days" value="<?php echo $days; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">ID de Clase</label>
                <div class="col-sm-6">
                    <!-- Combobox para mostrar los IDs disponibles -->
                    <select class="form-select" name="idClass">
                        <?php echo $classOptions; ?>
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
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\DetailClass\tableDetailClass.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

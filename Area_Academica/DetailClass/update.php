<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idDetailClass = $startTime = $endTime = $days = $idClass = $errorMessage = $successMessage = "";
$classOptions = ""; // Variable para almacenar las opciones del campo de selección

// Obtener los IDs de la tabla class para mostrar en el campo de selección
$sqlClass = "SELECT idClass FROM class";
$resultClass = $connection->query($sqlClass);

if ($resultClass) {
    while ($rowClass = $resultClass->fetch_assoc()) {
        $classOptions .= "<option value='{$rowClass['idClass']}'>{$rowClass['idClass']}</option>";
    }
} else {
    $errorMessage = "Error al obtener los IDs de la tabla class: " . $connection->error;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idDetailClass"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idDetailClass = $_GET["idDetailClass"];
    $sql = "SELECT * FROM detailclass WHERE idDetailClass=$idDetailClass";
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
        if (empty($idDetailClass) || empty($startTime) || empty($endTime) || empty($days) || empty($idClass)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE detailclass " .
            "SET startTime = '$startTime', endTime = '$endTime', days = '$days', idClass = '$idClass' " .
            "WHERE idDetailClass = $idDetailClass";

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
        <h2>Modificar Detalle de Clase</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idDetailClass" value="<?php echo $idDetailClass; ?>">
            
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
                    <!-- Cambiado a un campo de selección (combobox) -->
                    <select class="form-select" name="idClass">
                        <?php echo $classOptions; ?>
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\DetailClass\tableDetailClass.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

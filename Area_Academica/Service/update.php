<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idService = $startDate = $endDate = $serviceCost = $serviceDescription = $ServiceName = $idExternalPayment = $errorMessage = $successMessage = "";

// Obtener opciones de referencia
$referenceOptions = [];
$sqlReferences = "SELECT idExternalPayment, referenceNumber FROM externalpayment";
$resultReferences = $connection->query($sqlReferences);

if ($resultReferences) {
    while ($rowReference = $resultReferences->fetch_assoc()) {
        $referenceOptions[$rowReference['idExternalPayment']] = $rowReference['referenceNumber'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idService"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idService = $_GET["idService"];
    $sql = "SELECT s.*, e.referenceNumber FROM service s
            JOIN externalpayment e ON s.idExternalPayment = e.idExternalPayment
            WHERE idService=$idService";
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
        if (empty($idService) || empty($startDate) || empty($endDate) || empty($serviceCost) || empty($serviceDescription) || empty($ServiceName) || empty($idExternalPayment)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE service " .
            "SET startDate = '$startDate', endDate = '$endDate', serviceCost = '$serviceCost', serviceDescription = '$serviceDescription', ServiceName = '$ServiceName', idExternalPayment = '$idExternalPayment' " .
            "WHERE idService = $idService";

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
        <h2>Modificar Servicio</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idService" value="<?php echo $idService; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Inicio</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="startDate" value="<?php echo $startDate; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Fin</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="endDate" value="<?php echo $endDate; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Costo del Servicio</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="serviceCost" value="<?php echo $serviceCost; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Descripción del Servicio</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="serviceDescription" value="<?php echo $serviceDescription; ?>">
                </div>
            </div>

            <div class="col-sm-6">
    <label class="col-sm-3 col-form-label">Nombre del Servicio</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="ServiceName" value="<?php echo $ServiceName; ?>">
    </div>
</div>



            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Número de Referencia</label>
                <div class="col-sm-6">
                    <!-- Combo box para el número de referencia -->
                    <select class="form-select" name="idExternalPayment">
                        <?php
                        foreach ($referenceOptions as $id => $referenceNumber) {
                            $selected = ($id == $idExternalPayment) ? "selected" : "";
                            echo "<option value='$id' $selected>$referenceNumber</option>";
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\Service\tableService.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

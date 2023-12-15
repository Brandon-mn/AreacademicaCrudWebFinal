<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idServicePayment = $amount = $paymentDate = $paymentMethod = $bank = $idApplication = $idService = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idServicePayment"])) {
        header("location: /web/Area_Academica/ServicePayment/tableServicePayment.php ");
        exit;
    }

    $idServicePayment = $_GET["idServicePayment"];
    $sql = "SELECT * FROM servicepayment WHERE idServicePayment=$idServicePayment";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /web/Area_Academica/ServicePayment/tableServicePayment.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo

    // Obtener opciones para idApplication
    $optionsApplication = [];
    $sqlApplication = "SELECT idApplication, TemporalID FROM application";
    $resultApplication = $connection->query($sqlApplication);
    while ($rowApplication = $resultApplication->fetch_assoc()) {
        $optionsApplication[$rowApplication['idApplication']] = $rowApplication['TemporalID'];
    }

    // Obtener opciones para idService
    $optionsService = [];
    $sqlService = "SELECT idService, ServiceName FROM service";
    $resultService = $connection->query($sqlService);
    while ($rowService = $resultService->fetch_assoc()) {
        $optionsService[$rowService['idService']] = $rowService['ServiceName'];
    }
} else {
    extract($_POST);

    do {
        if (empty($idServicePayment) || empty($amount) || empty($paymentDate) || empty($paymentMethod) || empty($bank) || empty($idApplication) || empty($idService)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE servicepayment " .
            "SET amount = '$amount', paymentDate = '$paymentDate', paymentMethod = '$paymentMethod', bank = '$bank', idApplication = '$idApplication', idService = '$idService' " .
            "WHERE idServicePayment = $idServicePayment";

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
        <h2>Modificar Pago de Servicio</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idServicePayment" value="<?php echo $idServicePayment; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Monto</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Pago</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="paymentDate" value="<?php echo $paymentDate; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Método de Pago</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="paymentMethod" value="<?php echo $paymentMethod; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Banco</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bank" value="<?php echo $bank; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">ID de Aplicación</label>
                <div class="col-sm-6">
                    <!-- Combobox para idApplication -->
                    <select class="form-control" name="idApplication">
                        <?php
                        foreach ($optionsApplication as $key => $value) {
                            echo "<option value='$key' " . ($key == $idApplication ? "selected" : "") . ">$value</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">ID de Servicio</label>
                <div class="col-sm-6">
                    <!-- Combobox para idService -->
                    <select class="form-control" name="idService">
                        <?php
                        foreach ($optionsService as $key => $value) {
                            echo "<option value='$key' " . ($key == $idService ? "selected" : "") . ">$value</option>";
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
                    <a class="btn btn-light btn-sm" href="/web/Area_Academica/ServicePayment/tableServicePayment.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

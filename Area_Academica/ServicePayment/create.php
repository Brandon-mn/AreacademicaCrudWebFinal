<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$amount = "";
$paymentDate = "";
$paymentMethod = "";
$bank = "";
$idApplication = "";
$idService = "";
$errorMessage = "";
$successMessage = "";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST["amount"];
    $paymentDate = $_POST["paymentDate"];
    $paymentMethod = $_POST["paymentMethod"];
    $bank = $_POST["bank"];
    $idApplication = $_POST["idApplication"];
    $idService = $_POST["idService"];

    do {
        if (empty($amount) || empty($paymentDate) || empty($paymentMethod) || empty($bank) || empty($idApplication) || empty($idService)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO servicepayment (amount, paymentDate, paymentMethod, bank, idApplication, idService, status)" .
                "VALUES ('$amount', '$paymentDate', '$paymentMethod', '$bank', '$idApplication', '$idService', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $amount = "";
        $paymentDate = "";
        $paymentMethod = "";
        $bank = "";
        $idApplication = "";
        $idService = "";
        $successMessage = "Se añadió el pago de servicio";

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
        <h2>Nuevo Pago de Servicio</h2>
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
                <label class="col-sm-3 col-form-label">Monto</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Pago</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control datepicker" name="paymentDate" value="<?php echo $paymentDate; ?>">
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
                            echo "<option value='$key'>$value</option>";
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
                            echo "<option value='$key'>$value</option>";
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
                    <button type="submit" class="btn btn-light btn-sm'">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid" >
                    <a class="btn btn-light btn-sm'" href="/web/Area_Academica/ServicePayment/tableServicePayment.php" role="button">Regresar</a>
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

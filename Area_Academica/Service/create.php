<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$startDate = $endDate = $serviceCost = $serviceDescription = $ServiceName = $idExternalPayment = $errorMessage = $successMessage = "";

// Obtener opciones para el número de referencia desde la tabla externalpayment
$referenceOptions = array();
$sqlReference = "SELECT idExternalPayment, referenceNumber FROM externalpayment";
$resultReference = $connection->query($sqlReference);

if ($resultReference) {
    while ($rowReference = $resultReference->fetch_assoc()) {
        $referenceOptions[$rowReference['idExternalPayment']] = $rowReference['referenceNumber'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $serviceCost = $_POST["serviceCost"];
    $serviceDescription = $_POST["serviceDescription"];
    $ServiceName = $_POST["ServiceName"];
    $idExternalPayment = $_POST["idExternalPayment"];

    do {
        if (empty($startDate) || empty($endDate) || empty($serviceCost) || empty($serviceDescription) || empty($ServiceName) || empty($idExternalPayment)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO service (startDate, endDate, serviceCost, serviceDescription, ServiceName, idExternalPayment, status)" .
                "VALUES ('$startDate', '$endDate', '$serviceCost', '$serviceDescription', '$ServiceName', '$idExternalPayment', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $startDate = $endDate = $serviceCost = $serviceDescription = $ServiceName = $idExternalPayment = "";
        $successMessage = "Se añadió el servicio";

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista De Servicios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Agregado el siguiente script para el selector de fecha -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Nuevo Servicio</h2>
        <?php
        if (!empty($errorMessage)) {
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
                <label class="col-sm-3 col-form-label">Fecha de Inicio</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de inicio con el selector -->
                    <input type="text" class="form-control datepicker" name="startDate" value="<?php echo $startDate; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Fin</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de fin con el selector -->
                    <input type="text" class="form-control datepicker" name="endDate" value="<?php echo $endDate; ?>">
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
                            echo "<option value='$id'>$referenceNumber</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            if (!empty($successMessage)) {
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
                    <a class="btn btn-light btn-sm" href="/web/Area_Academica/Service/tableService.php" role="button">Regresar</a>
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

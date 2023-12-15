<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$name = $lastName = $dateOfBirth = $gender = $address = $phoneNumber = $email = $maritalStatus = $hireDate = $hasPreviousExperiencie = $idContract = $idPosition = $idApplication = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $maritalStatus = $_POST["maritalStatus"];
    $hireDate = $_POST["hireDate"];
    $hasPreviousExperiencie = $_POST["hasPreviousExperiencie"];
    $idContract = $_POST["idContract"];
    $idPosition = $_POST["idPosition"];
    $idApplication = $_POST["idApplication"];

    do {
        // Verificar campos obligatorios
        if (empty($name) || empty($lastName) || empty($dateOfBirth) || empty($gender) || empty($idContract) || empty($idPosition) || empty($idApplication)) {
            $errorMessage = "Llena todos los campos obligatorios";
            break;
        }

        // Insertar datos en la tabla employee
        $sql = "INSERT INTO employee (name, lastName, dateOfBirth, gender, address, phoneNumber, email, maritalStatus, hireDate, hasPreviousExperiencie, idContract, idPosition, idApplication, status) " .
            "VALUES ('$name', '$lastName', '$dateOfBirth', '$gender', '$address', '$phoneNumber', '$email', '$maritalStatus', '$hireDate', '$hasPreviousExperiencie', '$idContract', '$idPosition', '$idApplication', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Empleado agregado correctamente";

        // Limpiar variables después de la inserción exitosa
        $name = $lastName = $dateOfBirth = $gender = $address = $phoneNumber = $email = $maritalStatus = $hireDate = $hasPreviousExperiencie = $idContract = $idPosition = $idApplication = "";
    } while (false);
}

// Obtener datos para ComboBox de Contract ID
$sqlContracts = "SELECT idContract FROM contract WHERE status = 1";
$resultContracts = $connection->query($sqlContracts);

// Obtener datos para ComboBox de Position
$sqlPositions = "SELECT idPosition, name FROM position";
$resultPositions = $connection->query($sqlPositions);

// Obtener datos para ComboBox de Application Temporal ID
$sqlApplications = "SELECT idApplication, TemporalID FROM application";
$resultApplications = $connection->query($sqlApplications);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Nuevo Empleado</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        if (!empty($successMessage)) {
            echo "
            <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
        <form method="post">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Apellido</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control datepicker" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Género</label>
                <div class="col-sm-6">
                    <select class="form-select" name="gender">
                        <option value="M" <?php echo $gender === 'M' ? 'selected' : ''; ?>>M</option>
                        <option value="F" <?php echo $gender === 'F' ? 'selected' : ''; ?>>F</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Dirección</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Número de Teléfono</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Correo Electrónico</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Estado Civil</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="maritalStatus" value="<?php echo $maritalStatus; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Contratación</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control datepicker" name="hireDate" value="<?php echo $hireDate; ?>">
                </div>
            </div>
            
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Experiencia Prev.</label>
                <div class="col-sm-6">
                    <select class="form-select" name="hasPreviousExperiencie">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <!-- ComboBox para Contract ID -->
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">ID del Contrato</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idContract">
                        <?php
                        while ($row = $resultContracts->fetch_assoc()) {
                            echo "<option value='{$row['idContract']}'>{$row['idContract']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- ComboBox para Position -->
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre del Cargo</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idPosition">
                        <?php
                        while ($row = $resultPositions->fetch_assoc()) {
                            echo "<option value='{$row['idPosition']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- ComboBox para Application Temporal ID -->
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Temporal ID de Aplicación</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idApplication">
                        <?php
                        while ($row = $resultApplications->fetch_assoc()) {
                            echo "<option value='{$row['idApplication']}'>{$row['TemporalID']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

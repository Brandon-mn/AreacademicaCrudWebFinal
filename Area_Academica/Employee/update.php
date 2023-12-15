<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idEmployee = $name = $lastName = $dateOfBirth = $gender = $address = $phoneNumber = $email = $maritalStatus = $hireDate = $hasPreviousExperiencie = $idContract = $idPosition = $idApplication = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idEmployee"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idEmployee = $_GET["idEmployee"];
    $sql = "SELECT * FROM employee WHERE idEmployee=$idEmployee";
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
        // Verificar campos obligatorios
        if (empty($idEmployee) || empty($name) || empty($lastName) || empty($dateOfBirth) || empty($gender)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        // Actualizar datos en la tabla employee
        $sql = "UPDATE employee " .
            "SET name = '$name', lastName = '$lastName', dateOfBirth = '$dateOfBirth', gender = '$gender', " .
            "address = '$address', phoneNumber = '$phoneNumber', email = '$email', maritalStatus = '$maritalStatus', " .
            "hireDate = '$hireDate', hasPreviousExperiencie = '$hasPreviousExperiencie' " .
            "WHERE idEmployee = $idEmployee";

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
        <h2>Modificar Empleado</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idEmployee" value="<?php echo $idEmployee; ?>">
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\Employee\tableEmployee.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idApplication = $ApplicantFirstName = $ApplicantLastName = $Gender = $DateOfBirth = $TemporalID = $SchoolOfOrigin = $ApplicationDate = $Grade = $PreferredCareer = $SecondPreferredCareer = $ThirdPreferredCareer = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idApplication"])) {
        header("location: tableApplication.php ");
        exit;
    }

    $idApplication = $_GET["idApplication"];
    $sql = "SELECT * FROM application WHERE idApplication=$idApplication";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: tableApplication.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo
} else {
    extract($_POST);

    do {
        // Validar los campos necesarios
        if (empty($idApplication) || empty($ApplicantFirstName) || empty($ApplicantLastName) || empty($Gender) || empty($DateOfBirth) || empty($TemporalID) || empty($SchoolOfOrigin) || empty($ApplicationDate) || empty($Grade) || empty($PreferredCareer) || empty($SecondPreferredCareer) || empty($ThirdPreferredCareer)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        // Actualizar los datos en la base de datos
        $sql = "UPDATE application " .
            "SET ApplicantFirstName = '$ApplicantFirstName', ApplicantLastName = '$ApplicantLastName', Gender = '$Gender', DateOfBirth = '$DateOfBirth', TemporalID = '$TemporalID', SchoolOfOrigin = '$SchoolOfOrigin', ApplicationDate = '$ApplicationDate', Grade = '$Grade', PreferredCareer = '$PreferredCareer', SecondPreferredCareer = '$SecondPreferredCareer', ThirdPreferredCareer = '$ThirdPreferredCareer' " .
            "WHERE idApplication = $idApplication";

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
        <h2>Modificar Aplicación</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idApplication" value="<?php echo $idApplication; ?>">

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre del Solicitante</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ApplicantFirstName" value="<?php echo $ApplicantFirstName; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Apellido del Solicitante</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ApplicantLastName" value="<?php echo $ApplicantLastName; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Género</label>
                <div class="col-sm-6">
                    <select class="form-select" name="Gender">
                        <option value="M" <?php echo ($Gender === 'M') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="F" <?php echo ($Gender === 'F') ? 'selected' : ''; ?>>Femenino</option>
                    </select>
                </div>
                </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control datepicker" name="DateOfBirth" value="<?php echo $DateOfBirth; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Temporal ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="TemporalID" value="<?php echo $TemporalID; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Escuela de Origen</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="SchoolOfOrigin" value="<?php echo $SchoolOfOrigin; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Aplicación</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control datepicker" name="ApplicationDate" value="<?php echo $ApplicationDate; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Grado</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Grade" value="<?php echo $Grade; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Carrera Preferida</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="PreferredCareer" value="<?php echo $PreferredCareer; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Segunda Carrera Preferida</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="SecondPreferredCareer" value="<?php echo $SecondPreferredCareer; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Tercera Carrera Preferida</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ThirdPreferredCareer" value="<?php echo $ThirdPreferredCareer; ?>">
                </div>
            </div>
            </div>

            <!-- Agregar los demás campos del formulario -->
            <!-- ... -->

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
                    <a class="btn btn-light btn-sm" href="tableApplication.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idCandidateStudent = $contactInfo = $gender = $address = $nationality = $name = $idStudent = $idApplication = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idCandidateStudent"])) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    $idCandidateStudent = $_GET["idCandidateStudent"];
    $sql = "SELECT * FROM candidatestudent WHERE idCandidateStudent=$idCandidateStudent";
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
        if (empty($idCandidateStudent) || empty($contactInfo) || empty($gender) || empty($address) || empty($nationality) || empty($name) || empty($idStudent) || empty($idApplication)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE candidatestudent " .
            "SET contactInfo = '$contactInfo', gender = '$gender', address = '$address', nationality = '$nationality', name = '$name', idStudent = '$idStudent', idApplication = '$idApplication' " .
            "WHERE idCandidateStudent = $idCandidateStudent";

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
        <h2>Modificar CandidateStudent</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idCandidateStudent" value="<?php echo $idCandidateStudent; ?>">

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Contact Info</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactInfo" value="<?php echo $contactInfo; ?>">
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
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nationality</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nationality" value="<?php echo $nationality; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>

            <!-- Resto de los campos -->

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Estudiante</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idStudent">
                        <?php
                        // Obtener las opciones disponibles para student
                        $studentOptions = "";
                        $sqlStudent = "SELECT idStudent, name, lastName FROM student";
                        $resultStudent = $connection->query($sqlStudent);
                        while ($rowStudent = $resultStudent->fetch_assoc()) {
                            $selected = ($rowStudent['idStudent'] == $idStudent) ? "selected" : "";
                            $studentOptions .= "<option value='{$rowStudent['idStudent']}' $selected>{$rowStudent['name']} {$rowStudent['lastName']}</option>";
                        }
                        echo $studentOptions;
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Aplicación Temporal</label>
                <div class="col-sm-6">
                    <select class="form-select" name="idApplication">
                        <?php
                        // Obtener las opciones disponibles para application
                        $applicationOptions = "";
                        $sqlApplication = "SELECT idApplication, TemporalID FROM application";
                        $resultApplication = $connection->query($sqlApplication);
                        while ($rowApplication = $resultApplication->fetch_assoc()) {
                            $selected = ($rowApplication['idApplication'] == $idApplication) ? "selected" : "";
                            $applicationOptions .= "<option value='{$rowApplication['idApplication']}' $selected>{$rowApplication['TemporalID']}</option>";
                        }
                        echo $applicationOptions;
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\CandidateStudent\tableCandidateStudent.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

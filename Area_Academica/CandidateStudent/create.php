<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$contactInfo = "";
$gender = "";
$address = "";
$nationality = "";
$name = "";
$idStudent = "";
$idApplication = "";
$errorMessage = "";
$successMessage = "";

// Obtener las opciones disponibles para idStudent
$idStudentOptions = "";
$sqlStudent = "SELECT idStudent, name, lastName FROM student";
$resultStudent = $connection->query($sqlStudent);
while ($rowStudent = $resultStudent->fetch_assoc()) {
    $idStudentOptions .= "<option value='{$rowStudent['idStudent']}'>{$rowStudent['name']} {$rowStudent['lastName']}</option>";
}

// Obtener las opciones disponibles para idApplication
$idApplicationOptions = "";
$sqlApplication = "SELECT idApplication, TemporalID FROM application";
$resultApplication = $connection->query($sqlApplication);
while ($rowApplication = $resultApplication->fetch_assoc()) {
    $idApplicationOptions .= "<option value='{$rowApplication['idApplication']}'>{$rowApplication['TemporalID']}</option>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contactInfo = $_POST["contactInfo"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $nationality = $_POST["nationality"];
    $name = $_POST["name"];
    $idStudent = $_POST["idStudent"];
    $idApplication = $_POST["idApplication"];

    do {
        if (empty($contactInfo) || empty($gender) || empty($address) || empty($nationality) || empty($name) || empty($idStudent) || empty($idApplication)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO candidatestudent (contactInfo, gender, address, nationality, name, idStudent, idApplication, status)" .
                "VALUES ('$contactInfo', '$gender', '$address', '$nationality', '$name', '$idStudent', '$idApplication', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $contactInfo = "";
        $gender = "";
        $address = "";
        $nationality = "";
        $name = "";
        $idStudent = "";
        $idApplication = "";
        $successMessage = "Se añadió el registro correctamente";

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
        <h2>Nuevo CandidateStudent</h2>
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
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Student</label>
                <div class="col-sm-6">
                    <!-- Agregar combobox para idStudent -->
                    <select class="form-select" name="idStudent">
                        <?php echo $idStudentOptions; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Application TemporalID</label>
                <div class="col-sm-6">
                    <!-- Agregar combobox para idApplication -->
                    <select class="form-select" name="idApplication">
                        <?php echo $idApplicationOptions; ?>
                    </select>
                </div>
            </div>
            <?php
            if (!empty($successMessage)){
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
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\CandidateStudent\tableCandidateStudent.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

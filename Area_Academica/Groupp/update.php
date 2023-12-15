<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idGroup = $groupName = $numberOfStudents = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idGroup"])) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    $idGroup = $_GET["idGroup"];
    $sql = "SELECT * FROM groupp WHERE idGroup=$idGroup";
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
        if (empty($idGroup) || empty($groupName) || empty($numberOfStudents)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE groupp " .
            "SET groupName = '$groupName', numberOfStudents = '$numberOfStudents' " ."WHERE idGroup = $idGroup";

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
        <h2>Modificar Grupo</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idGroup" value="<?php echo $idGroup; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre de Grupo</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="groupName" value="<?php echo $groupName; ?>">
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Número de Estudiantes</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="numberOfStudents" value="<?php echo $numberOfStudents; ?>">
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\Groupp\tableGroupp.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
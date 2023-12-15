<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idStudentActivity = $idStudent = $idActivity = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idStudentActivity"])) {
        header("location: Tables\pableProveedor.php ");
        exit;
    }

    $idStudentActivity = $_GET["idStudentActivity"];
    $sql = "SELECT * FROM studentactivity WHERE idStudentActivity=$idStudentActivity";
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
        if (empty($idStudentActivity) || empty($idStudent) || empty($idActivity)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE studentactivity " .
            "SET idStudent = '$idStudent', idActivity = '$idActivity' " .
            "WHERE idStudentActivity = $idStudentActivity";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessage = "Registro Actualizado";

    } while (false);
}

// Obtener opciones para los combobox
$sqlEvents = "SELECT idStudent, name FROM student";
$resultEvents = $connection->query($sqlEvents);

$sqlEvents = "SELECT idActivity, activityName FROM activity";
$resultEvents = $connection->query($sqlEvents);
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
        <h2>Modificar Evento y Estudiante</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idStudentActivity" value="<?php echo $idStudentActivity; ?>">

            <option selected disabled> --Select the Student--</option>
        <select class="form-control" name="idStudent">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM student where status = 1";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idStudent'] . "'>" . $registro['name'] . "</option>";
     }
  ?>
        </select>    
            <option selected disabled> --Select the Activity--</option>
        <select class="form-control" name="idActivity">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM activity where status = 1";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idActivity'] . "'>" . $registro['activityName'] . "</option>";
     }
  ?>
        </select>    

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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\StudentActivity\tableStudentActivity.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
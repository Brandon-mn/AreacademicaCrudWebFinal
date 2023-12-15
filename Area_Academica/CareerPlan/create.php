<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$idCareer = "";
$idPlan = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCareer = $_POST["idCareer"];
    $idPlan = $_POST["idPlan"];


    do {
        if (empty($idCareer) || empty($idPlan) ) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO careerplan (idCareer, idPlan,status)" .
                "VALUES ('$idCareer', '$idPlan',1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }
        $idCareer = "";
        $idPlan = "";
        $successMessage = "Se añadió el studentactivity";

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
        <h2>Nuevo Evento</h2>
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
                <option selected disabled> --Select the Career--</option>
        <select class="form-control" name="idCareer"placeholder="Select the Career">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM career";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idCareer'] . "'>" . $registro['careerName'] . "</option>";
     }
  ?>
        </select>
        <option selected disabled> --Select the Plan--</option>
        <select class="form-control" name="idPlan"placeholder="Select the plan">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM studyplan";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idPlan'] . "'>" . $registro['description'] . "</option>";
     }
  ?>
        </select>
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
                <a class="btn btn-light btn-sm'" href="/web/Area_Academica/CareerPlan/tableCareerPlan.php" role="button">Regresar</a>
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

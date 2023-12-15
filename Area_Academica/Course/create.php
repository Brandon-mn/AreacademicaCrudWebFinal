<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$courseName = "";
$credits = "";
$description = "";
$enrollmentCapacity = "";
$idStudent = "";
$idEmployee = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseName = $_POST["courseName"];
    $credits = $_POST["credits"];
    $description = $_POST["description"];
    $enrollmentCapacity = $_POST["enrollmentCapacity"];
    $idStudent = $_POST["idStudent"];
    $idEmployee = $_POST["idEmployee"];

    do {
        if (empty($courseName) || empty($credits)|| empty($description)|| empty($enrollmentCapacity)|| empty($idStudent)|| empty($idEmployee)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO course (courseName, credits, description,enrollmentCapacity,idStudent,idEmployee)" .
                "VALUES ('$courseName', '$credits','$description','$enrollmentCapacity','$idStudent','$idEmployee')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }
        $courseName = "";
        $credits = "";
        $description = "";
        $enrollmentCapacity = "";
        $idStudent = "";
        $idEmployee = "";
        $successMessage = "Se añadió el contrato";

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
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label"> courseName</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de inicio con el selector -->
                    <input type="text" class="form-control text" name="courseName" value="<?php echo $courseName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label"> credits</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de inicio con el selector -->
                    <input type="text" class="form-control text" name="credits" value="<?php echo $credits; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label"> description</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de inicio con el selector -->
                    <input type="text" class="form-control text" name="description" value="<?php echo $description; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label"> enrollmentCapacity</label>
                <div class="col-sm-6">
                    <!-- Input para la fecha de inicio con el selector -->
                    <input type="text" class="form-control text" name="enrollmentCapacity" value="<?php echo $enrollmentCapacity; ?>">
                </div>
                <option selected disabled> --Select the Student--</option>
        <select class="form-control" name="idStudent"placeholder="Select the Student">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM student";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idStudent'] . "'>" . $registro['name'] . "</option>";
     }
  ?>
        </select>
        <option selected disabled> --Select the Employee--</option>
        <select class="form-control" name="idEmployee"placeholder="Select the Employee">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM employee";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idEmployee'] . "'>" . $registro['name'] . "</option>";
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
                <a class="btn btn-light btn-sm'" href="/web/Area_Academica/Course/tableCourse.php" role="button">Regresar</a>
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

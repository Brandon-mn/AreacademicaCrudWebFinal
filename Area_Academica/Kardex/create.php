<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

// Obtener opciones para el combobox de estudiantes
$sqlStudents = "SELECT idStudent, name FROM student";
$resultStudents = $connection->query($sqlStudents);

// Obtener opciones para el combobox de clases
$sqlClasses = "SELECT idClass FROM class";
$resultClasses = $connection->query($sqlClasses);

$grade = "";
$name = "";
$date = "";
$idStudent = "";
$idClass = "";
$errorMessageKardex = "";
$successMessageKardex = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grade = $_POST["grade"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $idStudent = $_POST["idStudent"];
    $idClass = $_POST["idClass"];

    do {
        if (empty($grade) || empty($name) || empty($date) || empty($idStudent) || empty($idClass)) {
            $errorMessageKardex = "Llena todos los campos";
            break;
        }

        $sqlKardex = "INSERT INTO kardex (grade, name, date, idStudent, idClass, status)" .
                "VALUES ('$grade', '$name', '$date', '$idStudent', '$idClass', 1)";
        $resultKardex = $connection->query($sqlKardex);

        if (!$resultKardex) {
            $errorMessageKardex = "Consulta inválida: " . $connection->error;
            break;
        }

        $grade = "";
        $name = "";
        $date = "";
        $idStudent = "";
        $idClass = "";
        $successMessageKardex = "Se añadió el registro en Kardex";

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
        <h2>Nuevo Registro en Kardex</h2>
        <?php
        if (!empty($errorMessageKardex)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessageKardex</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            "; 
        }
        ?>
        <form method="post">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Grado</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="grade" value="<?php echo $grade; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control datepicker" name="date" value="<?php echo $date; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Estudiante</label>
                <div class="col-sm-6">
                    <!-- Combobox para seleccionar estudiante -->
                    <select class="form-control" name="idStudent">
                        <?php
                        while ($studentRow = $resultStudents->fetch_assoc()) {
                            echo "<option value='{$studentRow['idStudent']}'>{$studentRow['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Clase</label>
                <div class="col-sm-6">
                    <!-- Combobox para seleccionar clase -->
                    <select class="form-control" name="idClass">
                        <?php
                        while ($classRow = $resultClasses->fetch_assoc()) {
                            echo "<option value='{$classRow['idClass']}'>{$classRow['idClass']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            if (!empty($successMessageKardex)){
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessageKardex</strong>
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
                    <a class="btn btn-light btn-sm'" href="/web/Area_Academica/Kardex/tableKardex.php" role="button">Regresar</a>
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

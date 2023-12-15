<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$ApplicantFirstName = $ApplicantLastName = $Gender = $DateOfBirth = $TemporalID = $SchoolOfOrigin = "";
$ApplicationDate = $Grade = $PreferredCareer = $SecondPreferredCareer = $ThirdPreferredCareer = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ApplicantFirstName = $_POST["ApplicantFirstName"];
    $ApplicantLastName = $_POST["ApplicantLastName"];
    $Gender = $_POST["Gender"];
    $DateOfBirth = $_POST["DateOfBirth"];
    $TemporalID = $_POST["TemporalID"];
    $SchoolOfOrigin = $_POST["SchoolOfOrigin"];
    $ApplicationDate = $_POST["ApplicationDate"];
    $Grade = $_POST["Grade"];
    $PreferredCareer = $_POST["PreferredCareer"];
    $SecondPreferredCareer = $_POST["SecondPreferredCareer"];
    $ThirdPreferredCareer = $_POST["ThirdPreferredCareer"];

    do {
        if (empty($ApplicantFirstName) || empty($ApplicantLastName) || empty($Gender) || empty($DateOfBirth) || empty($TemporalID) || empty($SchoolOfOrigin) || empty($ApplicationDate) || empty($Grade) || empty($PreferredCareer)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO application (ApplicantFirstName, ApplicantLastName, Gender, DateOfBirth, TemporalID, SchoolOfOrigin, ApplicationDate, Grade, PreferredCareer, SecondPreferredCareer, ThirdPreferredCareer, status)" .
                "VALUES ('$ApplicantFirstName', '$ApplicantLastName', '$Gender', '$DateOfBirth', '$TemporalID', '$SchoolOfOrigin', '$ApplicationDate', '$Grade', '$PreferredCareer', '$SecondPreferredCareer', '$ThirdPreferredCareer', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $ApplicantFirstName = $ApplicantLastName = $Gender = $DateOfBirth = $TemporalID = $SchoolOfOrigin = "";
        $ApplicationDate = $Grade = $PreferredCareer = $SecondPreferredCareer = $ThirdPreferredCareer = "";
        $successMessage = "Se añadió la aplicación";

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Nueva Aplicación</h2>
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
                    <!-- Combobox para seleccionar el género -->
                    <select class="form-select" name="Gender">
                        <option value="M" <?php if($Gender == 'M') echo 'selected'; ?>>M</option>
                        <option value="F" <?php if($Gender == 'F') echo 'selected'; ?>>F</option>
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
                    <a class="btn btn-light btn-sm'" href="/web/Area_Academica/Application/tableApplication.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>

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

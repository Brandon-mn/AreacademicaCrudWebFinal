<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$name = "";
$lastName = "";
$middleName = "";
$dateOfBirth = "";
$gender = "";
$address = "";
$phoneNumber = "";
$email = "";
$idPlan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $middleName = $_POST["middleName"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $idPlan = $_POST["idPlan"];

    do {
        if (empty($name) || empty($lastName) || empty($middleName) || empty($dateOfBirth) || empty($gender) || empty($address) || empty($phoneNumber) || empty($email) || empty($idPlan)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO student (name, lastName, middleName, dateOfBirth, gender, address, phoneNumber, email, idPlan, status)" .
                "VALUES ('$name', '$lastName', '$middleName', '$dateOfBirth', '$gender', '$address', '$phoneNumber', '$email', '$idPlan', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $name = "";
        $lastName = "";
        $middleName = "";
        $dateOfBirth = "";
        $gender = "";
        $address = "";
        $phoneNumber = "";
        $email = "";
        $idPlan = "";
        $successMessage = "Se añadió el estudiante";

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
        <h2>Nuevo Estudiante</h2>
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
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text" name="lastName" value="<?php echo $lastName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Middel Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text" name="middleName" value="<?php echo $middleName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Date Of Birth</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control text" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
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
                    <input type="text" class="form-control text" name="address" value="<?php echo $address; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <select class="form-control" name="idPlan"placeholder="Select the Plan">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM studyplan where status = 1";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idPlan'] . "'>" . $registro['description'] . "</option>";
     }
  ?>
        </select>
            <!-- Agrega los campos restantes según tus necesidades -->

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
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="/web/Area_Academica/Student/tableStudent.php" role="button">Regresar</a>
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

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idStudent = $name = $lastName = $middleName = $dateOfBirth = $gender = $address = $phoneNumber = $email = $idPlan = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idStudent"])) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    $idStudent = $_GET["idStudent"];
    $sql = "SELECT * FROM student WHERE idStudent=$idStudent";
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
        if (empty($idStudent) || empty($name) || empty($lastName) || empty($middleName) || empty($dateOfBirth) || empty($gender) || empty($address) || empty($phoneNumber) || empty($email) || empty($idPlan)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "UPDATE student " .
            "SET name = '$name', lastName = '$lastName', middleName = '$middleName',
             dateOfBirth = '$dateOfBirth', gender = '$gender', address = '$address',
              phoneNumber = '$phoneNumber', email = '$email', idPlan = '$idPlan'" .
            "WHERE idStudent = $idStudent";

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
        <h2>Modificar Estudiante</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idStudent" value="<?php echo $idStudent; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Apellido</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Segundo Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="middleName" value="<?php echo $middleName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
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
                <label class="col-sm-3 col-form-label">Calle</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Numero Telefonico</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Corre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <option selected disabled> --Select the Plan--</option>
        <select class="form-control" name="idPlan">
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
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\Student\tableStudent.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

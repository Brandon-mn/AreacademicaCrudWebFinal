<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idCourse = $courseName = $credits = $enrollmentCapacity = $idStudent = $idEmployee = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idCourse"])) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    $idCourse = $_GET["idCourse"];
    $sql = "SELECT * FROM course WHERE idCourse = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $idCourse);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: Tables\pableProveedor.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo
    $stmt->close();
} else {
    extract($_POST);

    if (empty($courseName) || empty($credits) || empty($enrollmentCapacity) || empty($idStudent) || empty($idEmployee)) {
        $errorMessage = "Llena todos los campos";
    } else {
        $sql = "UPDATE course SET courseName = ?, credits = ?, enrollmentCapacity = ?, idStudent = ?, idEmployee = ? WHERE idCourse = ?";
        
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssiiii", $courseName, $credits, $enrollmentCapacity, $idStudent, $idEmployee, $idCourse);
        
        if ($stmt->execute()) {
            $successMessage = "Registro Actualizado";
        } else {
            $errorMessage = "Error al actualizar el registro: " . $stmt->error;
        }
        
        $stmt->close();
    }
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
        <h2>Modificar Curso</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idCourse" value="<?php echo $idCourse; ?>">
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Nombre del Curso</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="courseName" value="<?php echo $courseName; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Credits</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="credits" value="<?php echo $credits; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Enrollment Capacity</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="enrollmentCapacity" value="<?php echo $enrollmentCapacity; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Student</label>
                <div class="col-sm-6">
                    <select class="form-control" name="idStudent">
                        <option selected disabled> --Select the Student--</option>
                        <?php 
                            require_once('../conexion.php');
                            $consulta = "SELECT * FROM student where status = 1";
                            $stm = $conexion->query($consulta);      
                            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $registro['idStudent'] . "'>" . $registro['name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Employee</label>
                <div class="col-sm-6">
                    <select class="form-control" name="idEmployee">
                        <option selected disabled> --Select the Employee--</option>
                        <?php 
                            require_once('../conexion.php');
                            $consulta = "SELECT * FROM employee where status = 1";
                            $stm = $conexion->query($consulta);      
                            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $registro['idEmployee'] . "'>" . $registro['name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Modificar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="\web\Area_Academica\Course\tableCourse.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

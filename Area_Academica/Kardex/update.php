<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idKardex = $idStudent = $idClass = $grade = $name = $date = $errorMessageKardex = $successMessageKardex = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["idKardex"])) {
        header("location: tableKardex.php");
        exit;
    }

    $idKardex = $_GET["idKardex"];
    $sql = "SELECT * FROM kardex WHERE idKardex=$idKardex";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: tableKardex.php");
        exit;
    }

    extract($row); // Extraer variables del array asociativo
} else {
    extract($_POST);

    do {
        // Verificar campos obligatorios
        if (empty($idKardex) || empty($idStudent) || empty($idClass) || empty($grade) || empty($name) || empty($date)) {
            $errorMessageKardex = "Llena todos los campos";
            break;
        }

        // Actualizar datos en la tabla kardex
        $sql = "UPDATE kardex " .
            "SET grade = '$grade', name = '$name', date = '$date', idStudent = '$idStudent', idClass = '$idClass' " .
            "WHERE idKardex = $idKardex";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessageKardex = "Consulta inválida: " . $connection->error;
            break;
        }

        $successMessageKardex = "Registro Actualizado";

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
    <title>Modificar Registro en Kardex</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Modificar Registro en Kardex</h2>
        <?php if (!empty($errorMessageKardex)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessageKardex; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="idKardex" value="<?php echo $idKardex; ?>">

            <!-- Agrega los campos específicos de la tabla kardex con opciones seleccionadas automáticamente -->
            <div class="mb-3">
                <label class="form-label">Grado</label>
                <input type="text" class="form-control" name="grade" value="<?php echo $grade; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="mb-3">
    <label class="form-label">Fecha</label>
    <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d', strtotime($date)); ?>" required>
</div>


            <div class="mb-3">
                <label class="form-label">Estudiante</label>
                <select class="form-select" name="idStudent" required>
                    <?php
                    $sqlStudents = "SELECT * FROM student WHERE status = 1";
                    $resultStudents = $connection->query($sqlStudents);
                    while ($student = $resultStudents->fetch_assoc()) {
                        $selected = ($idStudent == $student['idStudent']) ? 'selected' : '';
                        echo "<option value='{$student['idStudent']}' $selected>{$student['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Clase</label>
                <select class="form-select" name="idClass" required>
                    <?php
                    $sqlClasses = "SELECT * FROM class WHERE status = 1";
                    $resultClasses = $connection->query($sqlClasses);
                    while ($class = $resultClasses->fetch_assoc()) {
                        $selected = ($idClass == $class['idClass']) ? 'selected' : '';
                        echo "<option value='{$class['idClass']}' $selected>{$class['idClass']}</option>";
                    }
                    ?>
                </select>
            </div>

            <?php if (!empty($successMessageKardex)): ?>
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong><?php echo $successMessageKardex; ?></strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-6 d-grid">
                    <button type="submit" class="btn btn-light btn-sm">Modificar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-light btn-sm" href="tableKardex.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

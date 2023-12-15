<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexion: " . $connection->connect_error);
}

$name = "";
$description = "";
$contractType = "";
$salary = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $contractType = $_POST["contractType"];
    $salary = $_POST["salary"];

    do {
        if (empty($name) || empty($description) || empty($contractType) || empty($salary)) {
            $errorMessage = "Llena todos los campos";
            break;
        }

        $sql = "INSERT INTO position (name, description, contractType, salary, status)" .
                "VALUES ('$name', '$description', '$contractType', '$salary', 1)";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Consulta inválida: " . $connection->error;
            break;
        }

        $name = "";
        $description = "";
        $contractType = "";
        $salary = "";
        $successMessage = "Se añadió la posición";

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nueva Posición</h2>
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
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Descripción</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Tipo de Contrato</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contractType" value="<?php echo $contractType; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-3 col-form-label">Salario</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="salary" value="<?php echo $salary; ?>">
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
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
                <div class="col-sm-3 d-grid" >
                <a class="btn btn-outline-primary" href="/web/Area_Academica/Position/tablePosition.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

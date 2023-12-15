<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

$idPosition = "";
$name = "";
$description = "";
$contractType = "";
$salary = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER ['REQUEST_METHOD'] == 'GET' ){
    if(!isset ($_GET["idPosition"])){
        header("location: Tables\pableProveedor.php ");
        exit;
    }
    $idPosition = $_GET["idPosition"];
    $sql = "SELECT * FROM position WHERE idPosition=$idPosition";
    $result = $connection ->query($sql);
    $row = $result ->fetch_assoc();
    if (!$row){
        header("location: Tables\pableProveedor.php");
        exit;
    }
    $name = $row["name"];
    $description = $row["description"];
    $contractType = $row["contractType"];
    $salary = $row["salary"];
}
else {
    $idPosition = $_POST["idPosition"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $contractType = $_POST["contractType"];
    $salary = $_POST["salary"];

    do {
        if(empty($idPosition) || empty($name) || empty($description) || empty($contractType) || empty($salary)){
            $errorMessage = "Llena todos los campos";
            break;
        }
        $sql = "UPDATE position " . 
       "SET name = '$name', description = '$description', contractType = '$contractType', salary = '$salary' " . 
       "WHERE idPosition = $idPosition";

         $result = $connection->query($sql);
         if(!$result){
            $errorMessage = "query invalido: " . $connection->error;
            break;
         }

    }while(false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>finalproject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Modificar Posición</h2>
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
            <input type= "hidden" name = "idPosition" value="<?php echo $idPosition; ?>">
            <div class="col-sm-6">
                <label class = "col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                <input type="text" class="from-control" name="name" value = "<?php echo $name; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class = "col-sm-3 col-form-label">Descripción</label>
                <div class="col-sm-6">
                <input type="text" class="from-control" name="description" value = "<?php echo $description; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class = "col-sm-3 col-form-label">Tipo de Contrato</label>
                <div class="col-sm-6">
                <input type="text" class="from-control" name="contractType" value = "<?php echo $contractType; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <label class = "col-sm-3 col-form-label">Salario</label>
                <div class="col-sm-6">
                <input type="text" class="from-control" name="salary" value = "<?php echo $salary; ?>">
                </div>
            </div>
            <?php
            if (!empty($successMessage)){
                echo "
                <div class ='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                <div class = 'alert alert-success alert-dismissible fade show' role 'alert'>
                <strong>Registro Correcto</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert'>/<button>
                </div>
                </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid" >
                    <button type="submit" class = "btn btn btn-light btn-sm">Modificar</button>
                </div>
                <div class="col-sm-3 d-grid" >
                    <a class="btn btn btn-light btn-sm" href = "\web\Area_Academica\Position\tablePosition.php" role="button">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

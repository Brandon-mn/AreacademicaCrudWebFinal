<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$sql = "
SELECT careerplan.idCareerPlan, career.careerName, career.semester, career.description, studyplan.description AS studyplan_description
FROM careerplan
INNER JOIN career ON careerplan.idCareer = career.idCareer
INNER JOIN studyplan ON careerplan.idPlan = studyplan.idPlan
WHERE careerplan.status = 1 AND career.status = 1 AND studyplan.status = 1";

$result = $connection->query($sql);

if (!$result) {
    die("Query inválido: " . $connection->error);
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
    <title>Lista De Eventos de Estudiantes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu">☰</label>
            </div>
        </div>
    </header>
    <div class="capa"></div>
    <!-- --------------->
    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <a href="\web\FinalProject\Tables\pableProveedor.php">Proveedor</a>
                <a href="../Menu/index.html"><input type="button" class="btn btn-outline-dark" value="Return"></a>
                <a href="\web\FinalProject\Login\index.php">LogOut</a>
            </nav>
            <label for="btn-menu">✖️</label>
        </div>
    </div>
    <div class="container my-5">
        <h2>Lista De Eventos de Estudiantes</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\CareerPlan\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>CareerPlan ID</th>
                    <th>Career Name</th>
                    <th>Semester</th>
                    <th>Career Description</th>
                    <th>Study Plan Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idCareerPlan']}</td>
                            <td>{$row['careerName']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['studyplan_description']}</td>
                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\CareerPlan\update.php?idCareerPlan={$row['idCareerPlan']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\CareerPlan\delete.php?idCareerPlan={$row['idCareerPlan']}'>Eliminar</a>
                            </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

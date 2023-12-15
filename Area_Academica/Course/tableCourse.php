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
SELECT *
FROM course
LEFT JOIN student ON course.idStudent = student.idStudent
LEFT JOIN employee ON course.idEmployee = employee.idEmployee
WHERE course.status = 1";


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
    <title>Lista De Grupos</title>
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
        <h2>Lista De Grupos</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\Course\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                <th>ID Course</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Description</th>
                    <th>Enrollment Capacity</th>
                    <th>Name Student</th>
                    <th>Name Employee</th>


                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idCourse']}</td>
                            <td>{$row['courseName']}</td>
                            <td>{$row['credits']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['enrollmentCapacity']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['name']}</td>


                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Course\update.php?idCourse={$row['idCourse']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Course\delete.php?idCourse={$row['idCourse']}'>Eliminar</a>
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
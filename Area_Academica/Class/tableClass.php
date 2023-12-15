<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$sql = "SELECT class.idClass, groupp.groupName, employee.name, employee.lastname, subject.name AS subjectName, classroom.name AS classroomName, class.status
        FROM class
        INNER JOIN groupp ON class.idGroup = groupp.idGroup
        INNER JOIN employee ON class.idEmployee = employee.idEmployee
        INNER JOIN subject ON class.idSubject = subject.idSubject
        INNER JOIN classroom ON class.idClassroom = classroom.idClassroom
        WHERE class.status = 1";
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
    <title>Lista de Clases</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Lista de Clases</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\Class\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Grupo</th>
                    <th>Profesor</th>
                    <th>Materia</th>
                    <th>Aula</th>

                    
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idClass']}</td>
                            <td>{$row['groupName']}</td>
                            <td>{$row['name']} {$row['lastname']}</td>
                            <td>{$row['subjectName']}</td>
                            <td>{$row['classroomName']}</td>
                 
                            
                            <td>
                                <a class='btn btn-light btn-sm' href='update.php?idClass={$row['idClass']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='delete.php?idClass={$row['idClass']}'>Eliminar</a>
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

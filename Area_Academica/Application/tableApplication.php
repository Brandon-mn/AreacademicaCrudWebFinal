<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$sql = "SELECT * FROM application WHERE status = 1";
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
    <title>Lista De Aplicaciones</title>
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
        <h2>Lista De Aplicaciones</h2>
        <!-- Agregar el enlace para agregar una nueva aplicación -->
        <a class="btn btn btn btn-light" href="\web\Area_Academica\Application\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Solicitante</th>
                    <th>Apellido del Solicitante</th>
                    <th>Género</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Temporal ID</th>
                    <th>Escuela de Origen</th>
                    <th>Fecha de Aplicación</th>
                    <th>Grado</th>
                    <th>Carrera Preferida</th>
                    <th>Segunda Carrera Preferida</th>
                    <th>Tercera Carrera Preferida</th>
                   
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idApplication']}</td>
                            <td>{$row['ApplicantFirstName']}</td>
                            <td>{$row['ApplicantLastName']}</td>
                            <td>{$row['Gender']}</td>
                            <td>{$row['DateOfBirth']}</td>
                            <td>{$row['TemporalID']}</td>
                            <td>{$row['SchoolOfOrigin']}</td>
                            <td>{$row['ApplicationDate']}</td>
                            <td>{$row['Grade']}</td>
                            <td>{$row['PreferredCareer']}</td>
                            <td>{$row['SecondPreferredCareer']}</td>
                            <td>{$row['ThirdPreferredCareer']}</td>
                            
                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Application\update.php?idApplication={$row['idApplication']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Application\delete.php?idApplication={$row['idApplication']}'>Eliminar</a>
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

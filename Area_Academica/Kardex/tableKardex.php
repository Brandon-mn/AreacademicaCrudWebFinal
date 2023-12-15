<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

// Modifica la consulta para seleccionar solo los registros con status 1
$sql = "SELECT * FROM kardex WHERE status = 1";
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
    <title>Lista de Kardex</title>
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
                <a href="#">Opción 1</a>
                <a href="#">Opción 2</a>
                <a href="#">Opción 3</a>
            </nav>
            <label for="btn-menu">✖️</label>
        </div>
    </div>
    <div class="container my-5">
        <h2>Lista de Kardex</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\Kardex\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Grado</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Estudiante</th>
                    <th>Clase</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idKardex']}</td>
                            <td>{$row['grade']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['idStudent']}</td>
                            <td>{$row['idClass']}</td>
                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Kardex\update.php?idKardex={$row['idKardex']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Kardex\delete.php?idKardex={$row['idKardex']}'>Eliminar</a>
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

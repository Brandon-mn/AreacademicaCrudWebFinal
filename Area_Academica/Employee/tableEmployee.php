<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$sql = "SELECT employee.idEmployee, employee.name, employee.lastName, employee.dateOfBirth, employee.gender, 
               employee.address, employee.phoneNumber, employee.email, employee.maritalStatus, 
               employee.hireDate, employee.hasPreviousExperiencie, 
               contract.idContract, position.name AS positionName, application.TemporalID
        FROM employee
        LEFT JOIN contract ON employee.idContract = contract.idContract
        LEFT JOIN position ON employee.idPosition = position.idPosition
        LEFT JOIN application ON employee.idApplication = application.idApplication
        WHERE employee.status = 1";

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
    <title>Lista De Empleados</title>
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
        <h2>Lista De Empleados</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\Employee\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Género</th>
                    <th>Dirección</th>
                    <th>Número de Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Estado Civil</th>
                    <th>Fecha de Contratación</th>
                    <th>Experiencia Prev.</th>
                    <th>ID Contrato</th>
                    <th>Nombre del Cargo</th>
                    <th>Temporal ID</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            
                            <td>{$row['name']}</td>
                            <td>{$row['lastName']}</td>
                            <td>{$row['dateOfBirth']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['address']}</td>
                            <td>{$row['phoneNumber']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['maritalStatus']}</td>
                            <td>{$row['hireDate']}</td>
                            <td>{$row['hasPreviousExperiencie']}</td>
                            <td>{$row['idContract']}</td>
                            <td>{$row['positionName']}</td>
                            <td>{$row['TemporalID']}</td>
                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Employee\update.php?idEmployee={$row['idEmployee']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\Employee\delete.php?idEmployee={$row['idEmployee']}'>Eliminar</a>
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

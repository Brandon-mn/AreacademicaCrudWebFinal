<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "areaacademicabn";
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Fallo de conexión: " . $connection->connect_error);
}

$sql = "SELECT 
            sp.idServicePayment,
            sp.amount,
            sp.paymentDate,
            sp.paymentMethod,
            sp.bank,
            a.TemporalID AS applicationTemporalID,
            s.ServiceName
        FROM servicepayment sp
        INNER JOIN application a ON sp.idApplication = a.idApplication
        INNER JOIN service s ON sp.idService = s.idService
        WHERE sp.status = 1";
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
    <title>Lista De Pagos de Servicios</title>
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
        <h2>Lista De Pagos de Servicios</h2>
        <a class="btn btn btn btn-light" href="\web\Area_Academica\ServicePayment\create.php" role="button"><i class="bi bi-database-fill-add"></i></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Fecha de Pago</th>
                    <th>Método de Pago</th>
                    <th>Banco</th>
                    <th>TemporalID de Aplicación</th>
                    <th>Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['idServicePayment']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['paymentDate']}</td>
                            <td>{$row['paymentMethod']}</td>
                            <td>{$row['bank']}</td>
                            <td>{$row['applicationTemporalID']}</td>
                            <td>{$row['ServiceName']}</td>
                            <td>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\ServicePayment\update.php?idServicePayment={$row['idServicePayment']}'>Modificar</a>
                                <a class='btn btn-light btn-sm' href='\web\Area_Academica\ServicePayment\delete.php?idServicePayment={$row['idServicePayment']}'>Eliminar</a>
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

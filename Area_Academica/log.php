<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "areaacademicabn";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = :correo AND clave = :clave");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Inicio de sesión exitoso";
        header("Location:Menu/index.html"); 

    } else {
        echo "Credenciales de inicio de sesión incorrectas";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

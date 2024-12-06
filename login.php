<?php
// Conexión a la base de datos MySQL
$host = 'localhost';
$db = 'login_system';
$user = 'root';  // Cambia este valor según tu configuración
$pass = '123456';      // Cambia este valor según tu configuración

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener valores del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL vulnerable a inyección SQL
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado
        echo "¡Bienvenido, " . $username . "! Su saldo actual es de $369,254.°°";
    } else {
        // Usuario o contraseña incorrectos
        echo "Usuario o contraseña incorrectos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Vulnerable a SQL Injection</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="post" action="login.php">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
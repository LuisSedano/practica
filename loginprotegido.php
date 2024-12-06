<?php
// Conexión a la base de datos MySQL
$host = 'localhost';
$db = 'login_system';
$user = 'root';  // Cambia este valor si tienes una contraseña o usuario diferentes en tu configuración
$pass = '123456';      // Si usas XAMPP o WAMP, normalmente la contraseña es vacía

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

    // Preparar la consulta SQL para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
    
    // Vincular los parámetros (las entradas del usuario) a la consulta preparada
    $stmt->bind_param("ss", $username, $password);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados de la consulta
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado
        echo "¡Bienvenido, " . $username . "!  Eres millonetas";
    } else {
        // Usuario o contraseña incorrectos
        echo "Usuario o contraseña incorrectos.";
    }

    // Cerrar la declaración preparada
    $stmt->close();
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
    <form method="post" action="loginprotegido.php">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
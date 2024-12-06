<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = "123456";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario 
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta para validar el usuario
$sql = "SELECT * FROM usuarios WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($sql);

// Verifica si la consulta se preparó correctamente
if (!$stmt) {
    die("Error en la consulta preparada: " . $conn->error);
}

// Vincula el parámetro (s es para string)
$stmt->bind_param("s", $username);

// Ejecuta la consulta
$stmt->execute();
$result = $stmt->get_result();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Compara la contraseña
    if ($user['password'] === $password) {
        if ($user['role'] === 'admin') {
            echo "<h2>Bienvenido, Admin " . $user['username'] . "!</h2>";
            echo "<p>Aquí está la información exclusiva para administradores.</p>";
        } else {
            echo "<h2>Bienvenido, " . $user['username'] . "!</h2>";
            echo "<p>Aquí está la información para usuarios normales.</p>";
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

// Cierra la consulta y la conexión
$stmt->close();
$conn->close();
?>

<?php

session_start();
// conexion
require_once "conexionSQL.php";
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

// datos obtenidos del formulario
$correoUsuario = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];

if (!isset($_POST['correo'], $_POST['contrasenia'])) {
    die("Faltan datos del formulario.");
}

try {
    // prepara el query completo
    $qry = ("SELECT Id_Credencial, Id_Usuario, Correo, Contrasenia 
            FROM InicioSesion
            WHERE Correo = :correo
            AND Contrasenia = :contrasenia");
    $stmt = $conn->prepare($qry);
    $stmt->bindParam(":correo", $correoUsuario, PDO::PARAM_STR);
    $stmt->bindParam(":contrasenia", $contrasenia, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<pre>";
        print_r($user); // Muestra el array con los datos del usuario
        echo "</pre>";
        $_SESSION['Id_Usuario'] = $user['Id_Usuario'];
        header("Location: http://localhost/index.php");
        exit;
    } else {
        echo "Usuario no encontrado.";
        header("Location: http://localhost/login.html");
        exit;
    }

    
} catch (PDOException $e) {
    // error en cuanlquier caso
    echo "Error: " . $e->getMessage();
}

// cerrar conexion
$conexion->cerrar();
?>
<?php

// conexion
require_once "ConexionSQL.php";
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

// datos obtenidos del formulario
$usuario = $_POST['usuario'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$primerApellido = $_POST['primerApellido'] ?? null;
$segundoApellido = $_POST['segundoApellido'] ?? null;
$correoUsuario = $_POST['correo'] ?? null;
$contrasenia = $_POST['contrasenia'] ?? null;
$fechaNacimiento = $_POST['fechaNacimiento'] ?? null;

// imagen
$imagen = $_FILES['imagen'] ?? null;
$rutaDestino = "../uploads/usuarios/";

if (isset($imagen) && $imagen['error'] === UPLOAD_ERR_OK) {
    $nombreTemp = $imagen['tmp_name'];
    $nombreFinal = uniqid() . "_" . basename($imagen['name']);
    $rutaCompleta = $rutaDestino . '/' . $nombreFinal;

    if (!move_uploaded_file($nombreTemp, $rutaCompleta)) {
        echo "Error al mover la imagen al servidor.";
        exit;
    }
} else {
    $rutaCompleta = "";
}

if (
    empty($usuario) || empty($nombre) || empty($primerApellido) ||
    empty($segundoApellido) || empty($correoUsuario) ||
    empty($contrasenia) || empty($fechaNacimiento) ||
    !isset($imagen) || $imagen['error'] !== UPLOAD_ERR_OK
){
    exit;
}

try {
    // Iniciar transacción
    $conn->beginTransaction();

    // 1. Insertar en Usuario
    $qryUsuario = "INSERT INTO Usuario (NombreUsuario, Nombre, PrimerApellido, SegundoApellido, FechaNacimiento)
                   VALUES (:usuario, :nombre, :primerApellido, :segundoApellido, :fechaNacimiento)";
    $stmtUsuario = $conn->prepare($qryUsuario);
    $stmtUsuario->bindParam(':usuario', $usuario);
    $stmtUsuario->bindParam(':nombre', $nombre);
    $stmtUsuario->bindParam(':primerApellido', $primerApellido);
    $stmtUsuario->bindParam(':segundoApellido', $segundoApellido);
    $stmtUsuario->bindParam(':fechaNacimiento', $fechaNacimiento);
    $stmtUsuario->execute();

    // Obtener el ID del usuario insertado
    $idUsuario = $conn->lastInsertId();

    // 2. Insertar en Login
    $qryLogin = "INSERT INTO InicioSesion (Id_Usuario, Correo, Contrasenia)
                 VALUES (:idUsuario, :correo, :contrasenia)";
    $stmtLogin = $conn->prepare($qryLogin);
    $stmtLogin->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtLogin->bindParam(':correo', $correoUsuario);
    $stmtLogin->bindParam(':contrasenia', $contrasenia);
    $stmtLogin->execute();

    // 3. Insertar la imagen
    $qryImagen = "INSERT INTO ImagenUsuario (Id_Usuario, rutaImagen)
                  VALUES (:idUsuario, :rutaCompleta)";
    $stmtImagen = $conn->prepare($qryImagen);
    $stmtImagen->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtImagen->bindParam(':rutaCompleta', $rutaCompleta);
    $stmtImagen->execute();

    $conn->commit();

    header("Location: ../login.html");
    exit;    
} catch (PDOException $e) {
    // error en cuanlquier caso
    echo "Error: " . $e->getMessage();
}

// cerrar conexion
$conexion->cerrar();
?>
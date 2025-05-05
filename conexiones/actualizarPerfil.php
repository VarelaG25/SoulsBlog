<?php

session_start();
require_once 'conexionSQL.php';
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

// Variables
$usuario = $_POST['usuario'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellidoPaterno = $_POST['apellidoPaterno'] ?? '';
$apellidoMaterno = $_POST['apellidoMaterno'] ?? '';
$correo = $_POST['correo'] ?? '';
$fechaNacimiento = $_POST['fechaNacimiento'] ?? '';

$imagen = $_FILES['imagen'] ?? null;
$rutaDestino = "../uploads/usuarios/";
$rutaCompleta = "";

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

if ($_POST['contrasenia'] !== $_POST['confirmarContrasenia']) {
    header("Location: ../perfil.php");
    exit;
}

$idUsuario = $_SESSION['Id_Usuario'] ?? null;

try {

    $conn->beginTransaction();
    $qryUsuario =  "UPDATE Usuario
                    SET NombreUsuario = :usuario,
	                    Nombre = :nombre,
	                    PrimerApellido = :apellidoPaterno,
	                    SegundoApellido = :apellidoMaterno,
	                    FechaNacimiento = :fechaNacimiento
                    WHERE Id_Usuario = :idUsuario";
    $stmtUsuario = $conn->prepare($qryUsuario);
    $stmtUsuario->bindParam(':usuario', $usuario);
    $stmtUsuario->bindParam(':nombre', $nombre);
    $stmtUsuario->bindParam(':apellidoPaterno', $apellidoPaterno);
    $stmtUsuario->bindParam(':apellidoMaterno', $apellidoMaterno);
    $stmtUsuario->bindParam(':fechaNacimiento', $fechaNacimiento);
    $stmtUsuario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtUsuario->execute();

    $qryLogin = "UPDATE InicioSesion
                 SET Correo = :correo
                 WHERE Id_Usuario = :idUsuario";
    $stmtLogin = $conn->prepare($qryLogin);
    $stmtLogin->bindParam(':correo', $correo);
    $stmtLogin->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtLogin->execute();

    if($rutaCompleta !== ""){
    $qryImagen = "UPDATE ImagenUsuario
                      SET rutaImagen = :rutaCompleta
                      WHERE Id_Usuario = :idUsuario";
    $stmtImagen = $conn->prepare($qryImagen);
    $stmtImagen->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmtImagen->bindParam(":rutaCompleta", $rutaCompleta);
    $stmtImagen->execute();
    }
    $conn->commit();
    header("Location: ../perfil.php");
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conexion->cerrar();

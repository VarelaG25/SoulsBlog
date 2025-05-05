<?php

session_start();
// conexion
require_once "ConexionSQL.php";
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

// datos obtenidos del formulario
$titulo = $_POST['titulo'] ?? null;
$comboboxJuego = $_POST['comboboxJuego'] ?? null;
$subtitulo = $_POST['subtitulo'] ?? null;
$comboboxCategoria = $_POST['comboboxCategoria'] ?? null;
$autor = $_POST['autor'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$imagen = $_FILES['imagen'] ?? null;
$rutaDestino = "../uploads/post/";
$rutaCompleta = "";

$idUsuario = $_SESSION['Id_Usuario'];

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
    empty($titulo) || empty($comboboxJuego) || empty($subtitulo) ||
    empty($comboboxCategoria) || empty($autor) || empty($fecha) ||
    empty($descripcion)
){
    echo "Todos los campos son obligatorios.";
    exit;
}

try {
    // Iniciar transacción
    $conn->beginTransaction();

    $qryPost = "INSERT INTO Post (Id_Usuario, Id_Categoria, Id_Juego, Titulo, Subtitulo, Fecha, Descripcion)
                VALUES (:id, :id_categoria, :id_juego, :titulo, :subtitulo, :fecha, :descripcion)";
    $stmtPost = $conn->prepare($qryPost);
    $stmtPost->bindParam(":id", $idUsuario, PDO::PARAM_INT);
    $stmtPost->bindParam(":id_categoria", $comboboxCategoria, PDO::PARAM_INT);
    $stmtPost->bindParam(":id_juego", $comboboxJuego, PDO::PARAM_INT);
    $stmtPost->bindParam(":titulo", $titulo);
    $stmtPost->bindParam(":subtitulo", $subtitulo);
    $stmtPost->bindParam(":fecha", $fecha);
    $stmtPost->bindParam(":descripcion", $descripcion);
    $stmtPost->execute();

    // Obtener el ID del usuario insertado
    $idPost = $conn->lastInsertId();

    $qryImagen = "INSERT INTO Imagen (Id_Post, rutaImagen)
                  VALUES (:idPost, :rutaCompleta)";
    $stmtImagen = $conn->prepare($qryImagen);
    $stmtImagen->bindParam(':idPost', $idPost, PDO::PARAM_INT);
    $stmtImagen->bindParam(':rutaCompleta', $rutaCompleta);
    $stmtImagen->execute();

    $conn->commit();

    header("Location: http://localhost/index.php");
    exit;    
} catch (PDOException $e) {
    // error en cuanlquier caso
    echo "Error: " . $e->getMessage();
}

// cerrar conexion
$conexion->cerrar();
?>
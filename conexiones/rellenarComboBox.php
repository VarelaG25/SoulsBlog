<?php
require_once "ConexionSQL.php";
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

try {
    // obtener datos una sola vez
    $stmtCat = $conn->prepare("SELECT Id_Categoria, nombreCategoria FROM Categoria");
    $stmtCat->execute();
    $categoria = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

    $stmtJue = $conn->prepare("SELECT Id_Juego, nombreJuego FROM Juego");
    $stmtJue->execute();
    $juego = $stmtJue->fetchAll(PDO::FETCH_ASSOC);

    function imprimirCategorias($categoria)
    {
        foreach ($categoria as $row) {
            echo "<option value='" . $row['Id_Categoria'] . "'>" . htmlspecialchars($row['nombreCategoria']) . "</option>";
        }
    }

    function imprimirJuegos($juego)
    {
        foreach ($juego as $row) {
            echo "<option value='" . $row['Id_Juego'] . "'>" . htmlspecialchars($row['nombreJuego']) . "</option>";
        }
    }
} catch (PDOException $e) {
    // error en cuanlquier caso
    echo "Error: " . $e->getMessage();
}


// compartir variables globales
$GLOBALS['categoria'] = $categoria;
$GLOBALS['juego'] = $juego;

$conexion->cerrar();
?>
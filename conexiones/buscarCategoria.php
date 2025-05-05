<?php

session_start();
// conexion
require_once "conexionSQL.php";
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

$comboboxCategoria = ['comboboxCategoria'] ?? NULL;

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


    
} catch (PDOException $e) {
    // error en cuanlquier caso
    echo "Error: " . $e->getMessage();
}

// cerrar conexion
$conexion->cerrar();
?>
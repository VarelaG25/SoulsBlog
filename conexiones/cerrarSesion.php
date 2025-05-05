<?php
    session_start();
    $IdUsuario = $_SESSION['Id_Usuario'] ?? NULL;

    try{
        if ($IdUsuario) {
            session_destroy();
            header("Location: http://localhost/index.php");
        } 
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

    $conexion->cerrar();
?>
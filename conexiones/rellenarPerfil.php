<?php
function obtenerUsuario($idUsuario)
{
    require_once "conexionSQL.php";
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    try {

        $qry = 'SELECT *
                FROM Usuario U
                INNER JOIN InicioSesion I ON U.Id_Usuario = I.Id_Usuario
                LEFT JOIN ImagenUsuario O ON U.Id_Usuario = O.Id_Usuario
                WHERE U.Id_Usuario = :id';
        $stmt = $conn->prepare($qry);
        $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario;
    } catch (PDOException $e) {
        return NULL;
        echo "Error: " . $e->getMessage();
    }
}
?>
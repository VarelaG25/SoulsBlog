<?php

require_once 'conexionSQL.php';
$conexion = new ConexionSQL();
$conn = $conexion->conectar();

try{

    $qry = "SELECT *
            FROM Post P
            INNER JOIN Usuario U ON P.Id_Usuario = U.Id_Usuario
            INNER JOIN Imagen I ON P.Id_Post = I.Id_Post
            INNER JOIN Categoria C ON P.Id_Categoria = C.Id_Categoria
            INNER JOIN Juego J ON P.Id_Juego = J.Id_Juego
            WHERE P.Id_Post = I.Id_Post
            AND P.Id_Post = :id;";
    
    $stmt = $conn->prepare($qry);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $posts = $stmt->fetch(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

$conexion->cerrar();

?>
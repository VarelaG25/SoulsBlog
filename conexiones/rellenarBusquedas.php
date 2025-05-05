<?php
function mostrarPosts($pagina = 1, $porPagina = 4, $query = '')
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    $inicio = ($pagina - 1) * $porPagina;

    try {
        if ($query === '') {
            // Si no hay búsqueda, mostrar todos los posts
            $sql = "SELECT * 
                    FROM Post P
                    INNER JOIN Imagen I ON P.Id_Post = I.Id_Post
                    ORDER BY Fecha DESC 
                    OFFSET :inicio ROWS 
                    FETCH NEXT :cantidad ROWS ONLY";
        } else {
            // Si hay búsqueda, filtrar por título
            $sql = "SELECT * 
                    FROM Post P
                    INNER JOIN Imagen I ON P.Id_Post = I.Id_Post
                    WHERE P.Titulo LIKE :query
                    ORDER BY Fecha DESC 
                    OFFSET :inicio ROWS 
                    FETCH NEXT :cantidad ROWS ONLY";
        }

        $stmt = $conn->prepare($sql);

        // Si hay búsqueda, añadimos el término de búsqueda
        if ($query !== '') {
            $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($posts) {
            foreach ($posts as $post) {
                echo "<div class='fila'>";
                echo "<div class='columna width100'>";
                echo "<a class='enlace-primario' href='article.php?id=" . htmlspecialchars($post['Id_Post']) . "'>" . htmlspecialchars($post['Titulo']) . "</a>";
                echo "<p>" . htmlspecialchars($post['Subtitulo']) . "</p>";
                echo "<p>" . htmlspecialchars(substr($post['Descripcion'], 0, 60)) . "...</p>";
                echo "</div>";
                echo "<div class='columna bordeDorado'>";
                if (!empty($post['rutaImagen'])) {
                    echo "<img id='preview' class='imagenBusqueda' src='" . htmlspecialchars($post['rutaImagen']) . "' alt='Vista previa'>";
                } else {
                    echo "<img class='imagenBusqueda' src='img/espada.webp' alt='Sin imagen'>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='centerFlex'>No se encontraron resultados para la búsqueda.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al obtener publicaciones: " . $e->getMessage() . "</p>";
    }

    $conexion->cerrar();
}

function mostrarPaginacion($pagina = 1, $porPagina = 4)
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    try {
        $totalQuery = $conn->query("SELECT COUNT(*) FROM Post");
        $totalPosts = (int)$totalQuery->fetchColumn();

        if ($pagina > 1) {
            echo "<div class='columna width100'>";
            echo "<a class='boton textoCentrado' href='?pagina=" . ($pagina - 1) . "'>Anterior</a>";
            echo "</div>";
        } else {
            echo "<div class='columna width100'>";
            echo "<a class='boton textoCentrado' href=''>Anterior</a>";
            echo "</div>";
        }
        if (($pagina * $porPagina) < $totalPosts) {
            echo "<div class='columna width100'>";
            echo "<a class='boton textoCentrado' href='?pagina=" . ($pagina + 1) . "'>Siguiente</a>";
            echo "</div>";
        } else {
            echo "<div class='columna width100'>";
            echo "<a class='boton textoCentrado' href=''>Siguiente</a>";
            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "<p>Error en la paginación: " . $e->getMessage() . "</p>";
    }

    $conexion->cerrar();
}

function mostrarPostsSinImagen($pagina = 1, $porPagina = 4)
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    $inicio = ($pagina - 1) * $porPagina;

    try {
        // Consulta para obtener todos los posts
        $sql = "SELECT * 
                FROM Post P
                ORDER BY Fecha DESC 
                OFFSET :inicio ROWS 
                FETCH NEXT :cantidad ROWS ONLY";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul class='elementos fondoGrisOscuro'>";
        if ($posts) {
            foreach ($posts as $post) {
                echo "<li class='fondoGrisOscuro'>";
                echo "<a class='enlace-secundario fondoGrisOscuro' href='article.php?id=" . htmlspecialchars($post['Id_Post']) . "'>" . htmlspecialchars($post['Titulo']) . "</a>";
                echo "<p class='fondoGrisOscuro'>" . htmlspecialchars($post['Subtitulo']) . "</p>";
                echo "<p class='fondoGrisOscuro'>" . substr(htmlspecialchars($post['Descripcion']), 0, 50) . "...</p>";
                echo "</li>";
            }
        } else {
            echo "<p class = 'fondoGrisOscuro centerFlex'>No se encontraron publicaciones.</p>";
        }
        echo "</ul>";
    } catch (PDOException $e) {
        echo "<p>Error al obtener publicaciones: " . $e->getMessage() . "</p>";
    }

    $conexion->cerrar();
}



function ultimosPostPaginacion($pagina = 1, $porPagina = 4)
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    try {
        $totalQuery = $conn->query("SELECT COUNT(*) FROM Post");
        $totalPosts = (int)$totalQuery->fetchColumn();

        if ($pagina > 1) {
            echo "<div class='columna centrado-Items width100'>";
            echo "<a class='enlace-secundario' href='href='?pagina=" . ($pagina - 1) . ">Anterior</a>";
            echo "</div>";
        } else {
            echo "<div class='columna centrado-Items width100'>";
            echo "<a class='enlace-secundario' href=''>Anterior</a>";
            echo "</div>";
        }
        if (($pagina * $porPagina) < $totalPosts) {
            echo "<div class='columna centrado-Items width100'>";
            echo "<a class='enlace-secundario' href='href='?pagina=" . ($pagina - 1) . ">Siguiente</a>";
            echo "</div>";
        } else {
            echo "<div class='columna centrado-Items width100'>";
            echo "<a class='enlace-secundario' href=''>Siguiente</a>";
            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "<p>Error en la paginación: " . $e->getMessage() . "</p>";
    }

    $conexion->cerrar();
}

function mostrarPostsSugerencia($pagina = 1, $porPagina = 1)
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();
    $inicio = ($pagina - 1) * $porPagina;

    try {
        $sql = "SELECT P.Titulo, P.Subtitulo, P.Fecha, P.Descripcion, I.rutaImagen, J.nombreJuego, C.nombreCategoria
                FROM Post P
                INNER JOIN Imagen I ON P.Id_Post = I.Id_Post
                INNER JOIN Categoria C ON P.Id_Categoria = C.Id_Categoria
                INNER JOIN Juego J ON P.Id_Juego = J.Id_Juego
                ORDER BY Fecha DESC
                OFFSET :inicio ROWS
                FETCH NEXT :cantidad ROWS ONLY";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':inicio',   $inicio,      PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $porPagina,   PDO::PARAM_INT);
        $stmt->execute();

        if ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Aquí imprimes TODO el bloque
            echo "<div class='columna fondoGrisOscuro width100'>";
            echo "<h3 class='fondoGrisOscuro'>" . htmlspecialchars($post['Titulo'])     . "</h3>";
            echo "<h4 class='fondoGrisOscuro'>" . htmlspecialchars($post['Subtitulo'])  . "</h4>";
            echo "<h5 class='fondoGrisOscuro'>" . htmlspecialchars($post['Fecha'])      . "</h5>";
            echo "<br>";
            echo "<span class='fondoGrisOscuro'>"
                . htmlspecialchars(substr($post['Descripcion'], 0, 250))
                . "...</span>";
            echo "</div>";
            echo "<div class='columna fondoGrisOscuro soloFlex centrado-Items width100'>";
            echo "<img class='bordeBlanco imagenSugerencia fondoGrisOscuro' "
                . "src='" . htmlspecialchars($post['rutaImagen']) . "' alt='articulo'>";
            echo "<h4 class = 'fondoGrisOscuro'>" . htmlspecialchars($post['nombreJuego']) . "<h4>";
            echo "<h5 class = 'fondoGrisOscuro'>" . htmlspecialchars($post['nombreCategoria']) . "<h5>";
            echo "</div>";
        } else {
            echo "<p class = 'fondoGrisOscuro centerFlex'>No hay sugerencias disponibles.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al obtener sugerencias: " . $e->getMessage() . "</p>";
    }

    $conexion->cerrar();
}

function sugerenciasPaginacion($sugPage = 1, $porPagina = 1)
{
    require_once 'conexiones/conexionSQL.php';
    $conexion = new ConexionSQL();
    $conn = $conexion->conectar();

    $total = (int)$conn->query("SELECT COUNT(*) FROM Post")->fetchColumn();

    // Anterior
    if ($sugPage > 1) {
        $ant = $sugPage - 1;
        echo "<div class='columna centrado-Items width100'>";
        echo "<a class='enlace-secundario' href='?sugpage=$ant'>Anterior</a>";
        echo "</div>";
    } else {
        echo "<div class='columna centrado-Items width100'>";
        echo "<a class='enlace-secundario deshabilitado' href=''>Anterior</a>";
        echo "</div>";
    }

    // Siguiente
    if ($sugPage * $porPagina < $total) {
        $sig = $sugPage + 1;
        echo "<div class='columna centrado-Items width100'>";
        echo "<a class='enlace-secundario' href='?sugpage=$sig'>Siguiente</a>";
        echo "</div>";
    } else {
        echo "<div class='columna centrado-Items width100'>";
        echo "<a class='enlace-secundario deshabilitado' href=''>Siguiente</a>";
        echo "</div>";
    }

    $conexion->cerrar();
}

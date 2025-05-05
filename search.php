<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7aadadae08.js"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Alice&display=swap" rel="stylesheet">
    <title>Busqueda</title>
    <link href="style.css" rel="stylesheet">
</head>

<?php
session_start();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
?>

<body>
    <div class="contenedor-Busqueda">
        <div class="b1">
            <div class="fila">
                <div class="columna centerFlex width100">
                    <div class="contenido">
                        <img alt="granRuna" class="imagenNavBar" src="img/granRuna.webp">
                        <span>Souls Blog</span>
                    </div>
                </div>
                <div class="columna soloFlex width100">
                    <ul class="navegacion centrado-Items">
                        <li><a class="enlace-secundario sinSubrayado" href="index.php">Inicio</a></li>
                        <li class="contenedor-Campo soloFlex centrado-Items">
                            <form style="background-color: transparent;" method="get" action="search.php">
                                <div class="contenedor-Campo soloFlex centrado-Items">
                                    <input class="campo-Texto" id="searchbar-2" name="query" placeholder="Buscar..." type="text" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                                    <button type="submit" class="boton-buscar">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                        <?php
							if (isset($_SESSION['Id_Usuario']))
							{
								echo "<li><a class='enlace-secundario sinSubrayado' href='publish.php'>Publicar</a></li>";
							}else{
								echo "<li><a class='enlace-secundario sinSubrayado' href='login.html'>Publicar</a></li>";
							}
						?>
                    </ul>
                </div>
                <div class="columna soloFlex width100">
                    <div class="fila centrado-Items">
                        <div id="contenedorRegistro" class="columna alineadoDerecha width50">
                            <input id="btnRegistro" class="boton-secundario width75" type="button" value="Registrarse"
                                onclick="window.location.href='register.html'">
                        </div>
                        <div id="contenedorLogin" class="columna centrado-Items width50">
                            <input id="btnLogin" class="boton width75" type="button" value="Iniciar Sesion"
                                onclick="window.location.href='login.html'">
                        </div>
                        <div id="contenedorSalir" class="columna alineadoDerecha width50">
                            <input id="btnSalir" class="boton-secundario width75" type="button" value="Salir"
                                onclick="confirmarSalir()">
                        </div>
                        <div id="contenedorPerfil" class="columna centrado-Items width50">
                            <input id="btnPerfil" class="boton width75" type="button" value="Perfil"
                                onclick="window.location.href='perfil.php'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="b2">
            <div class="columna width100 padding2">
                <div class="fila filaBusqueda">
                    <div class="columna">
                        <div class="centrar filaFlex">
                            <h1>Resultado de la búsqueda:</h1>
                            <h2><?php echo htmlspecialchars($query);?></h2>
                        </div>
                    </div>
                </div>
                <div class="fila width50 filaFiltros gap-md marginTop1">
                    <?php
                    require_once 'conexiones/rellenarBusquedas.php';
                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    mostrarPaginacion($pagina);
                    ?>
                    <div class="columna width100">
                        <select class="contenedor-Campo campo-Texto" name="comboboxCategoria" id="categoria">
                            <?php
                            include 'conexiones/rellenarComboBox.php';
                            imprimirCategorias($categoria);
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="b3 height100">
            <div class="busquedaPrincipal">
                <div class="b3-1 width100">
                    <div class="contenedorBusqueda margin2">
                        <?php
                        require_once 'conexiones/rellenarBusquedas.php';
                        mostrarPosts($pagina, 4, $query);
                        ?>
                    </div>
                </div>
                <div class="b3-2">
                    <div class="fila">
                        <div class="columna centerFlex">
                            <img class="imagen-Busqueda" src="img/cartaWorld.webp" alt="The world">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-Global">
            <p class="footer">Varela´s Web ©</p>
        </div>
    </div>
    <script src="scripts/navBar.js"></script>
    <script src="scripts/cargarImagen.js"></script>
    <?php
    if (isset($_SESSION['Id_Usuario'])) {
        echo "<script>mostrarSoloSesionActiva();</script>";
    } else {
        echo "<script>mostrarSoloSesionInactiva();</script>";
    }
    ?>
</body>

</html>
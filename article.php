<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7aadadae08.js"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Alice&display=swap" rel="stylesheet">
    <title>Articulo</title>
    <link href="style.css" rel="stylesheet">
</head>

<?php 
session_start();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
require_once 'conexiones/rellenarArtiulo.php';
?>

<body>
    <div class="contenedor-Articulo">
        <div class="a1">
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
                                        <i class="fa-solid fa-magnifying-glass" style="color: black; background-color: white;"></i>
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
        <div class="a2">
            <div class="fila">
                <div class="columna">
                    <h1>Articulo</h1>
                </div>
            </div>
        </div>
        <div class="a3">
            <div class="articuloPrincipal">
                <div class="a3-1 centerFlex">
                    <div class="columna centerFlex">
                        <img class="imagen-Lateral" src="img/cartaHierophant.webp" alt="Hierophant">
                    </div>
                </div>
                <div class="a3-2 bordeBlanco">
                    <div class="articuloInformacion">
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" for="autor">Autor:</label>
                            <label class="fondoGrisOscuro" for="autor"><?php echo htmlspecialchars($posts['NombreUsuario'])?></label>
                        </div>
                        <div class="campo centerFlex bordeDorado" style="grid-row: span 2;">
                            <img class="imagenCargar" id="preview" src="<?php echo htmlspecialchars($posts['rutaImagen']); ?>" alt="Vista previa"
                                style="visibility: visible;">
                        </div>
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" for="juego">Juego:</label>
                            <label class="fondoGrisOscuro" for="juego"><?php echo htmlspecialchars($posts['nombreJuego'])?></label>
                        </div>
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" for="fecha">Fecha:</label>
                            <label class="fondoGrisOscuro" for="fecha"><?php echo htmlspecialchars($posts['Fecha'])?></label>
                        </div>
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" for="categoria">Categoría:</label>
                            <label class="fondoGrisOscuro" for="categoria"><?php echo htmlspecialchars($posts['nombreCategoria'])?></label>
                        </div>
                        <div class="campo centerFlex"></div>
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" style="text-decoration: underline;" for="titulo"><?php echo htmlspecialchars($posts['Titulo'])?></label>
                        </div>
                        <div class="campo centerFlex"></div>
                        <div class="campo centerFlex"></div>
                        <div class="campo centerFlex">
                            <label class="fondoGrisOscuro" for="subtitulo"><?php echo htmlspecialchars($posts['Subtitulo'])?></label>
                        </div>
                        <div class="campo centerFlex"></div>
                        <div class="campo centerFlex"></div>
                        <div class="campo centerFlex descripcion" style="grid-column: span 3;">
                            <label class="fondoGrisOscuro" for="descripcion">Descripción:</label>
                            <br>
                            <p class="fondoGrisOscuro">
                            <?php echo nl2br(htmlspecialchars($posts['Descripcion'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="a3-3 centerFlex">
                    <div class="columna centerFlex">
                        <img class="imagen-Lateral" src="img/cartaEmpress.webp" alt="Hierophant">
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-Global">
            <p class="footer">Varela´s Web ©</p>
        </div>
    </div>
    <script src="scripts/publish.js"></script>
    <script src="scripts/navBar.js"></script>
    <?php
    if (isset($_SESSION['Id_Usuario'])) {
        echo "<script>mostrarSoloSesionActiva();</script>";
    } else {
        echo "<script>mostrarSoloSesionInactiva();</script>";
    }
    ?>
</body>

</html>
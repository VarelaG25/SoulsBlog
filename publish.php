<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7aadadae08.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alice&display=swap" rel="stylesheet">
    <title>Publicar</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
session_start();
require_once 'conexiones/rellenarPerfil.php';
$IdUsuario = $_SESSION['Id_Usuario'] ?? NULL;

if ($IdUsuario) {
    $usuario = obtenerUsuario($IdUsuario);
}
$query = isset($_GET['query']) ? $_GET['query'] : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
?>

<body>
    <div class="contenedor-Publicacion">
        <div class="p1">
            <nav class="nav-Inicio">
                <div class="contenedor-LogoInicio">
                    <img class="logoInicio" src="img/granRuna.webp" alt="granRuna">
                    <p class="inicio-Texto">Souls Blog</p>
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
                    <a class="nav-TextoInicio" href="publish.html">Publicar</a>
                </div>
                <div class="contenedor-LoginInicio">
                    <a class="botonInicioSesion" href="login.html">
                        <i class="fa-solid fa-circle-user" style="color: #ffff; background-color: transparent;"></i>
                        <span class="iniciarSesionBoton" style="background-color: transparent;">Iniciar sesión</span>
                    </a>
                </div>
            </nav>
        </div>
        <div class="p2">
            <h1 class="c2">Publicar articulo</h1>
        </div>
        <div class="p3">
            <div class="contenedor-Publicar">
                <div class="p3-1">
                    <img class="imagen-Lateral" src="img/cartaHierophant.webp" alt="Hierophant">
                </div>
                <div class="p3-2 bordeDorado">
                    <form class="formulario-grid" action="conexiones/publicar.php" method="POST" enctype="multipart/form-data">
                        <div class="campo">
                            <label class="label-campo" for="titulo">Título:</label>
                            <input class="input-campo" type="text" name="titulo" id="titulo">
                        </div>
        
                        <!-- Juego -->
                        <div class="campo">
                            <label class="fondoGrisOscuro" for="juego">Juego:</label>
                            <select class="contenedor-Campo campo-Texto" name="comboboxJuego" id="juego">
                                <?php
                                include 'conexiones/rellenarComboBox.php';
                                imprimirJuegos($juego);
                                ?>
                            </select>
                        </div>
                        <div class="campo imagen bordeBlanco" style="grid-row: span 2;">
                            <img class="imagenCargar" id="preview" src="img/espada.webp" alt="Vista previa" style="visibility: visible;">
                        </div>
        
                        <!-- Subtítulo -->
                        <div class="campo">
                            <label class="label-campo" for="subtitulo">Subtítulo:</label>
                            <input class="input-campo" type="text" name="subtitulo" id="subtitulo">
                        </div>
        
                        <!-- Categoría -->
                        <div class="campo">
                            <label class="fondoGrisOscuro" for="categoria">Categoría:</label>
                            <select class="contenedor-Campo campo-Texto" name="comboboxCategoria" id="categoria">
                                <?php
                                imprimirCategorias($categoria);
                                ?>
                            </select>
                        </div>
        
                        <!-- Autor -->
                        <div class="campo">
                            <label class="fondoGrisOscuro" for="autor">Autor:</label>
                            <input value="<?php echo htmlspecialchars($usuario['NombreUsuario']) ?>" class="contenedor-Campo campo-Texto" type="text" name="autor" id="autor" readonly>
                        </div>
                        
                        <!-- Fecha -->
                        <div class="campo">
                            <label class="fondoGrisOscuro" for="fecha">Fecha:</label>
                            <input class="contenedor-Campo campo-Texto" value="actualizarFecha()" type="date" name="fecha" id="fecha" readonly>
                        </div>
                        <div class="campo centerFlex">
                            <p id="nombreArchivo" class="fondoGrisOscuro">Sin archivo seleccionado</p>
                            <input name="imagen" type="file" id="cargarImagen" accept="image/*" class="input-file">
                            <label for="cargarImagen" class="boton-secundario centerFlex width100">Cargar Imagen</label>
                        </div>
                        <!-- Vacío para alinear grid -->
                        <div class="campo"></div>
        
                        <!-- Descripción -->
                        <div class="campo descripcion" style="grid-column: span 3;">
                            <label class="label-campo" for="descripcion">Descripción:</label>
                            <textarea class="input-campo descripcion-area" name="descripcion" id="descripcion" rows="5"></textarea>
                        </div>
        
                        <!-- Botón Publicar -->
                        <div class="campo boton-publicar" style="grid-column: span 3;">
                            <input class="boton" type="submit" value="Publicar">
                        </div>
                    </form>
                </div>
                <div class="p3-3">
                    <img class="imagen-Lateral" src="img/cartaEmpress.webp" alt="Empress">
                </div>
            </div>
        </div>
        <div class="div3">
            <p class="footer">Varela´s Web ©</p>
        </div>
    </div>
    <script src="scripts/cargarImagen.js"></script>
    <script>
        // Obtener el input
        const inputFecha = document.getElementById('fecha');

        // Obtener la fecha actual en formato YYYY-MM-DD
        const hoy = new Date().toISOString().split('T')[0];

        // Establecerla como valor del input
        inputFecha.value = hoy;
    </script>
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
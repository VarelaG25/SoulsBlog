<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<script src="https://kit.fontawesome.com/7aadadae08.js"></script>
	<link href="https://fonts.googleapis.com" rel="preconnect">
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css2?family=Alice&display=swap" rel="stylesheet">
	<title>Inicio</title>
	<link href="style.css" rel="stylesheet">
</head>

<?php
session_start();
require_once 'conexiones/rellenarBusquedas.php';
$query = isset($_GET['query']) ? $_GET['query'] : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$sugPage = isset($_GET['sugpage']) ? (int)$_GET['sugpage'] : 1;
?>

<body>
	<div class="contenedor-Inicio">
		<div class="i1">
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
						if (isset($_SESSION['Id_Usuario'])) {
							echo "<li><a class='enlace-secundario sinSubrayado' href='publish.php'>Publicar</a></li>";
						} else {
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
				<div class="div2_3">
					<h2 class="subtitulo">Ultimos posts</h2><br>
					<div class="lastPost">
						<div class="post">
							<a class="enlace" href="article.html">¿Por qué es tan difícil el juego?</a>
							<p class="colorTexto">En este artículo analizaremos la dificultad de los juegos de FromSoftware y su impacto en la comunidad.</p>
						</div>
						<div class="post">
							<a class="enlace" href="article.html">Lore de Elden Ring</a>
							<p class="colorTexto">Un vistazo profundo al lore de Elden Ring y sus personajes.</p>
						</div>
						<div class="post">
							<a class="enlace" href="article.html">Guía de Elden Ring</a>
							<p class="colorTexto">Consejos y trucos para sobrevivir en el mundo de Elden Ring.</p>
						</div>
						<div class="fila width50">
							<?php
							ultimosPostPaginacion($pagina, 4);
							?>
						</div>
					</div>
					<div class="fila height75 bordeBlanco">
						<div class="columna fondoGrisOscuro soloFlex alineadoIzquierda width100">
							<ul class="elementos fondoGrisOscuro">
								<?php
								require_once 'conexiones/rellenarBusquedas.php';
								mostrarPostsSinImagen($pagina, 4);
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="div2_4">
					<div class="recomendados">
						<h2 class="subtitulo2">Recomendados</h2>
						<div>
							<a class="antsig" href="#">Anterior</a> <a class="antsig" href="#">Siguiente</a>
						</div>
						<div class="fila width50">
							<?php
							sugerenciasPaginacion($sugPage, 1);
							?>
						</div>
					</div>
					<div class="fila fondoGrisOscuro height75 padding1 bordeBlanco">
						<?php mostrarPostsSugerencia($sugPage, 1); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="div3">
			<p class="footer">Varela´s Web ©</p>
		</div>
	</div>
	<script src="index.js">
	</script>
		</div>
	</div>
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
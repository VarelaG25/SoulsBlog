<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/7aadadae08.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alice&display=swap" rel="stylesheet">
	<title>Perfil</title>
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
	<div class="contenedor-Perfil">
		<div class="c1">
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
		<div class="c2">
			<div class="fila">
				<div class="columna">
					<h1>Perfil</h1>
				</div>
			</div>
		</div>
		<div class="c3">
			<form class="perfilPrincipal centerFlex" action="conexiones/actualizarPerfil.php" method="post" onsubmit="return compararContrasenia();" enctype="multipart/form-data">
				<div class="c3-1">
					<div class="registroRecuadro padding2 fondoGrisOscuro bordeBlanco">
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro padding2 width50  centrado-Items">
								<h2 class="fondoGrisOscuro">Datos personales</h2>
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="usuarioR">Usuario:</label>
								<div class="contenedor-Campo fondoGrisOscuro">
									<input value="<?php echo htmlspecialchars($usuario['NombreUsuario'] ?? ''); ?>" class="campo-Texto width100" id="usuarioR" name="usuario" type="text" disabled>
								</div>
							</div>
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="nombre">Nombre(s):</label>
								<div class="contenedor-Campo fondoGrisOscuro">
									<input value="<?php echo htmlspecialchars($usuario['Nombre'] ?? ''); ?>" class="campo-Texto fondoGrisOscuro width100" id="nombre" name="nombre" type="text" disabled>
								</div>
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="apellidoPaterno">Apellido Paterno:</label>
								<div class="contenedor-Campo">
									<input value="<?php echo htmlspecialchars($usuario['PrimerApellido'] ?? ''); ?>" class="campo-Texto width100" id="apellidoPaterno" name="apellidoPaterno"
										type="text" disabled>
								</div>
							</div>
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="apellidoMaterno">Apellido Materno:</label>
								<div class="contenedor-Campo">
									<input value="<?php echo htmlspecialchars($usuario['SegundoApellido'] ?? ''); ?>" class="campo-Texto width100" id="apellidoMaterno" name="apellidoMaterno"
										type="text" disabled>
								</div>
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="correo">Correo:</label>
								<div class="contenedor-Campo">
									<input value="<?php echo htmlspecialchars($usuario['Correo'] ?? ''); ?>" class="campo-Texto width100" id="correo" name="correo" type="email" disabled>
								</div>
							</div>
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="fechaNacimiento">Fecha de nacimiento:</label>
								<div class="contenedor-Campo fondoGrisOscuro">
									<input value="<?php echo htmlspecialchars($usuario['FechaNacimiento'] ?? ''); ?>" class="campo-Texto fondoGrisOscuro width100" id="fechaNacimiento" name="fechaNacimiento"
										type="date" disabled>
								</div>
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="contraseniaUsuario">Contraseña:</label>
								<div class="contenedor-Campo width100 soloFlex fondoGrisOscuro">
									<input value="<?php echo htmlspecialchars($usuario['Contrasenia'] ?? ''); ?>" class="campo-Texto fondoGrisOscuro width75" id="contrasenia" name="contrasenia"
										type="password" disabled>
									<button class="width25 " type="button" style="background-color: white; border-style:none;" onclick="verContrasenia()">
										<i class="fa-solid fa-eye" style="background-color: transparent; color:black"></i></button>
								</div>
							</div>
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width100 ">
								<label class="fondoGrisOscuro" for="contraseniaUsuario">Confirmar contraseña:</label>
								<div class="contenedor-Campo soloFlex width100 fondoGrisOscuro">
									<input class="campo-Texto fondoGrisOscuro width75" id="confirmarContrasenia" name="confirmarContrasenia"
										type="password" disabled>
									<button class="width25 " type="button" style="background-color: white; border-style:none;" onclick="verConfirmarContrasenia()">
										<i class="fa-solid fa-eye" style="background-color: transparent; color:black"></i></button>
								</div>
							</div>
						</div>
						<div class="fila centrado-Items fondoGrisOscuro">
							<div class="columna fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width50  centrado-Items">
								<input class="boton-secundario width100" type="button" value="Editar informacion" onclick="editarInformacion()">
							</div>
							<div class="columna centrado-Items fondoGrisOscuro marginLeft2 marginRight2 marginTop1 width50  centrado-Items">
								<input class="boton width100" type="submit" value="Confirmar cambios">
							</div>
						</div>
					</div>
				</div>
				<div class="c3-2 centerFlex">
					<div class="imagenRegistroRecuadro fondoGrisOscuro padding2 bordeBlanco">
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro centrado-Items">
								<label>Foto de perfil</label>
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna bordeDorado fondoGrisOscuro centrado-Items">
								<img class="imagenCargar fondoGrisOscuro" id="preview"
									src="<?php echo htmlspecialchars($usuario['rutaImagen']); ?>"
									alt="Vista previa" style="visibility: visible;" />
							</div>
						</div>
						<div class="fila fondoGrisOscuro">
							<div class="columna fondoGrisOscuro centrado-Items">
							<p id="nombreArchivo" class="fondoGrisOscuro">Sin archivo seleccionado</p>
                            <input name="imagen" type="file" id="cargarImagen" accept="image/*" class="input-file">
                            <label for="cargarImagen" class="boton-secundario centerFlex width100">Cargar Imagen</label>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="footer-Global">
			<p class="footer">Varela´s Web ©</p>
		</div>
	</div>

	<script src="scripts/perfil.js"></script>
	<script src="scripts/navBar.js"></script>
	<script src="scripts/botones.js"></script>
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
function mostrarSoloSesionActiva() {
    const contenedorRegistro = document.getElementById('contenedorRegistro');
    const contenedorLogin = document.getElementById('contenedorLogin');
    const contenedorPerfil = document.getElementById('contenedorPerfil');
    const contenedorSalir = document.getElementById('contenedorSalir');

    if (contenedorRegistro) contenedorRegistro.style.display = 'none';
    if (contenedorLogin) contenedorLogin.style.display = 'none';
    if (contenedorPerfil) contenedorPerfil.style.display = 'flex';
    if (contenedorSalir) contenedorSalir.style.display = 'flex';
}

function mostrarSoloSesionInactiva() {
    const contenedorRegistro = document.getElementById('contenedorRegistro');
    const contenedorLogin = document.getElementById('contenedorLogin');
    const contenedorPerfil = document.getElementById('contenedorPerfil');
    const contenedorSalir = document.getElementById('contenedorSalir');

    if (contenedorRegistro) contenedorRegistro.style.display = 'flex';
    if (contenedorLogin) contenedorLogin.style.display = 'flex';
    if (contenedorPerfil) contenedorPerfil.style.display = 'none';
    if (contenedorSalir) contenedorSalir.style.display = 'none';
}

function confirmarSalir() {
    if(confirm("¿Esta seguro que desea cerrar sesion?")){
        window.location.href='conexiones/cerrarSesion.php';
    }
}
function verContrasenia() {
    const input = document.getElementById('contrasenia');
    input.type = input.type === "password" ? "text" : "password";
}

function verConfirmarContrasenia() {
    const input = document.getElementById('confirmarContrasenia');
    input.type = input.type === "password" ? "text" : "password";
}

function editarInformacion() {
    const campos = [
        'usuarioR',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'correo',
        'fechaNacimiento',
        'contrasenia',
        'confirmarContrasenia'
    ];

    const estaDeshabilitado = document.getElementById(campos[0]).disabled;

    campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) campo.disabled = !estaDeshabilitado;
    });
}

function compararContrasenia(){
    const contrasenia = document.getElementById("contrasenia").value;
    const confirmarContrasenia = document.getElementById("confirmarContrasenia").value;

    if(contrasenia === confirmarContrasenia){
        alert("✅ Confirmando cambios...");
        return true; // permite enviar el formulario
    } else {
        alert("❌ Las contraseñas no coinciden.");
        return false; // evita que se envíe el formulario
    }
}
document.getElementById('cargarImagen').addEventListener('change', function(event) {
    const img = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        img.src = URL.createObjectURL(file);
    } else {
        img.src = 'img/user.png';  // Si no se selecciona ninguna imagen, restablece la imagen predeterminada
    }
});
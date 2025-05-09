document.addEventListener('DOMContentLoaded', function () {
    const inputArchivo = document.getElementById('cargarImagen');
    const etiquetaNombre = document.getElementById('nombreArchivo');
    const imagenPreview = document.getElementById('preview');

    inputArchivo.addEventListener('change', function(event) {
        const archivo = event.target.files[0];

        if (archivo) {
            etiquetaNombre.textContent = archivo.name;
            imagenPreview.src = URL.createObjectURL(archivo);
        }
    });
});
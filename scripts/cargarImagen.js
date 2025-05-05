document.addEventListener('DOMContentLoaded', function () {
    const inputArchivo = document.getElementById('cargarImagen');
    const etiquetaNombre = document.getElementById('nombreArchivo');
    const imagenPreview = document.getElementById('preview');

    inputArchivo.addEventListener('change', function(event) {
        const archivo = event.target.files[0];

        if (archivo) {
            // Extraemos el nombre original del archivo
            let nombreArchivo = archivo.name;

            // Comprobamos si el nombre contiene un guion bajo
            if (nombreArchivo.includes('_')) {
                // Usamos una expresión regular para eliminar todo antes del guion bajo
                const regex = /(?:.*_)(.*)/;
                nombreArchivo = nombreArchivo.replace(regex, '$1'); // Solo después del "_"
            }
            etiquetaNombre.textContent = archivo.name;
            imagenPreview.src = URL.createObjectURL(archivo);
        }
    });
});
// Inicializar toast automáticamente al cargar la página
const toastEl = document.getElementById('liveToast');
if(toastEl) {
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

// Función para descargar el JSON de una fila específica dado su ID
const descargarFila = (id) => {
    // Realiza una petición fetch a index.php con acción conseguir y el id dado
    fetch(`index.php?accion=conseguir&id=${id}&guardar=1`)
    .then(async rs => {
        // Lee la respuesta como texto crudo
        const text = await rs.text();
        // console.log("Contenido crudo de la respuesta:", text); // Debug

        try {
            // Intenta parsear la respuesta JSON
            const data = JSON.parse(text);

            // Crea un Blob con el JSON formateado para descarga
            const blob = new Blob([JSON.stringify(data, null, 2)], {type: "application/json"});
            // Crea un URL temporal para el Blob
            const url = URL.createObjectURL(blob);

            // Crea un elemento <a> invisible para forzar la descarga
            const a = document.createElement('a');
            a.href = url;
            a.download = `datos_fila_${id}.json`;

            // Añade el enlace al DOM, lo dispara, y luego lo elimina
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Libera el URL temporal
            URL.revokeObjectURL(url);
        } catch (e) {
            // Captura errores al parsear JSON y muestra mensaje
            console.error("No se pudo parsear JSON:", e);
            alert("La respuesta del servidor no es JSON válido.");
        }
    })
    .catch(error => {
        // Captura errores en la petición fetch y muestra alerta
        console.error("Se produjo un error en la petición", error);
        alert(error);
    });
}

// Función para descargar todos los registros en un archivo JSON
function descargarTodo() {
    fetch('?accion=conseguirTodo&guardar=1')
        .then(res => res.json())
        .then(data => {
            // Crear Blob con el JSON
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);

            // Crear enlace temporal y hacer click
            const a = document.createElement('a');
            a.href = url;
            a.download = 'recintos.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Liberar memoria
            URL.revokeObjectURL(url);
        })
        .catch(err => console.error('Error al descargar JSON:', err));
}
const descargarFila = (id) => {
    fetch(`index.php?accion=conseguir&id=${id}`)
    .then(async rs => {
        const text = await rs.text();
        // console.log("Contenido crudo de la respuesta:", text); debug
        
        try {
            const data = JSON.parse(text);
            const blob = new Blob([JSON.stringify(data.data, null, 2)], {type: "application/json"});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `datos_fila_${id}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (e) {
            console.error("No se pudo parsear JSON:", e);
            alert("La respuesta del servidor no es JSON válido.");
        }
    })
    .catch(error => {
        console.error("Se produjo un error en la petición", error);
        alert(error);
    });
}

const descargarTodo = () => {
    fetch(`index.php?accion=conseguirTodo`)
    .then(async rs => {
        const text = await rs.text();
        
        try {
            const data = JSON.parse(text);
            const blob = new Blob([JSON.stringify(data.data, null, 2)], {type: "application/json"});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `backup_datos.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (e) {
            console.error("No se pudo parsear JSON:", e);
            alert("La respuesta del servidor no es JSON válido.");
        }
    })
    .catch(error => {
        console.error("Se produjo un error en la petición", error);
        alert(error);
    });
}
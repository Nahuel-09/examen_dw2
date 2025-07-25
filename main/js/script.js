const descargarFila = (id) => {
    fetch(`index.php?accion=conseguir&id=${id}`)
    .then(rs => {
        if (!rs.ok) throw new Error("Se produjo en la consulta");

        return rs.json();
    })
    .then(data => {
        const blob = new Blob([JSON.stringify(data, null, 2)], {type: "application/json"});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `datos_fila_${id}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error("Se produjo un error en la peticion", error);
        alert(error);
    })
}

const descargarTodo = () => {
    fetch(`index.php?accion=conseguirTodo`)
    .then(rs => {
        if (!rs.ok) throw new Error("Se produjo en la consulta");

        return rs.json();
    })
    .then(data => {
        const blob = new Blob([JSON.stringify(data, null, 2)], {type: "application/json"});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Backup_mascotas.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error("Se produjo un error en la peticion", error);
        alert(error);
    })
}
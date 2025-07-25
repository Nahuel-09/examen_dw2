1. Gestión de Mascotas.

Desarrollar una aplicación web dinámica en PHP con funcionalidades completas de CRUD para gestionar mascotas. La aplicación debe cumplir una serie de requísitos técnicos que serán verificados en clase al momento de la corrección.

- Requisitos Técnicos Obligatorios:

> Estructura de Carpetas

La aplicación debe estar contenida en una carpeta nombrada según el siguiente formato: dw2f1 <inicial_nombre><apellido>. Por ejemplo, si el estudiante se llama Valeria Gómez, la carpeta del proyecto deberá llamarse dw2f1 vgomez. Este mismo nombre se utilizará como prefijo para la base de datos.

( ! ) Con las siguientes subcarpetas:

○ ext/: Bootstrap y librerías JS (offline).
○ lib/: Clases PHP (incluye ConexionDB, paginación, ImgRZ).
○ images/: Para almacenar imágenes cargadas desde el formulario.
○ img/: Imágenes decorativas.
○ js/: Scripts personalizados.

♧ Enrutamiento:

~ Todas las acciones deben pasar por un único archivo index.php, usando la variable accion por GET.
~ Debe incluir vistas parciales:
▪︎ header.php y focter.php
▪︎ formulario.php (para alta y edición)
▪︎ listado.php (con paginación y acciones)

▪︎ CRUD (Mascotas):

* Formulario reutilizable para alta y modificación.
* Carga de imagen JPEG redimensionada a 540px usando la clase ImgRZ.
* La imagen se almacena en images/y se guarda su nombre en la base de datos.
* Validación y sanitización obligatorias antes de guardar/modificar datos.

▪︎ Listado:
○ Muestra imagen de cada mascota (máx. 80px alto).
○ Paginación de 4 registros por página (usando clase vista en clase).
○ Botones por registro: Editar, Borrar (con confirmación), JSON.
○ Botones generales: Nuevo, JSON (todos los registros).

2. Otras Condiciones Técnicas:

- Uso obligatorio de Bootstrap descargado (offline), enlazado desde ext/.
- Cabecera y pie deben cargarse dinámicamente desde archivos parciales.
- Clase ConexionDB obiigatoria para toda operación oper de base de datos.
- No se permite uso de frameworks ni conexión a recursos externos.
- Todos los recursos deben funcionar en un entorno offline.

▪︎ Base de Datos:

* Nombre obligatorio: dw2f1 <inicial_nombre><apellido
* Crear la siguiente tabla:

CREATE TABLE mascotas (
id INT AUTO INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
especie VARCHAR(100) NOT NULL,
edad INT NOT NULL,
foto VARCHAR(191)
);

- Insertar al menos 7 registros válidos para la corrección.

▪︎ Formatos de Respuesta JSON:

- Para la lista completa y para un solo registro:

{
"rows": Integer,
"data": [Array],
"msg": "Mensaje del sistema",
"status": "success" | "error"
}

[ ! ] Reglas

* El trabajo será evaluado in situ. El estudiante debe demostrar su funcionamiento ante el docente.

* No se permite el uso de recursos online.

* El proyecto debe correr de forma autónoma en un servidor local (XAMPP, Laragon, etc.).

* Todo el código debe estar adecuadamente comentado, estructurado y funcional.
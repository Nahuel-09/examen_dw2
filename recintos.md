## B. *Practica (24 puntos)*

> 📂 *Desarrollo de Aplicación Web Dinámica - CRUD de recintos* 

> ***Enunciado***: 

- Desarrollar una aplicación web con funcionalidades completas de gestión para los recintos del mini zoológico, cumpliendo con los siguientes requisitos técnicos y funcionales:

> ## 🧩 *Requisitos de Implementación:* 

> ### 📁 Estructura general del proyecto:

- El proyecto deberá estar contenido en una carpeta llamada: dw2f2_<inicial_nombre><apellido> Ejemplo: dw2f2_jgomez 
- Y estructurado con las siguientes subcarpetas obligatorias: 
  - /lib → Clases PHP (ConexionDB, ImgRZ, paginación, etc.) 
  - /ext → Bootstrap descargado (uso offline obligatorio), otras librerías si se usan 
  - /img → Elementos decorativos, si aplica 
  - /images → Carpeta para imágenes cargadas desde el formulario 
  - /js → Archivos JavaScript propios si se usan.

> 📖 *Base de datos* 
- Base de datos obligatoria: dw2f2_<inicial_nombre><apellido>
- Crear tabla recintos con al menos 7 registros cargados.

```sql
CREATE TABLE `recintos` (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL, 
    tipo VARCHAR(100) NOT NULL, 
    capacidad INT NOT NULL, 
    imagen VARCHAR(191) 
);
```
> ### ⚙️ *Funcionalidad esperada*

> ##### ⚓️ *Navegación:*
- Utilizar un único archivo index.php como punto de entrada, gestionando las acciones co una variable accion recibida por GET. 
---
> ## *Vistas parciales obligatorias:* 
  - header.php y footer.php
  - formulario.php → alta/modificación 
  - listado.php → tabla con datos y paginación 
---
> ## *Listado de recintos:*
  - Mostrar Datos con paginación (4 por pagina)
  - Incluir miniatura de la imagen (<img>) con altura máxima de 80 px.
  - Botones por registro:
     - Editar.
     - Eliminar (confirmacion previa)
     - JSON (Registro individual)
- Botones Generales:
     - Nuevo (formulario de alta)
     - JSON (todos los registros)
- *Formulario:*
  - Usado tanto para alta como para edicion.
  - Debe mostrar los campos:
    - nombre (string), tipo(string), capacidad(int), imagen(string).
- Validacion y sanitizacion obligatorias.
    - El archivo cargado debe:
    - Ser una imagen .jpg o .jpeg
    - Ser redimensionado a 540px de ancho usando la clase ImgRZ.
    - Almacenarse en la carpeta /images
### 🔁 Respuestas JSON:
**Formato de salida para JSON general y por registro:**
- El archivo cargado debe:
      ○ Ser una imagen .jpg o .jpeg
      ○ Ser redimensionado a 540px de ancho usando la clase ImgRZ.
      ○ Almacenarse en la carpeta /images
  
🔁 Respuestas JSON:
*Formato de salida para JSON general y por registro:*
```json
{
   "rows": 1,
   "data": [{}],
   "msg": "Recinto encontrado",
   "status": "success"
}
```
> ⚠️ **Requisitos Tecnicos:**
> 
  - ✅️ Uso obligatorio de bootstrap offline desde /ext.
  - ✅️ Uso de vistas parciales y enrutador (index.php)
  - ✅️ Uso de clases ConexionDB, paginador y ImgRZ
  - ✅️ Validacion y sanitizacion antes de guardar
  - ✅️ Proyecto ejecutable completamente en entorno local. (xampp, laragon)

⚠️ *Requisitos Tecnicos:*

       •   ✅️ Uso obligatorio de bootstrap offline desde /ext.
       
       •   ✅️ Uso de vistas parciales y enrutador (index.php)
       
       •   ✅️ Uso de clases ConexionDB, paginador y ImgRZ
       
       •   ✅️ Validacion y sanitizacion antes de guardar
       
       •   ✅️ Proyecto ejecutable completamente en entorno local. (xampp, laragon)
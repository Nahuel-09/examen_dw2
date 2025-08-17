# Pasos para pasar un examen que te duraría 2h en literalmente 30/20m

## (!) Requerimientos previos

- [Tener descargado XAMPP u otro ejecutor de servidor local.](https://youtu.be/IQ22Nme9t0M?si=HGfTJIR39n0EjfWm)  
  - Dependiendo de su sistema operativo va a tener que configurar estos campos:

    ### Configuración de Windows
    - Tener una configuración previa del *php.ini* con las extensiones requeridas.
    - [Entrar a php.ini, ya adentro, quitar los `;` a las siguientes extensiones.](https://www.youtube.com/watch?v=q2IQmwkHSUQ)  
      ✅ Manejo de imágenes: `extension=gd`  
      ✅ Manejo de tipos de archivo: `extension=fileinfo`  
      ✅ Manejo de caracteres especiales (EMOJIS, ASCII): `extension=mbstring`  
      ✅ Manejo de JSON: `extension=json`  

    - Configuración previa:  
      - Permitir apertura y escritura de archivos: `allow_url_fopen` (en php.ini).  
      - [Permisos de carpetas.](https://youtu.be/MyexE_BhtZY?si=FSouvQ9OL4NG8SAv)

    ### Configuración de Linux y Mac
    - Manejar permisos desde la terminal (bash u otros):
      ```bash
<<<<<<< HEAD
      chmod 0777 '/images/' | '/API/'
=======
      chmod 0777 '/images/' | /API/
>>>>>>> e473d5a28a138150d6c1f7342ebcb622fc401c0d
      ```

- [Saber ejecutar XAMPP de manera básica.](https://youtu.be/vwjbBLVzI4Q?si=lbUgV4nncLbQGfTP)

---

## Leyenda de cambios
- 🔴 --> Cambio Obligatorio  
- 🟠 --> Cambio Importante  
- 🟡 --> Cambio Leve  
- 🔵 --> Cambio Opcional  
- 🟢 --> Cambio Innecesario  

---

## Estructura de directorios

```plaintext
/main/ --> Carpeta principal

    /code/ --> Apartado de código

        /choose-a-view/ --> Elegí un diseño que te guste

            /view-1/ --> Primer Diseño
                footer.php  --> Pie (🔵)
                form.php    --> Formulario de alta y edición (🔵)
                header.php  --> Cabecera con botones globales (🔵)
                list.php    --> Lista que muestra los datos (🔵)

            /view-2/ --> Segundo Diseño
                footer.php  --> Pie (🔵)
                form.php    --> Formulario de alta y edición (🔵)
                header.php  --> Cabecera con botones globales (🔵)
                list.php    --> Lista que muestra los datos (🔵)

            /view-3/ --> Tercer Diseño
                footer.php  --> Pie (🔵)
                form.php    --> Formulario de alta y edición (🔵)
                header.php  --> Cabecera con botones globales (🔵)
                list.php    --> Lista que muestra los datos (🔵)

            /view-4/ --> Cuarto Diseño
                footer.php  --> Pie (🔵)
                form.php    --> Formulario de alta y edición (🔵)
                header.php  --> Cabecera con botones globales (🔵)
                list.php    --> Lista que muestra los datos (🔵)

        /controller/ --> Lógica de negocio
            mainController.php --> Maneja acciones por medio de GET (agregar, editar, eliminar, listar, eliminarTodo, conseguirJSON, conseguirTodosLosJSON, con validación y sanitización) (🟡)

        /model/ --> Carpeta encargada del envío de información externa
            /API/
                api-de-referencia.json (🔵)
            /images/
                imagen-de-referencia.png (🔵)
            /lib/
<<<<<<< HEAD
                /utils/ --> Guardar funciones y no clases
=======
                /utils/
>>>>>>> e473d5a28a138150d6c1f7342ebcb622fc401c0d
                    config.php     --> Configuración general y depuración (🔴)
                    functions.php  --> Manejo de JSON y renderizado HTML (🟢)
                ConnDB.php        --> Base de datos (🟠)
                ImgHandler.php    --> Manejo de imágenes (🟡)
                Pagination.php    --> Paginación (🟡)
            /src/
                /bootstrap-5.3.7-dist/
                    /css/
                    /js/
                /css/  --> Estilo propio
                /js/   --> Animación y funcionalidad propia

        /router/
            index.php --> Conecta modelos, vistas y controlador de manera segura (🟡)
<<<<<<< HEAD

        /view/ --> Vista por defecto, recomendable no usar

        footer.php --> Pie (🔴)
        form.php   --> Formulario de alta y edición (🔴)
        header.php --> Cabecera con botones globales (🔴)
        list.php   --> Lista que muestra los datos (🔴)

    /DB/
        database.sql (🔵)

    /img/
        olimpia.png (🔵)

.gitignore  --> Ignora carpetas y archivos pesados (node_modules)
README.md   --> Documento del primer examen
README      --> Documento del segundo examen
Tutorial.md --> Documento enseñando todo
```
---

Videos recomendados

- [Como diseñar una base de datos en phpMyAdmin](https://youtu.be/2zkjIl0i3m8)
- [Como pasar un examen en 20m](https://youtu.be/31Mnswz6-sM)
- [Ver playlist](https://www.youtube.com/playlist?list=PLTpshO1wHOju4oBFZaI0khboksf5eea2Y)
  
---
=======

        /view/ --> Vista por defecto, recomendable no usar

        footer.php --> Pie (🔴)
        form.php   --> Formulario de alta y edición (🔴)
        header.php --> Cabecera con botones globales (🔴)
        list.php   --> Lista que muestra los datos (🔴)

    /DB/
        database.sql (🔵)

    /img/
        olimpia.png (🔵)

.gitignore  --> Ignora carpetas y archivos pesados (node_modules)
README.md   --> Documento del primer examen
README      --> Documento del segundo examen
Tutorial.md --> Documento enseñando todo
```
---

Videos recomendados

- [Video 1](https://youtu.be/2zkjIl0i3m8)
- [Video 2](https://youtu.be/31Mnswz6-sM)

---


>>>>>>> e473d5a28a138150d6c1f7342ebcb622fc401c0d

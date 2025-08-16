> *Pasos para pasar un examen que te duraria 2h en literalmente 30/20m:*

> **(!) Requerimientos previos:**

    •  [Tener descargado xampp o otro ejecutor de servidor local.](https://youtu.be/IQ22Nme9t0M?si=HGfTJIR39n0EjfWm)  
    
        •  Dependiendo de su sistema operativo va a tener que configurar estos campos.
        
            - Configuracion de windows: 
            
                •  Tener una configuracion previa del *php.ini* con las extensiones requeridas.
                
                •  [Entrar a php.ini, ya adentro, quitar los ';' a las siguientes extensiones.](https://www.youtube.com/watch?v=q2IQmwkHSUQ)
                
                    ✅   Manejo de imagenes:  `extension=gd`. 
                    
                    ✅   Manejo de tipos de archivo: `extension=fileinfo.`
                    
                    ✅   Manejo de caracteres especiales (EMOJIS, ASCII): `extension=mbstring`.
                    
                    ✅   Manejo de JSON: `extension=json`.
                    
                    • Configuracion previa: 
                    
                        •  Permitir apertura y escritura de archivos: `allow_url_fopen`. (en php.ini)
                        
                        •  [Permisos de carpetas.](https://youtu.be/MyexE_BhtZY?si=FSouvQ9OL4NG8SAv)
            
            - Configuracion de linux y mac:
            
                • Manejar permisos desde la terminal. (bash u otros). 
                
                    - Solo nos sirve usar `chmod 0777 'tucarpeta'`.   
    
    • [Saber ejecutar xampp de manera basica.](https://youtu.be/vwjbBLVzI4Q?si=lbUgV4nncLbQGfTP)

*Con todo esto ya hecho, podemos empezar :D*

Antes que nada, doy una guia visual de que es lo mas importantes que cambies, basate en estos emojis:
🔴 --> Cambio Obligatorio
🟠 --> Cambio Importante
🟡 --> Cambio Leve
🔵 --> Cambio Opcional
🟢 --> Cambio Innecesario

Voy a tratar de resumir mi directorio lo mas simple posible:

/main/ --> Carpeta principal
    /code/ --> Apartado de codigo
        /choose-a-view/  --> Elegi un diseño que te guste
            /view-1/   --> Primer Diseño 
                footer.php  --> Pie (🔵)
                form.php  --> Formulario de alta y edicion (🔵)
                header.php  --> Cabecera que maneja botones globales (🔵)
                list.php    --> Lista que muestra los datos en la pagina (🔵)
            /view-2/   --> Segundo Diseño
                footer.php  --> Pie (🔵)
                form.php  --> Formulario de alta y edicion (🔵)
                header.php  --> Cabecera que maneja botones globales (🔵)
                list.php    --> Lista que muestra los datos en la pagina (🔵)
            /view-3/   --> Tercer Diseño
                footer.php  --> Pie (🔵)
                form.php  --> Formulario de alta y edicion (🔵)
                header.php  --> Cabecera que maneja botones globales (🔵)
                list.php    --> Lista que muestra los datos en la pagina (🔵)
            /view-4/   --> Cuarto Diseño
                footer.php  --> Pie (🔵)
                form.php  --> Formulario de alta y edicion (🔵)
                header.php  --> Cabecera que maneja botones globales (🔵)
                list.php    --> Lista que muestra los datos en la pagina (🔵)
        /controller/   --> Logica de negocio, recibiendo informacion (de model) e interfaz (de la view que elijas)
            mainController.php  --> Maneja las acciones por medio de gets (agregar, editar, eliminar, listar, eliminarTodo, conseguirJSON, conseguirTodosLosJSON, con validacion y sanitizacion incluida) (🟡)
        
        /model/  --> Carpeta encargada del envio de informacion externa.
            /API/   --> Lugar donde se almacena los JSON que se descargan.
                api-de-referencia.json (🔵)
            /images/  --> Lugar donde se guardan las imagenes que manda el usuario.
                imagen-de-referencia.png (🔵)
            /lib/  --> Apartado que se encarga de la gestion de la informacion.
                /utils/   --> Codigo Funcional o Secuencial (no uso clases)
                    config.php  --> Configuracion General y Debugacion (🔴)
                    functions.php  --> Manejo de json y renderizacion html (🟢)
                ConnDB.php  --> Base de datos (🟠)
                ImgHandler.php  --> Manejo de imagenes (🟡)
                Pagination.php  --> Paginacion (🟡)
            /src/   --> Conecta librerias, diseño, funcionalidad, y iconos 
                /bootstrap-5.3.7-dist/  --> Bootstrap Offline
                    /css/ 
                    /js/
                /css/   --> Estilo propio
                /js/    --> Animacion y funcionalidad propia

        /router/    --> Enrutador que sirve para conectar todo
            [index.php](https://github.com/Nahuel-09/examen_dw2/blob/main/main/code/router/index.php)  --> Conecta los modelos, las vistas, y el controlador de manera segura (🟡)
        /view/   --> Vista por defecto, recomendable no usar
        footer.php  --> Pie (🔴)
        form.php  --> Formulario de alta y edicion (🔴)
        header.php  --> Cabecera que maneja botones globales (🔴)
        list.php    --> Lista que muestra los datos en la pagina (🔴)

    /DB/  --> Plantilla de base de datos
        [database.sql](https://github.com/Nahuel-09/examen_dw2/blob/main/main/DB/database.sql) (🔵)
    /img/ --> Apartado de imagenes decorativas :D
        [olimpia.png](https://github.com/Nahuel-09/examen_dw2/blob/main/main/img/olimpia.png) (🔵)
.gitignore  --> Archivo para ignorar carpetas y archivos pesados de github (node_modules)
README.md  -->  Documento del primer examen
README  -->  Documento del segundo examen 
Tutorial.md  -->   Documento enseñando todo

Muy bien, explicado con este esquema recomiendo ver 2 videos:
Video 1   ---->   https://youtu.be/9AEjpod4dHI
Video 2   ---->   https://youtu.be/2zkjIl0i3m8
Video 3   ---->   https://youtu.be/31Mnswz6-sM

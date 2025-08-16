<?php
ini_set('display_errors', 1); // Esto muestra los errores en caso de querer debuguear
ini_set('display_startup_errors', 1); // Inicializa los errores en caso de haber
error_reporting(E_ALL);  // Se muestran todos los especies de inconcistencias 
// Informacion de la base de datos
if (!defined('NAME_TABLE')) define("NAME_TABLE","mascotas"); // Nombre de la tabla
if (!defined('DB_HOST')) define("DB_HOST", "localhost"); // Nombre del server que se hostea
if (!defined('DB_USER')) define("DB_USER", "root"); // Nombre de usuario de dicho servidor
if (!defined('DB_PASS')) define("DB_PASS", ""); // Contraseña del mismo server
if (!defined('DB_NAME')) define("DB_NAME", "mascotas_db"); // Nombre de la base de datos
// Informacion de los directorios
if (!defined('SAVE_IMG')) define("SAVE_IMG", __DIR__ . "/../../" . "images/"); // La carpeta en donde quiero guardar mis fotoes
if (!defined('SAVE_JSON')) define("SAVE_JSON", __DIR__ . "/../../" . "API/"); // La carpeta en donde quiero guardar mis fotoes
?>
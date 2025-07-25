<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!defined('NAME_TABLE')) define("NAME_TABLE","mascotas");
if (!defined('SAVE_IMG')) define("SAVE_IMG", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR);
if (!defined('DB_HOST')) define("DB_HOST", "localhost");
if (!defined('DB_USER')) define("DB_USER", "root");
if (!defined('DB_PASS')) define("DB_PASS", "");
if (!defined('DB_NAME')) define("DB_NAME", NAME_TABLE . "_db");
?>
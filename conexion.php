<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "api_php_mysql";

// Crear conexión
$conexion = new mysqli($host, $user, $password);

// Crear la base de datos si no existe
$conexion->query("CREATE DATABASE IF NOT EXISTS $database");
$conexion->select_db($database);

// Crear la tabla de estudiantes si no existe
$sql_tabla = "CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    materia VARCHAR(100) NOT NULL,
    nota DECIMAL(5,2) NOT NULL,
    estado VARCHAR(20) NOT NULL
)";
$conexion->query($sql_tabla);
?>
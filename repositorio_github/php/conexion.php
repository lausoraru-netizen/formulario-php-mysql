<?php
declare(strict_types=1);

// Datos de la base MySQL en InfinityFree (panel > MySQL Databases)
$servidor = 'sql303.infinityfree.com';
$baseDatos = 'if0_43397477_formulario';
$usuario = 'if0_43397477';
$contrasena = 'TU_CONTRASENA_MYSQL'; // por seguridad no se sube la contraseña real

$dsn = "mysql:host={$servidor};dbname={$baseDatos};charset=utf8mb4";

try {
    $conexion = new PDO (
        $dsn,
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false 
        ]
    );
}   catch (PDOexception $e){
    error_log('Error de conexión con la base de datos: ' . $e->getMessage()); 

    http_response_code(500);
    exit(
        'No fue posible conectar con la base de datos, ' .
        'inténtelo más tarde'
    );
}
?>
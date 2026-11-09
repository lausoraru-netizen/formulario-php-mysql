<?php
    declare(strict_types=1);

    //Aceptar únicamente peticiones tipo post

        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Allow: POST');
            http_response_code(405);
            exit("Método no permitido, Envia el formulario desde la página principal");
        }

    //Funcion que permite leer los campos de manera controlada
    function obtenerTexto(string $campo): string
    {
        $valor = $_POST[$campo] ?? '';

        if (!is_string($valor)) {
            return '';
        }
        return trim($valor);
    }

    //Obtener los datos del formulario
    $nombre = obtenerTexto('nombre_completo');
    $correo = obtenerTexto('correo');
    $telefono = obtenerTexto('telefono');
    $asunto = obtenerTexto('asunto');
    $mensaje = obtenerTexto('mensaje');

    $aceptaTratamiento = isset($_POST['acepta_tratamiento']) 
        && $_POST['acepta_tratamiento'] === '1';  

    //validar los campos del formulario en el servidor
    $errores = [];
    if ($nombre === '') {
        $errores[] = 'El nombre completo es obligatorio';
    } elseif (mb_strlen($nombre, 'UTF-8') > 120) {
        $errores[] = 'El nombre no puede superar los 120 carácteres';
    }

    if ($correo === '') {
        $errores[] = 'El correo electrónico es obligatorio';
    } elseif (mb_strlen($correo, 'UTF-8') > 190 || filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = 'El correo electrónico no es válido';
    }

    if (mb_strlen($telefono, 'UTF-8') > 30) {
        $errores[] = 'El teléfono no puede superar los 30 carácteres';
    } 

    $asuntosPermitidos = [
        'Consulta General',
        'Soporte técnico',
        'Solicitud de información',
        'Otro'
    ];

    if (!in_array($asunto, $asuntosPermitidos, true)) {
        $errores[] = 'Seleccione un asunto válido.';
    }

    if ($mensaje === '') {
        $errores[] = 'El mensaje es obligatorio';
    } elseif (mb_strlen($mensaje, 'UTF-8') > 3000){
        $errores[] = 'El mensaje no puede superar los 3000 carácteres';
    }

    if (!$aceptaTratamiento){
        $errores[] = 'Debes aceptar el tratamiento de Datos para continuar';
    }

    //preparar una respuesta HTML segura

    function responder(
    string $titulo,
    array $mensajes,
    int $codigoHttp
): never {

    http_response_code($codigoHttp);
    header('Content-Type: text/html; charset=UTF-8');

    echo '<!DOCTYPE html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

    echo '<title>' . htmlspecialchars(
        $titulo,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    ) . '</title>';

    echo '<link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA2NCA2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiByeD0iMTQiIGZpbGw9IiMxZDRlZDgiLz48dGV4dCB4PSIzMiIgeT0iNDMiIGZvbnQtZmFtaWx5PSJBcmlhbCxzYW5zLXNlcmlmIiBmb250LXNpemU9IjI4IiBmb250LXdlaWdodD0iYm9sZCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TFI8L3RleHQ+PC9zdmc+Cg==">';
    echo '</head>';
    echo '<body>';

    echo '<main style="max-width:650px; margin:40px auto; padding:20px; font-family:Arial,sans-serif;">';

    echo '<h1>' . htmlspecialchars(
        $titulo,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    ) . '</h1>';

    foreach ($mensajes as $texto) {
        echo '<p>' . htmlspecialchars(
            $texto,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        ) . '</p>';
    }

    echo '<p><a href="../index.html">Volver al formulario</a> | <a href="registros.php">Ver registros</a></p>';
    echo '<p style="color:#64748b">Formulario de Laura Sofía Ramos Rueda</p>';

    echo '</main>';
    echo '</body>';
    echo '</html>';

    exit;
}

    //Validar si los datos son incorrectos
    if ($errores !== []){
        responder('Revisa los datos del formulario', $errores, 422);
    }
    //Cargar la conexión e insertar los datos en el formulario
    try {
        require __DIR__ . '/conexion.php';

        $sql = 'INSERT INTO contactos
                (nombre_completo, correo, telefono, asunto, mensaje, acepta_tratamiento)
                VALUES
                (:nombre, :correo, :telefono, :asunto, :mensaje, :acepta)';

        $consulta = $conexion -> prepare($sql);

        $consulta->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':telefono' => $telefono === '' ? null : $telefono,
            ':asunto' => $asunto,
            ':mensaje' => $mensaje,
            ':acepta' => 1
        ]);

        responder(
            'Mensaje enviado correctamente',
            ['Los datos se almacenaron en la base de datos'],
            201
        );
    } catch (Throwable $e) {

    http_response_code(500);
    echo '<pre>';
    echo htmlspecialchars(
        $e->getMessage(),
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
    echo '</pre>';

} 

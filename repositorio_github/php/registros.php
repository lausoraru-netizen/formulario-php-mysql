<?php
declare(strict_types=1);
require __DIR__ . '/conexion.php';
$registros = $conexion->query('SELECT * FROM contactos ORDER BY id ASC')->fetchAll();
function e(?string $t): string { return htmlspecialchars($t ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros - Laura Sofía Ramos Rueda</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA2NCA2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiByeD0iMTQiIGZpbGw9IiMxZDRlZDgiLz48dGV4dCB4PSIzMiIgeT0iNDMiIGZvbnQtZmFtaWx5PSJBcmlhbCxzYW5zLXNlcmlmIiBmb250LXNpemU9IjI4IiBmb250LXdlaWdodD0iYm9sZCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TFI8L3RleHQ+PC9zdmc+Cg==">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<main class="contenedor">
    <section class="tarjeta ancha">
        <header class="encabezado">
            <h1>Registros de la base de datos</h1>
            <p class="autora">Formulario de <strong>Laura Sofía Ramos Rueda</strong></p>
            <p>Tabla <strong>contactos</strong> — total: <?= count($registros) ?> registros</p>
        </header>
        <div class="tabla-scroll">
            <table>
                <tr><th>ID</th><th>Nombre completo</th><th>Correo</th><th>Teléfono</th><th>Asunto</th><th>Mensaje</th><th>Acepta</th><th>Fecha</th></tr>
                <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?= e((string)$r['id']) ?></td>
                    <td><?= e($r['nombre_completo']) ?></td>
                    <td><?= e($r['correo']) ?></td>
                    <td><?= e($r['telefono']) ?></td>
                    <td><?= e($r['asunto']) ?></td>
                    <td><?= e($r['mensaje']) ?></td>
                    <td><?= $r['acepta_tratamiento'] ? 'Sí' : 'No' ?></td>
                    <td><?= e($r['fecha_registro']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <p class="nota"><a href="../index.html">Volver al formulario</a></p>
    </section>
</main>
</body>
</html>

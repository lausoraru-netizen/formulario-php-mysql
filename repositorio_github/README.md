# Formulario de contacto con PHP y MySQL

**Autora:** Laura Sofía Ramos Rueda — Escuela Tecnológica Instituto Técnico Central (ETITC)

**Sitio publicado:** https://formulariolauraramos.free.nf

Formulario de contacto que guarda los mensajes en una base de datos MySQL alojada en InfinityFree.

## Estructura

```
index.html                                   Formulario (HTML)
CSS/style.css                                Estilos
JS/script.js                                 Validaciones en el navegador
php/conexion.php                             Conexión PDO a MySQL
php/interconexion.php                        Recibe, valida y guarda los datos
php/registros.php                            Muestra los registros de la tabla
base_datos.sql                               Tabla contactos + 5 registros
Tratamiento_Datos_Laura_Sofia_Ramos_Rueda.pdf Política de tratamiento de datos
```

## Cómo ejecutarlo

1. Crear una base de datos MySQL y ejecutar `base_datos.sql`.
2. Poner los datos de conexión en `php/conexion.php` (la contraseña real no se sube al repositorio).
3. Subir los archivos a la carpeta `htdocs` del hosting y abrir `index.html`.

// archivo: public/index.php
<?php
// Redirigimos todo el tráfico público a este front-controller.
// Más adelante sumaremos rutas. Por ahora, simple verificación.
declare(strict_types=1);

// Seguridad básica: nunca expongas phpinfo() en producción.
// echo phpinfo();

require_once __DIR__ . '/../app/config/config.php';

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>GES_PRO2 — Inicio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif; margin:40px; color:#222;}
    .card{border:1px solid #ddd; padding:20px; border-radius:8px; max-width:720px;}
    h1{margin-top:0;}
    code{background:#f5f5f5; padding:2px 6px; border-radius:4px;}
  </style>
</head>
<body>
  <div class="card">
    <h1>GES_PRO2</h1>
    <p>Proyecto base creado correctamente. Este archivo es el punto de entrada (<code>public/index.php</code>).</p>
    <p>Conexión a base de datos pendiente de configurar con variables <code>.env</code>.</p>
  </div>
</body>
</html>

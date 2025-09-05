// archivo: app/config/config.php
<?php
declare(strict_types=1);

/**
 * Carga variables desde .env (sin dependencias).
 * Soporta líneas tipo KEY=valor y # comentarios.
 */
function load_env(string $envPath): array {
    $vars = [];
    if (!is_file($envPath)) {
        return $vars;
    }
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) continue;
        [$key, $value] = $parts;
        $key = trim($key);
        $value = trim($value);
        // Quitar comillas si las hay
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }
        $vars[$key] = $value;
        // También lo exportamos a $_ENV (opcional)
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
    return $vars;
}

$ROOT = dirname(__DIR__, 2);

// Cargar .env si existe
$ENV = load_env($ROOT . '/.env');

// Ajustar zona horaria si se define en .env, sino por defecto Argentina
$tz = $ENV['APP_TIMEZONE'] ?? 'America/Argentina/Buenos_Aires';
if (function_exists('date_default_timezone_set')) {
    @date_default_timezone_set($tz);
}

// Config de errores (desarrollo por ahora)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

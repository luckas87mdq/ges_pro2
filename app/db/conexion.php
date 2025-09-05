// archivo: app/db/conexion.php
<?php
declare(strict_types=1);

/**
 * Conexión MySQLi usando variables desde .env
 * Variables esperadas:
 *  DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS, DB_CHARSET
 */

require_once __DIR__ . '/../config/config.php';

$DB_HOST    = $_ENV['DB_HOST']    ?? '127.0.0.1';
$DB_PORT    = (int)($_ENV['DB_PORT'] ?? 3306);
$DB_NAME    = $_ENV['DB_NAME']    ?? 'ges_pro2';
$DB_USER    = $_ENV['DB_USER']    ?? 'root';
$DB_PASS    = $_ENV['DB_PASS']    ?? '';
$DB_CHARSET = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if (!$conexion->set_charset($DB_CHARSET)) {
        throw new RuntimeException('No se pudo setear el charset: ' . $DB_CHARSET);
    }
} catch (Throwable $e) {
    // Log mínimo a archivos locales (podemos mejorar luego)
    $logDir = $ROOT . '/logs';
    if (!is_dir($logDir)) { @mkdir($logDir, 0775, true); }
    @file_put_contents(
        $logDir . '/db_error_' . date('Ymd') . '.log',
        '[' . date('H:i:s') . '] ' . $e->getMessage() . PHP_EOL,
        FILE_APPEND
    );
    // Mensaje genérico (no filtrar credenciales)
    http_response_code(500);
    exit('Error de base de datos. Revisá la configuración.');
}

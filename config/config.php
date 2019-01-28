<?php declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define('APP_ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);
define('SRC_ROOT', APP_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('CACHE_ROOT', APP_ROOT . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR);

// Load .env settings
if (is_readable(APP_ROOT . '.env') === false) {
    // if .env file is not present inside the root of our application dir or if the file is not readable, show an error
    header('Content-Type: text/plain');
    echo 'Could not start: please check configuration file  ' . APP_ROOT . '.env ' . PHP_EOL . 'Error code: 171' . PHP_EOL;
    exit;
}

$dotenv = Dotenv::create(APP_ROOT);
$dotenv->load();

try {
    $dotenv->required([
        'DEBUG',
        'APP_NAME',
        'CRAWLERA_CERTIFICATE',
        'CRAWLERA_API_KEY',
    ]);
} catch (Exception $e) {
    echo 'Could not start: missing configuration setting please check configuration' . PHP_EOL . 'Error code: 172' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit;
}

define('DEBUG', $_ENV['DEBUG']);
define('APP_NAME', $_ENV['APP_NAME']);
define('CRAWLERA_CERTIFICATE', $_ENV['CRAWLERA_CERTIFICATE']);
define('CRAWLERA_API_KEY', $_ENV['CRAWLERA_API_KEY']);

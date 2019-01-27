<?php declare(strict_types=1);

use League\Container\Container;

$container = new Container;

require __DIR__ . '/di/infra.php';
require __DIR__ . '/di/commandBus.php';
require __DIR__ . '/di/scraper.php';

return $container;

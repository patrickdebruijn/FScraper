<?php


use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\FilterHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


try {

    $fileHandler = new RotatingFileHandler(APP_ROOT . 'logs' . DIRECTORY_SEPARATOR . 'scraper.log', Logger::WARNING);
    $consoleHandler = new ErrorLogHandler();

    $stderrHandler = new StreamHandler("php://stderr", Logger::ERROR);
    $stdoutHandler = new FilterHandler(
        new StreamHandler("php://stdout", Logger::DEBUG),
        [Logger::DEBUG, Logger::INFO, Logger::NOTICE, Logger::WARNING]
    );

    $container
        ->share('app.infrastructure.logger', Logger::class)
        ->addArgument(APP_NAME)
        ->addArgument([
            $fileHandler,
            $consoleHandler,
        ]);

} catch (\Throwable $e) {
    exit($e->getMessage());
}



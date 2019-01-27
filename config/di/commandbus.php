<?php

use FScraper\Commands\ParsePageCommand;
use FScraper\Handlers\ParsePageHandler;
use League\Event\Emitter;
use League\Tactician\CommandBus;
use League\Tactician\CommandEvents\Event\CommandFailed;
use League\Tactician\CommandEvents\EventMiddleware;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Logger\Formatter\ClassPropertiesFormatter;
use League\Tactician\Logger\LoggerMiddleware;
use League\Tactician\Plugins\LockingMiddleware;
use Psr\Log\LogLevel;

//Commands
$container->share(ParsePageCommand::class);

//Handlers
$container->share(ParsePageHandler::class)
    ->addArgument($container->get('app.infrastructure.logger'));

//CommandHandlerMap
$container->add(
    'app.commandHandlerMap',
    [
        ParsePageCommand::class => ParsePageHandler::class,
    ]
);

$container
    ->add(HandleInflector::class);

$container
    ->add(ClassNameExtractor::class);

$container
    ->add(ClassPropertiesFormatter::class)
    ->addArgument(LogLevel::DEBUG)
    ->addArgument(LogLevel::INFO)
    ->addArgument(LogLevel::CRITICAL);

$container
    ->add(ContainerLocator::class)
    ->addArgument($container)
    ->addArgument($container->get('app.commandHandlerMap'));

$container
    ->add(CommandHandlerMiddleware::class)
    ->addArgument($container->get(ClassNameExtractor::class))
    ->addArgument($container->get(ContainerLocator::class))
    ->addArgument($container->get(HandleInflector::class));

$container
    ->add(LoggerMiddleware::class)
    ->addArgument($container->get(ClassPropertiesFormatter::class))
    ->addArgument($container->get('app.infrastructure.logger'));

$container
    ->add(LockingMiddleware::class);


$container
    ->add(Emitter::class);

$container
    ->add(EventMiddleware::class)
    ->addArgument($container->get(Emitter::class))
    ->addMethodCall('addListener', [
        'command.failed',
        function (CommandFailed $event) {
            // log the failure
            $event->catchException(); // without calling this the exception will be thrown
        },
    ]);

$container
    ->add(CommandBus::class)
    ->addArgument([
        $container->get(LoggerMiddleware::class),
        $container->get(EventMiddleware::class),
        $container->get(LockingMiddleware::class),
        $container->get(CommandHandlerMiddleware::class),
    ]);

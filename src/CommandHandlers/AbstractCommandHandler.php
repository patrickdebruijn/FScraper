<?php

namespace FScraper\CommandHandlers;

use Psr\Log\LoggerInterface;

/**
 * Class AbstractCommandHandler
 */
abstract class AbstractCommandHandler
{
    protected $logger;

    /**
     * AbstractCommandHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

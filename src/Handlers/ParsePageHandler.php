<?php

namespace FScraper\Handlers;

use FScraper\Commands\ParsePageCommand;
use FScraper\Modules\Scraper\Scraper;
use Psr\Log\LoggerInterface;

/**
 * Class ParsePageHandler
 *
 * @package Scraper\Handlers
 */
final class ParsePageHandler extends AbstractCommandHandler
{
    private $scraper;

    /**
     * ParsePageHandler constructor.
     *
     * @param LoggerInterface $logger
     * @param Scraper         $scraper
     */
    public function __construct(LoggerInterface $logger, Scraper $scraper)
    {
        $this->scraper = $scraper;
        parent::__construct($logger);
    }

    /**
     * @param ParsePageCommand $command
     */
    public function handle(ParsePageCommand $command)
    {
        $this->scraper->crawl(
            $command->url()->toString(),
            $command->templateName()->toString(),
            $command->method()->toString(),
            $command->data()->toArray(),
            );
    }
}

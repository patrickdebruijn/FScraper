<?php

namespace FScraper\CommandHandlers;

use FScraper\Commands\ParseHomeDetailPageCommand;
use FScraper\Modules\Scraper\Scraper;
use Psr\Log\LoggerInterface;

/**
 * Class ParseHomeDetailPageHandler
 *
 * @package Scraper\CommandHandlers
 */
final class ParseHomeDetailPageHandler extends AbstractCommandHandler
{
    private $scraper;

    /**
     * ParseHomeDetailPageHandler constructor.
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
     * @param ParseHomeDetailPageCommand $command
     */
    public function handle(ParseHomeDetailPageCommand $command)
    {
        $page = [
            'url' => $command->url()->toString(),
            'data' => $this->scraper->crawl(
	            $command->url ()->toString (),
	            'HomeDetailPage',
	            $command->method ()->toString (),
	            $command->data ()->toArray ()
                ),
            'time' => time(),
        ];

        //@TODO: Fire event HomeDetailPageWasAdded or  HomeDetailPageWasUpdated after saving to db via respositories.
        //@TODO: Make Repository via maybe some kind of orm? what todo with models?
        //@TODO: Implement EventBus, + producer/listener for events + listen to own events
    }
}

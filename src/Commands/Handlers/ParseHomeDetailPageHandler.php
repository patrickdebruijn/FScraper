<?php

namespace FScraper\Commands\Handlers;

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
	    print_r ($page);
	    exit;

        //@TODO: Fire event HomeDetailPageWasAdded or  HomeDetailPageWasUpdated after saving to db via respositories.
        //@TODO: Make Repository via maybe some kind of orm? what todo with models?
        //@TODO: Implement EventBus, + producer/listener for events + listen to own events
	    //@TODO: Api + middleware access for rest commands? or do that in a seperate broker service? ( Decide, 1 service or multiple, what are th boundries/ domains? Howto handle queries?
	    // no event store, but yes cqrs, see commands as tasks, need access to fire commands via 2 ways: Rest api (broker?) / Schedular Service to multiple services.

    }
}

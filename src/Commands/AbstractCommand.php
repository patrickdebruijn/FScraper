<?php

namespace FScraper\Commands;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand
{
    protected $logger;

    protected $metadata;

    protected $payload;


    /**
     * @param array $payload
     * @param array $metadata
     */
    public function setPayload(array $payload, array $metadata = []): void
    {
        $this->metadata = $metadata;
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function payload(): array
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}

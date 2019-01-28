<?php

namespace FScraper\Commands;

use FScraper\Models\Generic\Data;
use FScraper\Models\Generic\Method;
use FScraper\Models\Generic\Url;

/**
 * Class ParsePageCommand
 */
class ParseHomeDetailPageCommand extends AbstractCommand
{
    protected $url;

    protected $method;

    protected $data;

    /**
     * @return Url
     */
    public function url(): Url
    {
        if ($this->url === null) {
            if (!array_key_exists('url', $this->payload)) {
                //@TODO Throw CommandIsMissingDataException::withCommand(self,'url');
            }
            $this->url = Url::fromString($this->payload['url']);
        }

        return $this->url;
    }


    /**
     * @return Method
     */
    public function method(): Method
    {
        if ($this->method === null) {
            $this->method = Method::fromString($this->payload['method'] ?? 'GET');
        }

        return $this->method;
    }

    /**
     * @return Data
     */
    public function data(): Data
    {
        if ($this->data === null) {
            $this->data = Data::fromArray($this->payload['data'] ?? []);
        }

        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url()->toString(),
            'method' => $this->method()->toString(),
            'data' => $this->data()->toArray(),
        ];
    }
}

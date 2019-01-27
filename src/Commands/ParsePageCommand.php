<?php

namespace FScraper\Commands;

use FScraper\Models\Generic\Data;
use FScraper\Models\Generic\Method;
use FScraper\Models\Generic\TemplateName;
use FScraper\Models\Generic\Url;

/**
 * Class ParsePageCommand
 */
class ParsePageCommand extends AbstractCommand
{
    protected $url;

    protected $templateName;

    protected $method;

    protected $data;

    /**
     * @return Url
     */
    public function url(): Url
    {
        if ($this->url === NULL) {
            $this->url = Url::fromString($this->payload['url']);
        }

        return $this->url;
    }

    /**
     * @return TemplateName
     */
    public function templateName(): TemplateName
    {
        if ($this->templateName === NULL) {
            $this->templateName = TemplateName::fromString($this->payload['templateName']);
        }

        return $this->templateName;
    }

    /**
     * @return Method
     */
    public function method(): Method
    {
        if ($this->method === NULL) {
            $this->method = Method::fromString($this->payload['method']);
        }

        return $this->method;
    }

    /**
     * @return Data
     */
    public function data(): Data
    {
        if ($this->data === NULL) {
            $this->data = Data::fromString($this->payload['data']);
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
            'templateName' => $this->templateName()->toString(),
            'method' => $this->method()->toString(),
            'data' => $this->data()->toArray(),
        ];
    }
}

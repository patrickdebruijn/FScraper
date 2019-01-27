<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class Url
 *
 * @package FScraper\Models\Generic
 */
final class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     *
     * @return Url
     */
    public static function fromString(string $url): self
    {
        return new self($url);
    }

    /**
     * Url constructor.
     *
     * @param string $url
     */
    private function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->url;
    }
}

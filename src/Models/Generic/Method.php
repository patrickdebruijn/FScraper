<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class Method
 *
 * @package FScraper\Models\Generic
 */
final class Method
{
    /**
     * @var string
     */
    private $method;

    /**
     * @param string $method
     *
     * @return Method
     */
    public static function fromString(string $method): self
    {
        return new self($method);
    }

    /**
     * Method constructor.
     *
     * @param string $method
     */
    private function __construct(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->method;
    }
}

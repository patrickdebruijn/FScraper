<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class Data
 *
 * @package FScraper\Models\Generic
 */
final class Data
{
    /**
     * @var string
     */
    private $data;

    /**
     * Data constructor.
     *
     * @param array $data
     */
    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $data
     *
     * @return Data
     */
    public static function fromString(string $data): self
    {
        return new self(\json_decode($data, true));
    }

    /**
     * @param array $data
     *
     * @return Data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }


    /**
     * @return string
     */
    public function toString(): string
    {
        return \json_encode($this->data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}

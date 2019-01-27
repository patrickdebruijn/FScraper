<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class DateUpdated
 *
 * @package FScraper\Models\Generic
 */
final class DateUpdated
{
    /**
     * @var \DateTimeImmutable
     */
    private $dateUpdated;

    /**
     * @param string $dateUpdated
     * @param string $format
     *
     * @return DateUpdated
     * @throws \Exception
     */
    public static function fromString(?string $dateUpdated = NULL, string $format = 'Y-m-d H:i:s'): self
    {
        if ($dateUpdated === NULL) {
            $date = new \DateTimeImmutable();
        } else {
            $date = \DateTimeImmutable::createFromFormat($format, $dateUpdated);
        }

        return new self($date);
    }

    /**
     * DateUpdated constructor.
     *
     * @param \DateTimeImmutable $dateUpdated
     */
    private function __construct(\DateTimeImmutable $dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function toString(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->dateUpdated->format($format);
    }
}

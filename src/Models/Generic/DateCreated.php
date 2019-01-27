<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class DateCreated
 *
 * @package FScraper\Models\Generic
 */
final class DateCreated
{
    /**
     * @var \DateTimeImmutable
     */
    private $dateCreated;

    /**
     * @param string $dateCreated
     * @param string $format
     *
     * @return DateCreated
     * @throws \Exception
     */
    public static function fromString(string $dateCreated = NULL, string $format = 'Y-m-d H:i:s'): self
    {
        if ($dateCreated === NULL) {
            $date = new \DateTimeImmutable();
        } else {
            $date = \DateTimeImmutable::createFromFormat($format, $dateCreated);
        }

        return new self($date);
    }

    /**
     * DateCreated constructor.
     *
     * @param \DateTimeImmutable $dateCreated
     */
    private function __construct(\DateTimeImmutable $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function toString(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->dateCreated->format($format);
    }
}

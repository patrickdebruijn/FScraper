<?php declare(strict_types=1);


namespace FScraper\Models\Generic;

/**
 * Class TemplateName
 *
 * @package FScraper\Models\Generic
 */
final class TemplateName
{
    /**
     * @var string
     */
    private $templateName;

    /**
     * @param string $templateName
     *
     * @return TemplateName
     */
    public static function fromString(string $templateName): self
    {
        return new self($templateName);
    }

    /**
     * TemplateName constructor.
     *
     * @param string $templateName
     */
    private function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->templateName;
    }
}

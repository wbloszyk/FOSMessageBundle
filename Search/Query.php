<?php

namespace FOS\MessageBundle\Search;

/**
 * Search term.
 */
class Query
{

    protected ?string $original = null;

    protected ?string $escaped = null;

    public function __construct(?string $original, ?string $escaped)
    {
        $this->original = $original;
        $this->escaped = $escaped;
    }

    public function getOriginal(): ?string
    {
        return $this->original;
    }

    public function setOriginal(?string $original): void
    {
        $this->original = $original;
    }

    public function getEscaped(): ?string
    {
        return $this->escaped;
    }

    public function setEscaped(?string $escaped): void
    {
        $this->escaped = $escaped;
    }

    /**
     * Converts to the original term string.
     */
    public function __toString(): string
    {
        return (string) $this->getOriginal();
    }

    public function isEmpty(): bool
    {
        return empty($this->original);
    }
}

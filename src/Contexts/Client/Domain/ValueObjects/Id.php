<?php

declare(strict_types=1);

namespace App\Contexts\Client\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class Id
{

    public function __construct(private string $value)
    {
        if (!$this->isValid($value)) {
            throw new InvalidArgumentException('Value is not valid.');
        }
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::generate());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isValid(string $value): bool
    {
        return preg_match(
                '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
                $value
            ) === 1;
    }

    public function equals(Id $other): bool
    {
        return $this->value === $other->value;
    }

}

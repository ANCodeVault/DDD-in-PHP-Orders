<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;

readonly class Quantity
{

    private int $value;

    public function __construct(int $value)
    {
        $this->isValid($value);
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromQuantity(int $value): self
    {
        return new self($value);
    }

    public function multiply(int $factor): self
    {
        return new self($this->value() * $factor);
    }

    public function divide(int $divisor): self
    {
        if ($divisor === 0) {
            throw new InvalidArgumentException('Division by zero.');
        }
        return new self(intdiv($this->value(), $divisor));
    }

    public function add(int $value): self
    {
        $newValue = $this->value() + $value;

        return new self($newValue);
    }

    public function subtract(int $value): self
    {
        $newValue = $this->value() - $value;

        if ($newValue < 0) {
            throw new InvalidArgumentException('Resulting quantity cannot be negative.');
        }

        return new self($newValue);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isGreaterThan(self $other): bool
    {
        return $this->value() > $other->value();
    }

    public function isLessThan(self $other): bool
    {
        return $this->value() < $other->value();
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    private function isValid(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Quantity cannot be negative.');
        }

        $this->value = $value;
    }

}

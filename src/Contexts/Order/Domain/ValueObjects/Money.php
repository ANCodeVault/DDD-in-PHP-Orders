<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class Money
{

    public function __construct(
        private float $value,
        private Currency $currency,
    ) {}

    public static function fromMoney(Money $money): self
    {
        return new self(
            $money->amount(),
            $money->currency(),
        );
    }

    public static function ofCurrency(Currency $currency): self
    {
        return new self(
            0,
            $currency,
        );
    }

    public function amount(): float
    {
        return $this->value;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function increaseAmountBy(float $amount): self
    {
        return new self(
            $this->amount() + $amount,
            $this->currency(),
        );
    }

    public function decreaseAmountBy(float $amount): self
    {
        return new self(
            $this->amount() - $amount,
            $this->currency(),
        );
    }

    public function multiply(float $factor): self
    {
        return new self(
            $this->amount() * $factor,
            $this->currency()
        );
    }

    public function divide(float $divisor): self
    {
        if ($divisor === 0.0) {
            throw new InvalidArgumentException('Division by zero.');
        }

        return new self(
            $this->amount() / $divisor,
            $this->currency()
        );
    }

    public function equals(Money $other): bool
    {
        return $this->amount() === $other->amount() && $this->currency()->equals($other->currency());
    }

    public function compareTo(Money $other): int
    {
        if (!$this->currency()->equals($other->currency())) {
            throw new InvalidArgumentException('Cannot compare Money with different currencies.');
        }

        return $this->amount() <=> $other->amount();
    }

}

<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;

final class Currency
{

    private static array $validCurrencies = [
        'USD' => 'US Dollar',
        'EUR' => 'Euro',
        'GBP' => 'British Pound',
        'JPY' => 'Japanese Yen',
        'RUB' => 'Russian Ruble',
    ];

    private string $code;

    private string $name;

    public function __construct(string $code)
    {
        $this->setCode($code);
    }

    public static function create(string $code): self
    {
        return new self($code);
    }

    private function setCode(string $code): void
    {
        $normalizedCode = strtoupper($code);

        $this->validateCode($normalizedCode);

        $this->code = $normalizedCode;
        $this->name = self::$validCurrencies[$normalizedCode];
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function getNameByCode(string $code): string
    {
        return self::getValidCurrencies()[$code];
    }

    public static function getValidCurrencies(): array
    {
        return self::$validCurrencies;
    }

    private function validateCode(string $code): void
    {
        if (!array_key_exists($code, self::getValidCurrencies())) {
            throw new InvalidArgumentException("Invalid currency code: $code");
        }
    }

    public function equals(Currency $other): bool
    {
        return $this->code() === $other->code();
    }

}

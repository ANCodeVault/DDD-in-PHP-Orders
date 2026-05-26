<?php

declare(strict_types=1);

namespace App\Contexts\Client\Domain\ValueObjects;

final readonly class Name
{

    public function __construct(
        private string $lastName,
        private string $firstName,
        private string $middleName,
    ) {}

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function middleName(): string
    {
        return $this->middleName;
    }

    public function fullName(): string
    {
        return trim($this->lastName() . ' ' . $this->firstName() . ' ' . $this->middleName());
    }

}

<?php

declare(strict_types=1);

namespace App\Contexts\Client\Domain\ValueObjects;

final readonly class Address
{

    public function __construct(
        private string $country,
        private ?string $region,
        private string $city,
        private string $street,
        private string $house,
    ) {}

    public function country(): string
    {
        return $this->country;
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function house(): string
    {
        return $this->house;
    }

    public function equals(Address $other): bool
    {
        return $this->country() === $other->country()
            && $this->region() === $other->region()
            && $this->city() === $other->city()
            && $this->street() === $other->street()
            && $this->house() === $other->house();
    }

}

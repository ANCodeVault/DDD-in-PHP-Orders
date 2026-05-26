<?php

declare(strict_types=1);

namespace App\Contexts\Client\Domain\ValueObjects;

use Ramsey\Uuid\Uuid as RUuid;

final class Uuid
{

    public function __construct(private ?string $value = null)
    {
        $this->value = $value ?? RUuid::uuid4()->toString();
    }

    public static function generate(): string
    {
        return Ruuid::uuid4()->toString();
    }

    public function value(): string
    {
        return $this->value;
    }

}

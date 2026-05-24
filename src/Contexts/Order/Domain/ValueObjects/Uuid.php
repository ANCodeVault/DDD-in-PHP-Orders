<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use Ramsey\Uuid\Uuid as RUuid;

class Uuid
{

    public function __construct(private ?string $value = null)
    {
        $this->value = $value ?? RUuid::uuid4()->toString();
    }

    public static function generate(): string
    {
        return RUuid::uuid4()->toString();
    }

    public function getValue(): string
    {
        return $this->value;
    }

}

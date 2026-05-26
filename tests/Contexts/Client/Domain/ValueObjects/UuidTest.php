<?php

declare(strict_types=1);

namespace Tests\Contexts\Client\Domain\ValueObjects;

use App\Contexts\Client\Domain\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{

    public function test_get_value_object_uuid(): void
    {
        $uuid = new Uuid();

        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function test_from_string(): void
    {
        $this->assertSame(
            'ff6f8cb0-c57d-11e1-9b21-0800200c9a66',
            new Uuid('ff6f8cb0-c57d-11e1-9b21-0800200c9a66')->value()
        );
    }

}

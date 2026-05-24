<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;
use App\Contexts\Order\Domain\ValueObjects\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{

    private string $id = 'a57024e7-8ba0-419e-bbb7-5915b17de1c4';

    public function test_generate_returns_valid_uuid(): void
    {
        $id = Id::generate();

        $this->assertInstanceOf(Id::class, $id);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
            $id->value()
        );
    }

    public function test_from_string_creates_valid_id(): void
    {
        $id = Id::fromString($this->id);

        $this->assertSame($this->id, $id->value());
        $this->assertEquals($this->id, (string)$id);
    }

    public function test_invalid_uuid_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Id('invalid-uuid');
    }

    public function test_equals_returns_true_for_same_id(): void
    {
        $id1 = Id::fromString($this->id);
        $id2 = Id::fromString($this->id);

        $this->assertTrue($id1->equals($id2));
    }

    public function test_equals_returns_false_for_different_id(): void
    {
        $id1 = Id::generate();
        $id2 = Id::generate();

        $this->assertFalse($id1->equals($id2));
    }

    public function test_to_string_returns_value(): void
    {
        $id = Id::fromString($this->id);

        $this->assertSame($this->id, (string)$id);
    }

}

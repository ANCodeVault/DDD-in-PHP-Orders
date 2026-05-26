<?php

declare(strict_types=1);

namespace Tests\Contexts\Client\Domain\ValueObjects;

use App\Contexts\Client\Domain\ValueObjects\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{

    public function test_get_last_first_middle_name(): void
    {
        $client = new Name('LastName', 'FirstName', 'MiddleName');

        $this->assertSame('LastName', $client->lastName());
        $this->assertSame('FirstName', $client->firstName());
        $this->assertSame('MiddleName', $client->middleName());
    }

    public function test_get_full_name(): void
    {
        $client = new Name('LastName', 'FirstName', 'MiddleName');

        $this->assertSame('LastName FirstName MiddleName', $client->fullName());
    }

    public function test_get_not_full_name(): void
    {
        $client = new Name('', 'FirstName', '');

        $this->assertSame('FirstName', $client->fullName());
    }

}

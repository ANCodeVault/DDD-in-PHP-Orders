<?php

declare(strict_types=1);

namespace Tests\Contexts\Client\Domain\ValueObjects;

use App\Contexts\Client\Domain\ValueObjects\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    public function test_address_properties(): void
    {
        $address = new Address('Country', 'Region', 'City', 'Street', '2-2');

        $this->assertSame('Country', $address->country());
        $this->assertSame('Region', $address->region());
        $this->assertSame('City', $address->city());
        $this->assertSame('Street', $address->street());
        $this->assertSame('2-2', $address->house());
    }

    public function test_address_with_null_region_property(): void
    {
        $address = new Address('Country', null, 'City', 'Street', '2-2');

        $this->assertNull($address->region());
    }

    public function test_equals_method(): void
    {
        $address1 = new Address('Country', 'Region', 'City', 'Street', '2-2');
        $address2 = new Address('Country', 'Region', 'City', 'Street', '2-2');
        $address3 = new Address('Country 1', 'Region 1', 'City 1', 'Street', '2-2');

        $this->assertTrue($address1->equals($address2));
        $this->assertFalse($address1->equals($address3));
    }

}

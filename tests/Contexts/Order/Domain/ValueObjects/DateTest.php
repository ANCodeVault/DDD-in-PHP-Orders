<?php

namespace Tests\Contexts\Order\Domain\ValueObjects;

use DateTimeImmutable;
use App\Contexts\Order\Domain\ValueObjects\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{

    public function test_constructor_with_custom_dates(): void
    {
        $createdAt = new DateTimeImmutable('2025-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-02 12:00:00');

        $date = new Date($createdAt, $updatedAt);

        $this->assertSame($createdAt, $date->createdAt());
        $this->assertSame($updatedAt, $date->updatedAt());
    }

    public function test_created_and_updated_at(): void
    {
        $date = new Date();

        $this->assertInstanceOf(DateTimeImmutable::class, $date->createdAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $date->updatedAt());
    }

    public function test_touch():void
    {
        $date = new Date();
        $oldUpdatedAt = $date->updatedAt();

        sleep(1);
        $date->touch();

        $this->assertNotSame($oldUpdatedAt, $date->updatedAt());
    }

    public function test_touch_updates_updated_at(): void
    {
        $initialUpdatedAt = new DateTimeImmutable('-1 day');
        $date = new Date(null, $initialUpdatedAt);

        $date->touch();

        $this->assertGreaterThan($initialUpdatedAt, $date->updatedAt());
    }

    public function test_is_before_and_is_after(): void
    {
        $date1 = new Date(new DateTimeImmutable('2025-01-01'));
        $date2 = new Date(new DateTimeImmutable('2025-01-02'));

        $this->assertTrue($date1->isBefore($date2));
        $this->assertFalse($date2->isBefore($date1));

        $this->assertTrue($date2->isAfter($date1));
        $this->assertFalse($date1->isAfter($date2));
    }

    public function test_is_past(): void
    {
        $pastDate = new Date(new DateTimeImmutable('-1 day'));
        $futureDate = new Date(new DateTimeImmutable('+1 day'));

        $this->assertTrue($pastDate->isPast());
        $this->assertFalse($futureDate->isPast());
    }

    public function test_get_interval_in_seconds(): void
    {
        $createdAt = new DateTimeImmutable('2025-01-01 00:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-01 00:00:10');
        $date = new Date($createdAt, $updatedAt);

        $interval = $date->getIntervalInSeconds();

        $this->assertSame(10, $interval);
    }

    public function test_equals(): void
    {
        $createdAt = new DateTimeImmutable('2025-01-01 00:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-01 00:00:00');

        $date1 = new Date($createdAt, $updatedAt);
        $date2 = new Date($createdAt, $updatedAt);

        $date3 = new Date(new DateTimeImmutable('2025-01-02'), new DateTimeImmutable('2025-01-02'));

        $this->assertTrue($date1->equals($date2));
        $this->assertFalse($date1->equals($date3));
    }

    public function test_format_created_and_update_dat(): void
    {
        $createdAt = new DateTimeImmutable('2025-01-01 12:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-02 13:30:45');

        $date = new Date($createdAt, $updatedAt);

        $this->assertSame('2025-01-01 12:00:00', $date->formatCreatedAt());
        $this->assertSame('2025-01-02 13:30:45', $date->formatUpdatedAt());

        $this->assertSame('2025-01-01', $date->formatCreatedAt(Date::FORMAT_DATE));
        $this->assertSame('13:30:45', $date->formatUpdatedAt(Date::FORMAT_TIME));
    }

    public function test_to_array(): void
    {
        $createdAt = new DateTimeImmutable('2025-01-01 12:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-02 13:30:45');

        $date = new Date($createdAt, $updatedAt);
        $array = $date->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertSame($createdAt->format(Date::FORMAT_DATETIME), $array['created_at']);
        $this->assertSame($updatedAt->format(Date::FORMAT_DATETIME), $array['updated_at']);
    }

}

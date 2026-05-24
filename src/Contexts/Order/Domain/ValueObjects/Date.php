<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use DateTimeImmutable;

class Date
{

    public const string FORMAT_DATETIME = 'Y-m-d H:i:s';
    public const string FORMAT_DATE = 'Y-m-d';
    public const string FORMAT_TIME = 'H:i:s';

    public function __construct(
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt  = null
    )
    {
        $this->createdAt = $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $this->updatedAt ?? new DateTimeImmutable();
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isBefore(self $other): bool
    {
        return $this->createdAt() < $other->createdAt();
    }

    public function isAfter(self $other): bool
    {
        return $this->createdAt() > $other->createdAt();
    }

    public function isPast(): bool
    {
        return ($this->createdAt() < new DateTimeImmutable('now'));
    }

    public function getIntervalInSeconds(): int
    {
        return abs($this->createdAt()->getTimestamp() - $this->updatedAt()->getTimestamp());
    }

    public function equals(self $other): bool
    {
        return $this->createdAt()->getTimestamp() === $other->createdAt()->getTimestamp()
            && $this->updatedAt()->getTimestamp() === $other->updatedAt()->getTimestamp();
    }

    public function formatCreatedAt(string $format = self::FORMAT_DATETIME): string
    {
        return $this->createdAt()->format($format);
    }

    public function formatUpdatedAt(string $format = self::FORMAT_DATETIME): string
    {
        return $this->updatedAt()->format($format);
    }

    public function toArray(): array
    {
        return [
            'created_at' => $this->createdAt()->format(self::FORMAT_DATETIME),
            'updated_at' => $this->updatedAt()->format(self::FORMAT_DATETIME),
        ];
    }

}

<?php

declare(strict_types=1);

namespace App\Contexts\Order\Domain\ValueObjects;

use App\Contexts\Order\Enums\OrderStatusConstants;

readonly class OrderStatus
{

    private OrderStatusConstants $status;

    public function __construct(OrderStatusConstants $status)
    {
        $this->status = $status;
    }

    public static function create(OrderStatusConstants $status): self
    {
        return new self($status);
    }

    public function getStatus(): OrderStatusConstants
    {
        return $this->status;
    }

    public function isPaid(): bool
    {
        return $this->status === OrderStatusConstants::PAID;
    }

    public function isCanceled(): bool
    {
        return $this->status === OrderStatusConstants::CANCELED;
    }

    public function isPending(): bool
    {
        return $this->status === OrderStatusConstants::PENDING;
    }

    public function isShipped(): bool
    {
        return $this->status === OrderStatusConstants::SHIPPED;
    }

    public function isCompleted(): bool
    {
        return $this->status === OrderStatusConstants::COMPLETED;
    }

}

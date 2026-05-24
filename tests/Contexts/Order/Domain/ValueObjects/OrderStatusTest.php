<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Domain\ValueObjects;

use App\Contexts\Order\Domain\ValueObjects\OrderStatus;
use App\Contexts\Order\Enums\OrderStatusConstants;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{

    public function test_create_method_returns_new_order_status_instance(): void
    {
        $status = OrderStatus::create(OrderStatusConstants::PAID);

        $this->assertInstanceOf(OrderStatus::class, $status);
        $this->assertSame(OrderStatusConstants::PAID, $status->getStatus());
    }

    public function test_create_order_status_with_paid(): void
    {
        $status = new OrderStatus(OrderStatusConstants::PAID);

        $this->assertSame(OrderStatusConstants::PAID, $status->getStatus());
    }

    public function test_is_paid_returns_true_for_paid_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::PAID);

        $this->assertTrue($status->isPaid());
    }

    public function test_is_paid_returns_false_for_other_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::PENDING);

        $this->assertFalse($status->isPaid());
    }

    public function test_is_canceled_returns_true_for_canceled_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::CANCELED);

        $this->assertTrue($status->isCanceled());
    }

    public function test_is_pending_returns_true_for_pending_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::PENDING);

        $this->assertTrue($status->isPending());
    }

    public function test_is_shipped_returns_true_for_shipped_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::SHIPPED);

        $this->assertTrue($status->isShipped());
    }

    public function test_is_completed_returns_true_for_completed_status(): void
    {
        $status = new OrderStatus(OrderStatusConstants::COMPLETED);

        $this->assertTrue($status->isCompleted());
    }

    public function test_get_status_returns_correct_enum(): void
    {
        $status = new OrderStatus(OrderStatusConstants::ERROR);

        $this->assertSame(OrderStatusConstants::ERROR, $status->getStatus());
    }

}

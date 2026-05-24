<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Enums;

use App\Contexts\Order\Enums\OrderStatusConstants;
use PHPUnit\Framework\TestCase;

class OrderStatusConstantsTest extends TestCase
{

    public function test_get_all_statuses_returns_all_values(): void
    {
        $allStatuses = OrderStatusConstants::getAllStatuses();

        $expected = ['pending', 'paid', 'shipped', 'canceled', 'completed', 'error'];

        $this->assertEquals($expected, $allStatuses);
    }

}

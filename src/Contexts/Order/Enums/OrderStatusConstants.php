<?php

declare(strict_types=1);

namespace App\Contexts\Order\Enums;

enum OrderStatusConstants: string
{

    case PENDING = 'pending';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';
    case ERROR = 'error';

    public static function getAllStatuses(): array
    {
        return array_map(
            fn($status) => $status->value,
            self::cases()
        );
    }

}

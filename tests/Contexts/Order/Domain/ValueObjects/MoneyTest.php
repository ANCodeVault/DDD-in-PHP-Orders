<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Domain\ValueObjects;

use App\Contexts\Order\Domain\ValueObjects\Currency;
use App\Contexts\Order\Domain\ValueObjects\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{

    public function test_of_currency(): void
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = $money1->ofCurrency($currency);


        $this->assertFalse($money1->equals($money2));
        $this->assertSame(0.0, $money2->amount());
    }

    public function test_from_money(): void
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = $money1->fromMoney(new Money(150, new Currency('RUB')));

        $this->assertFalse($money1->equals($money2));
    }

    public function test_increase_and_decrease_amount(): void
    {
        $currency = new Currency('USD');
        $money = new Money(100, $currency);

        $this->assertSame(100.0, $money->amount());

        $moreMoney = $money->increaseAmountBy(50);
        $this->assertSame(150., $moreMoney->amount());

        $lessMoney = $money->decreaseAmountBy(20);
        $this->assertSame(80., $lessMoney->amount());

        $this->assertSame(100., $money->amount());
    }

    public function test_equals_returns_true_for_same_values(): void
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = new Money(100, $currency);

        $this->assertTrue($money1->equals($money2));
    }

    public function test_equals_returns_false_for_different_values(): void
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = new Money(200, $currency);

        $this->assertFalse($money1->equals($money2));
    }

    public function test_compare_to_returns_correct_comparison(): void
    {
        $currency = new Currency('USD');
        $less = new Money(50, $currency);
        $more = new Money(100, $currency);

        $this->assertSame(-1, $less->compareTo($more));
        $this->assertSame(1, $more->compareTo($less));
        $this->assertSame(0, $less->compareTo(new Money(50, $currency)));
    }

    public function test_compare_to_throws_on_different_currencies(): void
    {
        $money1 = new Money(100, new Currency('USD'));
        $money2 = new Money(100, new Currency('EUR'));

        $this->expectException(\InvalidArgumentException::class);
        $money1->compareTo($money2);
    }

    public function test_multiply_and_divide(): void
    {
        $currency = new Currency('USD');
        $money = new Money(100, $currency);
        $multiplied = $money->multiply(2);
        $divided = $money->divide(2);

        $this->assertSame(200., $multiplied->amount());
        $this->assertSame(50., $divided->amount());
    }

    public function test_divide_by_zero_throws_exception(): void
    {
        $currency = new Currency('USD');
        $money = new Money(100., $currency);

        $this->expectException(\InvalidArgumentException::class);
        $money->divide(0);
    }

}

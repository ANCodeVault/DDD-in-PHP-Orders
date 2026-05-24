<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;
use App\Contexts\Order\Domain\ValueObjects\Quantity;
use PHPUnit\Framework\TestCase;

class QuantityTest extends TestCase
{
    
    public function test_create_zero_returns_quantity_zero(): void
    {
        $quantity = Quantity::zero();

        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame(0, $quantity->value());
    }

    public function test_create_from_quantity_returns_quantity_with_value(): void
    {
        $quantity = Quantity::fromQuantity(10);

        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame(10, $quantity->value());
    }

    public function test_create_negative_value_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity cannot be negative.');

        new Quantity(-5);
    }

    public function test_create_with_valid_value_does_not_throw(): void
    {
        $quantity = new Quantity(5);

        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame(5, $quantity->value());
    }

    public function test_create_add_method_returns_new_quantity(): void
    {
        $quantity = Quantity::fromQuantity(5);
        $newQuantity = $quantity->add(3);

        $this->assertInstanceOf(Quantity::class, $newQuantity);
        $this->assertSame(8, $newQuantity->value());
        // исходный объект не изменится
        $this->assertSame(5, $quantity->value());
    }

    public function test_create_subtract_method_returns_new_quantity(): void
    {
        $quantity = Quantity::fromQuantity(10);
        $newQuantity = $quantity->subtract(4);

        $this->assertInstanceOf(Quantity::class, $newQuantity);
        $this->assertSame(6, $newQuantity->value());
        // исходный объект не изменится
        $this->assertSame(10, $quantity->value());
    }

    public function test_create_subtract_method_with_result_negative_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Resulting quantity cannot be negative.');

        $quantity = Quantity::fromQuantity(3);
        $quantity->subtract(5);
    }

    public function test_create_multiply_returns_new_quantity(): void
    {
        $quantity = Quantity::fromQuantity(4);
        $result = $quantity->multiply(3);

        $this->assertInstanceOf(Quantity::class, $result);
        $this->assertSame(12, $result->value());
    }

    public function test_create_divide_returns_new_quantity(): void
    {
        $quantity = Quantity::fromQuantity(10);
        $result = $quantity->divide(2);

        $this->assertInstanceOf(Quantity::class, $result);
        $this->assertSame(5, $result->value());
    }

    public function test_create_divide_by_zero_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Division by zero.');

        $quantity = Quantity::fromQuantity(10);
        $quantity->divide(0);
    }

    public function test_create_isGreaterThan_true_when_greater(): void
    {
        $quantity1 = Quantity::fromQuantity(10);
        $quantity2 = Quantity::fromQuantity(5);

        $this->assertTrue($quantity1->isGreaterThan($quantity2));
    }

    public function test_create_isGreaterThan_false_when_not_greater(): void
    {
        $quantity1 = Quantity::fromQuantity(5);
        $quantity2 = Quantity::fromQuantity(10);

        $this->assertFalse($quantity1->isGreaterThan($quantity2));
    }

    public function test_create_isLessThan_true_when_less(): void
    {
        $quantity1 = Quantity::fromQuantity(3);
        $quantity2 = Quantity::fromQuantity(8);

        $this->assertTrue($quantity1->isLessThan($quantity2));
    }

    public function test_create_isLessThan_false_when_not_less(): void
    {
        $quantity1 = Quantity::fromQuantity(8);
        $quantity2 = Quantity::fromQuantity(8);

        $this->assertFalse($quantity1->isLessThan($quantity2));
    }

    public function test_create_equals_true_for_equal_quantities(): void
    {
        $quantity1 = Quantity::fromQuantity(7);
        $quantity2 = Quantity::fromQuantity(7);

        $this->assertTrue($quantity1->equals($quantity2));
    }

    public function test_create_equals_false_for_different_quantities(): void
    {
        $quantity1 = Quantity::fromQuantity(7);
        $quantity2 = Quantity::fromQuantity(8);

        $this->assertFalse($quantity1->equals($quantity2));
    }
    
}

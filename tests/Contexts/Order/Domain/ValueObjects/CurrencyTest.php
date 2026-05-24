<?php

declare(strict_types=1);

namespace Tests\Contexts\Order\Domain\ValueObjects;

use InvalidArgumentException;
use App\Contexts\Order\Domain\ValueObjects\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{

    public function test_create_currency_with_valid_code(): void
    {
        $currency = Currency::create('USD');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame('USD', $currency->code());
        $this->assertSame('US Dollar', $currency->name());
    }

    public function test_get_name_by_code(): void
    {
        $code = new Currency('USD');

        $this->assertSame('USD', $code->code());

        $nameCode = $code->getNameByCode('RUB');

        $this->assertSame('Russian Ruble', $nameCode);
    }
    
    public function test_create_currency_with_lowercase_code(): void
    {
        $currency = Currency::create('eur');

        $this->assertSame('EUR', $currency->code());
        $this->assertSame('Euro', $currency->name());
    }
    
    public function test_create_currency_with_invalid_code(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Currency::create('XYZ');
    }
    
    public function test_create_currency_equals(): void
    {
        $currency1 = Currency::create('GBP');
        $currency2 = new Currency('GBP');

        $this->assertTrue($currency1->equals($currency2));
    }
    
    public function test_currencies_with_different_codes_not_equal(): void
    {
        $currency1 = Currency::create('USD');
        $currency2 = new Currency('EUR');

        $this->assertFalse($currency1->equals($currency2));
    }
    
    public function test_currency_name_matches_code(): void
    {
        $currency = Currency::create('GBP');

        $this->assertSame('British Pound', $currency->name());
    }
    
    public function test_get_valid_currencies(): void
    {
        $currencies = Currency::getValidCurrencies();

        $this->assertArrayHasKey('USD', $currencies);
        $this->assertSame('US Dollar', $currencies['USD']);

        $this->assertArrayHasKey('EUR', $currencies);
        $this->assertSame('Euro', $currencies['EUR']);

        $this->assertArrayHasKey('GBP', $currencies);
        $this->assertSame('British Pound', $currencies['GBP']);
    }
    
    public function test_create_currency_with_code_with_spaces_or_special_chars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Currency::create(' U S D ');
    }
    
    public function test_create_currency_with_special_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        Currency::create('US$');
    }

}

<?php

namespace Tests\Infrastructure\Http\RequestTest;

use App\Shared\Response;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    private DateTimeImmutable $timestamp;

    public function setUp(): void
    {
        $this->timestamp = DateTimeImmutable::createFromTimestamp(1703155440);
    }

    public function test_success_response(): void
    {

        $response = Response::success(['items' => ['item1', 'item2']])
            ->setTimestamp($this->timestamp)
            ->toArray();

        $expected = [
            'status' => 200,
            'message' => 'OK',
            'data' =>  ['items' => ['item1', 'item2']],
            'timestamp' => $this->timestamp,
            'meta' => [],
            'errors' => [],
        ];

        $this->assertSame($expected, $response);
    }

    public function test_error_response(): void
    {
        $response = Response::error()->setTimestamp($this->timestamp)->toArray();

        $expected = [
            'status' => 400,
            'message' => 'Error',
            'data' => [],
            'timestamp' => $this->timestamp,
            'meta' => [],
            'errors' => [],
        ];

        $this->assertSame($expected, $response);
    }

    public function test_meta_and_timestamp(): void
    {
        $response = Response::success(['foo1' => 'bar1'])
            ->setTimestamp($this->timestamp)
            ->setMeta(['foo2' => 'bar2'])
            ->toJson();

        $expected = '{
    "status": 200,
    "message": "OK",
    "data": {
        "foo1": "bar1"
    },
    "timestamp": {
        "date": "2023-12-21 10:44:00.000000",
        "timezone_type": 1,
        "timezone": "+00:00"
    },
    "meta": {
        "foo2": "bar2"
    },
    "errors": []
}';

        $this->assertSame($expected, $response);
    }

    public function test_setting_status_and_message(): void
    {
        $response = Response::success(['foo1' => 'bar1'])
            ->setTimestamp($this->timestamp)
            ->setMessage('Not Found')
            ->setStatusCode(404)
            ->toArray();

        $expected = [
            'status' => 404,
            'message' => 'Not Found',
            'data' => ['foo1' => 'bar1'],
            'timestamp' => $this->timestamp,
            'meta' => [],
            'errors' => [],
        ];

        $this->assertSame($expected, $response);
    }

    public function test_set_data(): void
    {
        $response = Response::success()
            ->setData(['foo1' => 'bar1'])
            ->setTimestamp($this->timestamp)
            ->toArray();

        $expected = [
            'status' => 200,
            'message' => 'OK',
            'data' =>  ['foo1' => 'bar1'],
            'timestamp' => $this->timestamp,
            'meta' => [],
            'errors' => [],
        ];

        $this->assertSame($expected, $response);
    }

    public function test_add_errors(): void
    {
        $response = Response::success(['foo1' => ''])
            ->addErrors(["Поле 'foo1' обязательно к заполнению"])
            ->setTimestamp($this->timestamp)
            ->toArray();

        $expected = [
            'status' => 200,
            'message' => 'OK',
            'data' =>  ['foo1' => ''],
            'timestamp' => $this->timestamp,
            'meta' => [],
            'errors' => ["Поле 'foo1' обязательно к заполнению"],
        ];

        $this->assertSame($expected, $response);
    }

    public function test_get_request_from_function(): void
    {
        $response = response();

        $this->assertInstanceOf(Response::class, $response);
    }

}

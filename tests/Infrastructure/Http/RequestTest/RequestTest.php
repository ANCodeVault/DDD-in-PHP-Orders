<?php

declare(strict_Types=1);

namespace Tests\Infrastructure\Http\RequestTest;

use App\Infrastructure\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    private array $server;
    private array $get;
    private array $post;
    private array $files;
    private string $jsonInput;

    public function setUp(): void
    {
        $this->server = [
            'REQUEST_METHOD' => 'POST',
            'HTTP_X_REQUESTED_WITH' => 'xmlhttprequest'
        ];

        $this->get = ['param1' => 'value1'];
        $this->post = ['field1' => 'data1'];
        $this->files = [
            'file1' => [
                'name' => 'test.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/phpYzdqkD',
                'error' => 0,
                'size' => 123
            ]
        ];

        $this->jsonInput = json_encode(['key1' => 'value1', 'key2' => 25]);
    }

    public function test_is_post(): void
    {
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,

        );

        $this->assertTrue($request->isPost());
    }

    public function test_is_get(): void
    {
        $this->server['REQUEST_METHOD'] = 'GET';
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $this->assertFalse($request->isPost());
        $this->assertTrue($request->isGet());
    }

    public function test_is_ajax(): void
    {
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $this->assertTrue($request->isAjax());

        // тест с отсутствующим заголовком
        unset($this->server['HTTP_X_REQUESTED_WITH']);

        $request2 = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $this->assertFalse($request2->isAjax());
    }

    public function test_get_upload_file(): void
    {
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $files = $request->getUploadedFiles();

        $this->assertSame($this->files, $files);
    }

    public function test_get_json_input(): void
    {
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $jsonData = $request->jsonInput();

        $expected = ['key1' => 'value1', 'key2' => 25];

        $this->assertSame($expected, $jsonData);
    }

    public function test_get_json_input_with_invalid_json(): void
    {
        $this->jsonInput = '{invalid json}';
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $jsonData = $request->jsonInput();

        $this->assertNull($jsonData);
    }

    public function test_get_method(): void
    {
        $this->server['REQUEST_METHOD'] = 'GET';
        $request = new Request(
            $this->server,
            $this->get,
            $this->post,
            $this->files,
            $this->jsonInput,
        );

        $this->assertSame('GET', $request->getMethod());
    }
    
    public function test_get_request_from_function(): void
    {
        $request = request();

        $this->assertInstanceOf(Request::class, $request);
    }

}

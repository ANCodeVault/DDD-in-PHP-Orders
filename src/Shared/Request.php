<?php

declare(strict_types=1);

namespace App\Shared;

class Request
{

    public function __construct(
        private readonly array $server = [],
        private readonly array $get = [],
        private readonly array $post = [],
        private readonly array $files = [],
        private mixed $input = null,
    )
    {
        $this->input = $input ?? file_get_contents('php://input');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'UNKNOWN';
    }

    public function isPost(): bool
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? '') === 'POST';
    }

    public function isGet(): bool
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? '') === 'GET';
    }

    public function isAjax(): bool
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->server['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
    }

    public function getUploadedFiles(): array
    {
        return $this->files;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function jsonInput(): mixed
    {
        return json_decode($this->input, true);
    }

}

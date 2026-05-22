<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use DateTimeImmutable;

class Response
{

    public function __construct(
        private int $statusCode = 200,
        private string $message = '',
        private array $data = [],
        private array $meta = [],
        private array $errors = [],
        private DateTimeImmutable $timestamp,
    ) {}

    public static function success(
        $data = [],
        $message = 'OK',
        $meta = []
    ): self
    {
        return new self(
            200,
            $message,
            $data,
            $meta,
            [],
            new DateTimeImmutable(),
        );
    }

    public static function error(
        $message = 'Error',
        $statusCode = 400,
        $errors = [],
        $meta = [],
    ): self
    {
        return new self(
            $statusCode,
            $message,
            [],
            $meta,
            $errors,
            new DateTimeImmutable(),
        );
    }

    public function setTimestamp(DateTimeImmutable $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function addErrors(array $error): self
    {
        $this->errors = $error;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function toArray(): array
    {
        return [
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data,
            'timestamp' => $this->timestamp,
            'meta' => $this->meta,
            'errors' => $this->errors
        ];
    }

}

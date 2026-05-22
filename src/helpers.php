<?php

declare(strict_types=1);


if (!function_exists('request')) {
    function request(): \App\Infrastructure\Http\Request
    {
        return new \App\Infrastructure\Http\Request(
            $_SERVER,
            $_GET,
            $_POST,
            $_FILES,
            file_get_contents('php://input') ?? null,
        );
    }
}

if (!function_exists('response')) {
    function response(): \App\Infrastructure\Http\Response
    {
        return new \App\Infrastructure\Http\Response(
            200,
            'OK',
            [],
            [],
            [],
            new DateTimeImmutable(),
        );
    }
}



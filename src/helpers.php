<?php

declare(strict_types=1);


if (!function_exists('request')) {
    function request(): \App\Shared\Request
    {
        return new \App\Shared\Request(
            $_SERVER,
            $_GET,
            $_POST,
            $_FILES,
            file_get_contents('php://input') ?? null,
        );
    }
}

if (!function_exists('response')) {
    function response(): \App\Shared\Response
    {
        return new \App\Shared\Response(
            200,
            'OK',
            [],
            [],
            [],
            new DateTimeImmutable(),
        );
    }
}



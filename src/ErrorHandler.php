<?php

use JetBrains\PhpStorm\NoReturn;

class ErrorHandler
{
    /**
     * @param Throwable $ex
     * @return void
     */
    public static function handleException(Throwable $ex): void
    {
        http_response_code(500);
        echo json_encode([
            'code'      => $ex->getCode(),
            'message'   => $ex->getMessage(),
            'file'      => $ex->getFile(),
            'line'      => $ex->getLine(),
        ]);
    }

    /**
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return bool
     * @throws ErrorException
     */
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    public static function showMessage(int $errorCode, array $errors): void
    {
        http_response_code($errorCode);
        echo json_encode($errors);
    }
}
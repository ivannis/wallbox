<?php

declare(strict_types=1);

namespace Common\UI\Http\Validation;

use Doblio\Domain\Exception\ErrorReason;
use Hyperf\Validation\ValidationException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidatorExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var ValidationException $throwable */
        $errors = [];

        foreach ($throwable->validator->errors()->keys() as $key) {
            if ($throwable->validator->errors()->has($key)) {
                $errors[$key] = $throwable->validator->errors()->first($key);
            }
        }

        $body = [
            'code' => 400,
            'message' => 'Bad request',
            'reason' => ErrorReason::UNPROCESSABLE_ENTITY(),
            'errors' => $errors
        ];

        return $response
            ->withStatus(400)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(json_encode($body)))
        ;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}

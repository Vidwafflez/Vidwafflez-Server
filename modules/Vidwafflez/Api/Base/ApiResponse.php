<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base;

class ApiResponse
{
    public readonly ApiResponseStatus $status;
    public readonly object $response;
    public string $reason;
    public array $errors;

    public function __construct(ApiResponseStatus $status, object $response = null)
    {
        $this->status = $status;

        if (null != $response) $this->response = $response;

        unset($this->reason);
        unset($this->errors);
    }

    public function setReason(string $message): void
    {
        $this->reason = $message;
    }

    public function pushErrors(array $errors): void
    {
        array_merge($this->errors, $errors);
    }

    public static function success($response): ApiResponse
    {
        return new self(ApiResponseStatus::SUCCESS, $response);
    }

    public static function failure($reason = null): ApiResponse
    {
        $result = new self(ApiResponseStatus::FAILURE);

        if (null != $reason);

        return $result;
    }
}
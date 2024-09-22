<?php

namespace DFiks\TBank\Payments;

use DFiks\TBank\Payments\Contracts\ApiResponse;
use Illuminate\Contracts\Support\Arrayable;

class Response implements ApiResponse, Arrayable
{
    public function __construct(protected array $data)
    {
    }

    public function getSuccess(): bool
    {
        return $this->data['Success'];
    }

    public function getErrorCode(): ?string
    {
        return $this->data['ErrorCode'] ?? null;
    }

    public function getMessage(): ?string
    {
        return $this->data['Message'] ?? null;
    }

    public function getDetails(): ?string
    {
        return $this->data['Details'] ?? null;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}

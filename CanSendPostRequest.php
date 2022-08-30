<?php
declare(strict_types=1);

namespace App\Services\Concerns;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

trait CanSendPostRequest
{
    public function post(PendingRequest $request, string $url, string $payload): Response
    {
        return $request->send(
           method: 'POST',
            url: $url,
            options: [
                'body' => $payload,
            ],
        );
    }
}
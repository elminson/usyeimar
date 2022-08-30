<?php
declare(strict_types=1);

namespace App\Services\Concerns;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

trait BuildBaseRequest
{
    public function buildBasewithBaseUrlShipping(): PendingRequest
    {
        return  $this->withBaseUrlShipping();
    }

    public function buildBasewithBaseUrlSettlement(): PendingRequest
    {
        return $this->withBaseUrlSettlement();
    }


    public function withBaseUrlShipping(): PendingRequest
    {
        return Http::baseUrl(
            url: $this->baseUrlShipping,
        )->withHeaders([
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',

        ]);
    }

    public function withBaseUrlSettlement(): PendingRequest
    {
        return Http::baseUrl(
            url: $this->baseUrlSettlement,
        )->withHeaders([
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',
        ]);
    }
}
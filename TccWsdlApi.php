<?php
declare(strict_types=1);
namespace App\Services\TccWSDL;
use App\Services\Concerns\BuildBaseRequest;
use App\Services\Concerns\CanSendGetRequest;
use App\Services\Concerns\CanSendPostRequest;
use App\Services\TccWSDL\Resources\ShippingResource;

class TccWsdlApi
{
    use BuildBaseRequest,
        CanSendGetRequest,
        CanSendPostRequest;

    public function __construct(
        private string $baseUrlShipping,
        private string $baseUrlSettlement
    ) {}


    public function shipping(): ShippingResource
    {
        return new ShippingResource(
          service:$this,
        );
    }
}
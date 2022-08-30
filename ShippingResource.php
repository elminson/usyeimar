<?php

namespace App\Services\TccWSDL\Resources;

use App\Services\TccWSDL\TccWsdlApi;
use Illuminate\Http\Client\Response;

class ShippingResource
{
    public function __construct(
        protected TccWsdlApi $service
    ) {}

        public function  addShipping(string $data): Response
        {
            return  $this->service->post(
               request:$this->service->buildBasewithBaseUrlShipping(),
                url: '',
                payload: $data
            );
        }

    public function cancelShipping(string $data): Response
    {
        return  $this->service->post(
            request:$this->service->buildBasewithBaseUrlShipping(),
            url: '',
            payload: $data
        );
    }


    public function getShippingStatus(string $data): Response
    {
        return  $this->service->post(
            request:$this->service->buildBasewithBaseUrlShipping(),
            url: '',
            payload: $data
        );
    }


}
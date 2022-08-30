<?php

namespace App\Services\TccWSDL\Objects;

use Illuminate\Http\Request;
use App\Services\Concerns\BuildXMLObjects;

class ShippingXMLObject
{
    use BuildXMLObjects;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function makeShippingXMLFactory(string $action): string
    {
        return match ($action) {
            'add' => $this->makeAddShippingXMLObject(request: $this->request),
            'cancel' => $this->makeCancelShippingXMLObject(request: $this->request),
            'status' => $this->makeStatusShippingXMLObject(request:$this->request),
        };

    }


}
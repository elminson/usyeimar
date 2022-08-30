<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\TccWSDL\Objects\ShippingXMLObject;
use App\Services\TccWSDL\TccWsdlApi;
use App\Services\TccWSDL\XMLToArrayFactoy\XMLToArrayFactoy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\TccWSDL\Resources\ShippingResource;



class ShippingController extends Controller
{

	private $shipping;

	public function __construct(){

		$this->shipping = new ShippingResource(
			app(TccWsdlApi::class),
        );

	}

    public function shipping(Request $request) : JsonResponse
    {

        $objectXML = (new ShippingXMLObject(
            $request
        ))->makeShippingXMLFactory('add');

        $response = $this->shipping->addShipping($objectXML)
                    ->body();
        return response()->json([
            'status' => 'success',
            'data' => (new XMLToArrayFactoy(
                $response,'shipping'
            ))->getArray()
        ]);

    }

    public function  status(Request $request) : JsonResponse
    {

        $objectXML = (new ShippingXMLObject(
            $request
        ))->makeShippingXMLFactory('status');
        $response = $this->shipping->getShippingStatus($objectXML)
                    ->body();


        return response()->json([
            'status' => 'success',
            'data' => (new XMLToArrayFactoy(
                $response,'status'
            ))->getArray()
        ]);
    }

    public function cancel(Request $request) : JsonResponse
    {

        $objectXML = (new ShippingXMLObject(
            $request
        ))->makeShippingXMLFactory('cancel');

        $response = $this->shipping->cancelShipping($objectXML)
                    ->body();

        return response()->json([
            'status' => 'success',
            'data' => (new XMLToArrayFactoy(
                $response,'cancel'
            ))->getArray()
        ]);
    }
}

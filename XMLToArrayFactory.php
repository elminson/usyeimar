<?php

namespace App\Services\TccWSDL\XMLToArrayFactoy;

use App\Exceptions\XMLErrorException;

class XMLToArrayFactoy
{
    protected string $xml;
    protected string $action;

    public function __construct(
        string $xml,
        string $action
    )
    {
        $this->xml = $xml;
        $this->action = $action;
    }

    /**
     * @throws XMLErrorException
     */
    public function getArray(): array
    {
        return match ($this->action) {
            'status' => $this->shippingParserStatusResponse($this->xml),
            'shipping' => $this->shippingParserResponse($this->xml),
            'cancel' => $this->shippingParserCancelResponse($this->xml),
            'default' => [
                'status' => 'error',
                'message' => 'Invalid action'
            ]
        };
    }

    /**
     * @param string $xml
     * @return array
     * @throws XMLErrorException
     */
    public function shippingParserResponse(string $xml): array
    {
        $XMLResponseObject = $this->buildXMLDocument($xml);

        if(
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == 1||
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == -1
        ){
            exceptionHandler(
               data: $XMLResponseObject
            );
        }

        $shipping_number = $XMLResponseObject->getElementsByTagName('remesa')->item(0)->nodeValue;
        $pickup_number = $XMLResponseObject->getElementsByTagName('numerorecogida')->item(0)->nodeValue;
        $url_shipping_relationship = $XMLResponseObject->getElementsByTagName('urlrelacionenvio')->item(0)->nodeValue;
        $url_labels = $XMLResponseObject->getElementsByTagName('urlrotulos')->item(0)->nodeValue;
        $response_code = $XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue;
        $response_message = $XMLResponseObject->getElementsByTagName('mensaje')->item(0)->nodeValue;
        return [
            'shipping_number' => $shipping_number,
            'pickup_number' => $pickup_number,
            'url_shipping_relationship' => $url_shipping_relationship,
            'url_labels' => $url_labels,
            'response_code' => (int)$response_code,
            'response_message' => $response_message,
        ];
    }

    /**
     * @param string $xml
     * @return array
     * @throws XMLErrorException
     */
    public function shippingParserStatusResponse(string $xml): array
    {


        $XMLResponseObject = $this->buildXMLDocument($xml);
        if(
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == 1||
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == -1
        ){
            exceptionHandler(
                data: $XMLResponseObject
            );
        }
        $status_id = (int)filter_var($XMLResponseObject->getElementsByTagName('estadoremesa')->item(0)->nodeValue, FILTER_SANITIZE_NUMBER_INT);
        $description = str_replace($status_id, '', $XMLResponseObject->getElementsByTagName('estadoremesa')->item(0)->nodeValue);

        return [
            'shipping_number' => $XMLResponseObject->getElementsByTagName('numeroremesa')->item(0)->nodeValue,
            'shipping_details' => [
                'freight' => (float)$XMLResponseObject->getElementsByTagName('flete')->item(0)->nodeValue,
                'type_service' => $XMLResponseObject->getElementsByTagName('tiposervicio')->item(0)->nodeValue,
                'service_identifier' => $XMLResponseObject->getElementsByTagName('licencia')->item(0)->nodeValue,
            ],
            'shipping_date' => $XMLResponseObject->getElementsByTagName('fecharemesa')->item(0)->nodeValue,
            'status_tracking' => [
                'id' => $status_id,
                'description' => $description,
            ],
            'observations' => $XMLResponseObject->getElementsByTagName('observaciones')->item(0)->nodeValue,

        ];
    }


    /**
     * @param string $xml
     * @return array
     * @throws XMLErrorException
     */
    public function shippingParserCancelResponse(string $xml): array
    {
        $XMLResponseObject = $this->buildXMLDocument($xml);
        if(
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == 1||
            (int)$XMLResponseObject->getElementsByTagName('respuesta')->item(0)->nodeValue == -1
        ){
            exceptionHandler(
                data: $XMLResponseObject
            );
        }
        return [
            'mensaje' => $XMLResponseObject->getElementsByTagName('mensaje')->item(0)->nodeValue,
        ];
    }

    /**
     * @param string $xml
     * @return \DOMDocument
     */
    public function buildXMLDocument(string $xml): \DOMDocument
    {
        $XMLdom = new \DOMDocument();
        $XMLdom->loadXML($xml);
        return $XMLdom;
    }

}
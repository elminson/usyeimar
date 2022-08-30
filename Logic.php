<?php

namespace App\Services\Bussines\Shipping;

use Illuminate\Http\Request;

class Logic
{

    protected array $shipping;
    protected string $parcel_type_service = "TISE_NORMAL_PAQ";
    protected string $messenger_type_service = "TISE_NORMAL_MEN";
    protected int $parcel_account = 1485100;
    protected int $messenger_accout = 5625200;

    protected int $parcel_business_unit = 1;
    protected int $messenger_business_unit = 2;


    public function __construct(
        Request $shipping
    )
    {
        $this->shipping = $shipping->all();
    }

    public function packageMakeArray(): array
    {
        $package = [];
        foreach ($this->shipping['detail'] as $item) {
            if ($item['units'] > 1) {
                for ($i = 1; $i < $item['units']; $i++) {
                    $package[] = [
                        'weight' => $item['weight'],
                        'length' => $item['length'],
                        'width' => $item['width'],
                        'height' => $item['height'],
                        'declared_value' => $item['declared_value'],
                        'volume_weight' => $item['volume_weight'],
                        'description' => $item['description'],
                    ];
                }
            }
            $package[] = [
                'weight' => $item['weight'],
                'length' => $item['length'],
                'width' => $item['width'],
                'height' => $item['height'],
                'declared_value' => $item['declared_value'],
                'volume_weight' => $item['volume_weight'],
                'description' => $item['description'],
            ];

        }
        return $package;

    }

    public function buildShipping(): array
    {

        $units_item = 0;
        foreach ($this->shipping['detail'] as $item) {
            $units_item += $item['units'];
        }
        if ($units_item != 1) {
            return $this->isParcel();
        }
        return $this->isMessenger();

    }

    public function isParcel(): array
    {

        $this->shipping['service']['account'] = $this->parcel_account;
        $this->shipping['service']['business_unit'] = $this->parcel_business_unit;
        $this->shipping['service']['type'] = $this->parcel_type_service;
        $this->shipping['detail'] = $this->packageMakeArray();
        return $this->shipping;

    }

    public
    function isMessenger(): array
    {
        $this->shipping['service']['account'] = $this->messenger_accout;
        $this->shipping['service']['business_unit'] = $this->messenger_business_unit;
        $this->shipping['service']['type'] = $this->messenger_type_service;
        $this->shipping['detail'] = $this->packageMakeArray();
        return $this->shipping;
    }


}
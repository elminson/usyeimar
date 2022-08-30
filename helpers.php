<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

if(!function_exists('getJsonFileCredentials')) {
    /**
     * This function get file json from storage and return array
     * @return string
     */
    function getJsonFileCredentials(): string
    {
       $file = Storage::disk('public')->get('auth-user-credentials.json');
        if ($file) {
            return Arr::get(json_decode($file, true), 'token');
        }
        return '';
    }
}


if(!function_exists('arrayToLower')) {
    /**
     * This function convert item of array to lowercase
     * @param $array
     * @return array
     */
    function arrayToLower($array): array
    {
        return array_map(function ($item) {
            return array_change_key_case($item, CASE_LOWER);
        }, $array);
    }
}
<?php
namespace App\Modules\CreateForm;

abstract class BaseMap
{
    public static function string($option){}
    public static function date($option){}
    public static function rus($option){}
    public static function decimal($option){}
    public static function boolean($option){}
    public static function digits($option){}
    public static function dateTime($option){}


    protected static function getBaseRequesterSettings()
    {
        return [
            "isPersonField"=> true,
            "isSoleField"=> true,
            "isLegalField"=> true
        ];
    }
    protected static function getBaseTitleLabel($option, $nameLabel='fieldLabel')
    {
        return [
            "$nameLabel"=> $option['title'] ?? $option['name'] ?? 'Имя не задано!',
            "name"=> $option['name'] ?? 'unknown'
        ];
    }
}

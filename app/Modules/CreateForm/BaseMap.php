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
        $title = $option['title'] ?? $option['name'];
        $title = empty($title) ? 'Имя не задано' : $title;
        $name = $option['name'] ?? 'unknown';
        $name = empty($name) ? 'textfield' : $name;
        return [
            "$nameLabel"=> $title,
            "name"=> $name
        ];
    }
}

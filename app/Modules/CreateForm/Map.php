<?php
namespace App\Modules\CreateForm;

class Map extends BaseMap
{


    public static function cloneablePanel($options)
    {

        return
            array_merge([
            "xtype" => "cloneablePanel",
            "fieldLabel"=> $options['title'] ?? 'Клонируемая панель',
            "name"=> 'cloneablePanel_'.$options['number'],
            "items"=> $options['items'] ?? [],
            "prefix"=> 'cloneablePanel_'.$options['number'],
            "fieldName"=> 'cloneablePanel_'.$options['number'],

      ], self::getBaseRequesterSettings());

    }

    public static function string($option)
    {
        if( isset($option['count']) && $option['count'] > 255)
            $type = "textarea";
        else
            $type = "textfield";

        return array_merge([
            "xtype"=> $type,
            "allowBlank" => !$option['required']
        ],
        self::getBaseTitleLabel($option),
        self::getBaseRequesterSettings()
        );

    }

    public static function boolean($option)
    {

        return array_merge([
            "xtype"=> 'checkbox',
        ],
            self::getBaseTitleLabel($option,'boxLabel'),
            self::getBaseRequesterSettings()
        );
    }

    public static function date($option)
    {

        return array_merge([
            "xtype"=> 'datefield',
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );

    }

    public static function SNILSType($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateSnils",
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function OGRNSoleProprietorType($option)
    {

        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateOgrnInd",
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function OGRNCompanyType($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateOgrnLegal",
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function combobox($option)
    {
        $restriction = [];
        if(isset($option['restriction'])){

            foreach ($option['restriction'] as $val){
                if (is_array($val)){
                    $value = $val['value'] ?? '';
                    $title = $val['title'] ?? '';
                    $restriction[]['value'] = $value.' - '.$title;
                }
                else{
                    $restriction[]['value'] = $val;
                }

            }
        }

        return array_merge([
            "xtype"=> 'combobox',
            "queryMode" => "local",
            "displayField" => "value",
            "valueField" => "value",
            "allowBlank" => !$option['required'],
            "store" => [
                "fields"=> [
                    "value"
                ],
                "data"=> $restriction,
                "type"=> "store"
            ]
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );

    }


    public static function digits($option)
    {

        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateDigits",
            "allowBlank" => !$option['required']

        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function rus($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateCyrillic",
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function positiveInteger($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateDigits",
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function decimal($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "vtype" => "validateDigits",
            "allowBlank" => !$option['required']

        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }

    public static function dateTime($option)
    {
        return array_merge([
            "xtype"=> 'textfield',
            "allowBlank" => !$option['required']
        ],
            self::getBaseTitleLabel($option),
            self::getBaseRequesterSettings()
        );
    }


    public static function fieldset($option)
    {
      return  array_merge([
            "xtype"=> "fieldset",
        ],
            self::getBaseTitleLabel($option,'title'),
            self::getBaseRequesterSettings()
        );
    }


    public static function custom($option)
    {
        return
            [
                "xtype"=> "textfield",
                "fieldLabel"=> $option['title'],
                "allowBlank" => !$option['required'],
                "name"=> $option['name'],
                "isPersonField"=> true,
                "isSoleField"=> false,
                "isLegalField"=> false,

            ];
    }
}

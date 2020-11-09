<?php


namespace Tests\Unit\CreateForm;
use App\Modules\CreateForm\FormOldAis;
use App\Modules\CreateForm\FormOldAisV2;
use App\Modules\CreateForm\Map;
use App\Modules\CreateForm\XsdParser;
use App\Modules\CreateForm\XsdParserV2;
use PHPUnit\Framework\TestCase;

class ParserXsdTest extends TestCase
{

    protected $pathXsdImushestvo = __DIR__.'/xsd/imushestvo/1_sogl/main.xsd';
    protected $pathXsdBuildning = __DIR__.'/xsd/xsd_test_1/application.xsd';
    protected $pathXsdBuildning_2 = __DIR__.'/xsd/xsd_test_2/application.xsd';
    protected $pathSetNullAddress = __DIR__.'/xsd/xsd_set_null_address/assign-address-1.0.0.xsd';

    public function testCreateArray()
    {
        $main = new XsdParserV2("1.0", 'UTF-8',file_get_contents($this->pathXsdImushestvo));
        $main->joinImportXsd($this->pathXsdImushestvo);
        $elements = $main->getArrayNodes($main->getElementsByAttrName('Applicant'));


        $form = new FormOldAisV2();
        $formData = $form->createForm($elements);
//        $arrResult = $form->getJsonForm();
        print_r( json_encode($arrResult, JSON_UNESCAPED_UNICODE));

    }

    public function testCreateSelect()
    {
        $json = json_decode(file_get_contents(__DIR__.'/json/test.json'),1);


        $arr = [
            'required' => 0,
            'name' => 'sprav'
        ];
        foreach ($json as $v)
        {
            $arr['restriction'][] = [
                        'title' => $v['FIELD2'],
                        'value' =>  $v['FIELD1']
                    ];
        }
        $arrCombobox = Map::combobox($arr);
        $json = json_encode($arrCombobox, JSON_UNESCAPED_UNICODE);
            print_r($json);
//        print_r(json_encode($arrCombobox, JSON_UNESCAPED_UNICODE));


    }


}

<?php


namespace Tests\Unit\CreateForm;
use App\Modules\CreateForm\FormOldAis;
use App\Modules\CreateForm\Map;
use App\Modules\CreateForm\XsdParser;
use PHPUnit\Framework\TestCase;

class ParserXsdTest extends TestCase
{

    protected $pathXsd = __DIR__.'/xsd/imushestvo/1_sogl/main.xsd';

    public function testCreateArray()
    {

        $main = new XsdParser("1.0", 'UTF-8',file_get_contents($this->pathXsd));
        $main->joinImportXsd($this->pathXsd);

        //Поиск всех ссылок и вставка
        if($mainTag = $main->getElementsByAttrName('Applicant')){
            $searchElemAndGroup = $main->searchElemAndGroup($main->getElementsByAttrName('Applicant'));
            $res =  $main->getRef($searchElemAndGroup);
            $res = $main->sortArray($res);
        }
        else {
            throw new \Exception('Не найден элемент с таким именем ');
        }

//        print_r($res);


        $form = new FormOldAis($res);
        $arrResult = $form->getJsonForm();
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

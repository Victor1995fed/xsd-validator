<?php


namespace Tests\Unit\CreateForm;
use App\Modules\CreateForm\FormOldAis;
use App\Modules\CreateForm\Map;
use App\Modules\CreateForm\XsdParser;
use PHPUnit\Framework\TestCase;

class ParserXsdTest extends TestCase
{

    protected $pathXsd = __DIR__.'/xsd/xsd_test_1/application.xsd';

    public function testCreateArray()
    {

        $main = new XsdParser("1.0", 'UTF-8',file_get_contents($this->pathXsd));
        $main->joinImportXsd($this->pathXsd);

        //Поиск всех ссылок и вставка
        if($mainTag = $main->getElementsByAttrName('Application')){
            $searchElemAndGroup = $main->searchElemAndGroup($main->getElementsByAttrName('Application'));
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


}

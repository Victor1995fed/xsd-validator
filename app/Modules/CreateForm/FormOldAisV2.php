<?php




namespace App\Modules\CreateForm;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class FormOldAisV2 extends BaseCreateForm
{

    public $resultArray = [];


    protected function getNewName($name, $arrName)
    {
        $i = 2;
        while(in_array( $name.'_'.$i,$arrName)){
            $i++;
        }
        return $name.'_'.$i;
    }

    protected function renameSameName($array)
    {
        $newArr = [];
        $nameSame = [];
        foreach ($array as $k => $v)
        {
            if(isset($v['name']) ){
                $v['name'] = trim($v['name']);
                if(in_array( $v['name'],$nameSame)){
                    $v['name'] =  $this->getNewName($v['name'], $nameSame);
                }
                $nameSame[] =  $v['name'];
                $newArr[] = $v;
            }


        }
        return $newArr;

    }

    public function createForm($data)
    {
        $this->parseArray($data);
        return $this->renameSameName($this->resultArray);
    }

    public function parseArray($data)
    {
        foreach ($data as $key => $value) {
            if(isset($value['tag']) && $value['tag'] != '') {
                $this->processTag($value);
            }
        }
        return true;
    }

    protected function processTag($element)
    {
        if(method_exists($this, $element['tag'])){
            $method  = $element['tag'];
            $this->$method($element);
        }
    }


    public function simpleType($element)
    {
        if (isset($element['fields']) && !empty($element['fields'])){
            foreach ($element['fields'] as $field){
                if($field['type'] == 'fieldset') {
                    $title = $field['title'];
                }
                elseif ($field['type'] == 'combobox'){
                    $restriction = $field['choice'];
                }
            }
            $this->resultArray[] = Map::combobox([
                'title'=>$title ?? null,
                'restriction'=>$restriction ?? [],
                'required' => $element['required'],
                'name' => $element['name']
            ]);
        }
    }

    protected function processCloneablePanel($value)
    {
        $newArr = [];
        $newArr[] = Map::fieldset($value);

        if(is_array($value['fields']) && !empty($value['fields'])){
            $FormItems = new FormOldAisV2();
            $fields  =  $FormItems->createForm($value['fields']);
        }
        elseif(method_exists(new Map(), $value['type'])) {
            $method = $value['type'];
            $fields = Map::$method($value);
        }

        return  Map::cloneablePanel([
            'title' => $value['title'] ?? 'Клонируемая панель',
            'items' => array_merge($newArr,$fields),
            'name' => $value['name'],
            'number' => rand(1, 100)
        ]);
    }


    public function element($element)
    {
        if ($element['cloneablePanel']) {
            $this->resultArray[] = $this->processCloneablePanel($element);
        }
        elseif(method_exists(new Map(), $element['type'])){
            $method = $element['type'];
            $this->resultArray[] = Map::$method($element);
            return true;
        }
        elseif (isset($element['fields']) && !empty($element['fields'])){
            if($element['title'] != null) {
                $this->resultArray[]  =  Map::fieldset($element);
            }
             $this->createForm($element['fields']);
        }
    }

    protected function getChoiceRestriction($fields)
    {
        $restriction = [];
        foreach ($fields as $key => $val) {
            $restriction[] = [
                'value' => ++$key,
                'title' => $val['title'] ?? $val['name']
            ];
        }
        return $restriction;
    }


    protected function choice($element)
    {
        //Get choice text
        $restriction = $this->getChoiceRestriction($element['fields']);
        $this->resultArray[] = Map::combobox([
            'restriction' => $restriction,
            'required' => true,
            'title' =>'Выбор из блоков',
            'name' => 'choice_'.rand(1,100)
        ]);
        $this->createForm($element['fields']);
    }

    protected function complexType($element)
    {
        if($element['title'] != null) {
            $this->resultArray[]  =  Map::fieldset($element);
        }
        if(isset($element['fields']) && !empty($element['fields'])){
            $this->createForm($element['fields']);
        }
    }

    protected function sequence($element)
    {
        if($element['title'] != null) {
            $this->resultArray[]  =  Map::fieldset($element);
        }
        if(isset($element['fields']) && !empty($element['fields'])){
             $this->createForm($element['fields']);
        }

    }




}


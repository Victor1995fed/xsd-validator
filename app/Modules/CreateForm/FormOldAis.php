<?php
namespace App\Modules\CreateForm;

class FormOldAis extends BaseCreateForm
{


    protected $baseArray = [];

    protected  $numberCloneablePanel = 0;

    public function __construct($array)
    {
        $this->baseArray = $array;
    }

    /**
     * Получет json формы
     * */

    public function getJsonForm()
    {
        $resultArray = $this->createArray($this->baseArray);
        $resultArray = $this->joinCloneablePanel($resultArray);
        $resultArray = $this->renameSameName($resultArray);
        return $resultArray;
//        return json_encode($resultArray, JSON_UNESCAPED_UNICODE);

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

    protected function getNewName($name, $arrName)
    {
        $i = 2;
        while(in_array( $name.'_'.$i,$arrName)){
            $i++;
        }
        return $name.'_'.$i;
    }


    /**
     * Объединяет вложенную клонируемую панель в одну
     * @param $array
     */
    protected function joinCloneablePanel($array)
    {
        $newArr = [];
        foreach ($array as $key => $value){
            $xtype = $value['xtype'] ?? null;
            if($xtype == 'cloneablePanel'){
                $value['items'] = $this->getChildCloneable($value['items']);
            }
            $newArr[] = $value;
        }
        return $newArr;
    }

    /**
     * Получает дочерние клонируемые панели
     * @param $array
     * @return array
     */
    protected function getChildCloneable($array)
    {
        $newArr = [];
       foreach ($array as $key => $val)
       {
           $xtype = $val['xtype'] ?? null;
               if($xtype == 'cloneablePanel'){
                   $newArr[] = $this->getChildCloneable($val['items']);
               }
               else{
                   $newArr[] = $val;
               }


       }

       return $newArr;
    }

    protected function processCloneablePanel($value)
    {
        $this->numberCloneablePanel = $this->numberCloneablePanel + 1;
        $newArr = [];
        $newArr[] = Map::fieldset($value);
        if(is_array($value['type'])){
            return  Map::cloneablePanel([
                'title' => $value['title'] ?? 'Клонируемая панель',
                'items' => array_merge($newArr,$this->createArray($value)),
                'name' => $value['name'],
                'number' => $this->numberCloneablePanel
            ]);
        }
        else{
            $newArr[] = $this->processType($value);
            return  Map::cloneablePanel([
                'title' => $value['title'] ?? 'Клонируемая панель',
                'items' => $newArr,
                'name' => $value['name'],
                'number' => $this->numberCloneablePanel
            ]);
        }
    }

    public function createArray($array, $options = [])
    {
        $newArr = [];
        $options = [
            'title' => $array['title'] ?? null,
            'name' => $array['name'] ?? null,
            'required' => $array['required'] ?? false,
        ];
            foreach ($array as $key => $value){

                if(isset($value['cloneablePanel']) && $value['cloneablePanel']){
                     $newArr[] = $this->processCloneablePanel($value);
                }
                elseif(isset($value['type'])){

                    if(is_array($value['type'])){
                        if(isset($value['title'])){
                            $newArr[] = Map::fieldset($value);
                        }
                        $newArr = array_merge($newArr, $this->createArray($value,$options));
                    }
                    elseif ($value['type'] == 'fields'){
                        $newArr = array_merge($newArr, $this->createArray($value,$options));
                    }
                    elseif ($value['type'] == 'choice'){
                        $newArr = array_merge($newArr, $this->processChoice($value,$options));
                    }
                    else {
                        $newArr[] =   $this->processType($value,$options);
                    }
                }
                elseif (isset($value['fields'])){
                    $newArr =  array_merge($newArr,$this->createArray($value));
                }
                elseif(is_array($value)){
                    $newArr = array_merge($newArr,$this->createArray($value));
                }

            }
            return $newArr;
    }


    protected function processFields($value)
    {

        return $this->createArray($value);

    }

    protected function processType($value,$options=[])
    {

        $type = $value['type'];
        if(method_exists(new Map(), $type)){
            return Map::$type([
                'title' =>  $value['title'] ?? $options['title'] ?? $value['name'] ?? 'Имя для поля не ЗАДАНО!',
                'name' => $value['name'] ?? $options['name'] ?? 'unknown',
                'restriction' =>$value['choice'] ?? null,
                'required' => $value['required'] ?? $options['required'] ?? false
            ]);
        }

    }

    protected function processTypeArray($type)
    {
        return $this->createArray([$type]);
    }

    protected function processChoice($choice,$option=[])
    {
        $newArr = [];
        if(isset($choice['title'])){
            $newArr[] = Map::fieldset($choice);
            $newArr[] = Map::combobox([
                'name' => $choice['name'] ?? null,
                'title' => 'Выбор значения для группы '.$choice['title'],
            ]);
        }

        return array_merge($newArr,$this->createArray($choice,$option));
    }

    protected function getRestriction($value)
    {
        if($value !== null){
            return $value;
        }
    }


}

<?php


namespace App\Modules\CreateForm\traits;


use App\Modules\CreateForm\Map;

trait HelperXsd
{

    public function removeNamespace($name)
    {
        $result =  explode(':',$name);
        return $result[1] ?? $result[0];
    }

    /**
     * В схемах встречаются ошибки, когда в имени переменной русская буква!!
     * */
    protected function replaceRus($title)
    {
        $tr = [
            "А"=>"A","В"=>"B","Е"=>"E", "К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "Р"=>"P","С"=>"C","Т"=>"T",
            "Х"=>"X",
            "е"=>"e","ж"=>"j",
            "к"=>"k","н"=>"h","о"=>"o",
            "с"=>"c"
        ];
        return strtr($title,$tr);
    }



    /**
     * Функция возвращает массив дочерних полей(если они есть) и тип поля
     * @param $type
     * @return array|string[]
     */
    protected function getArrayType($type) : array
    {
        if(is_array($type)){
            return [
                'type'=>'parentField',
                'fields' => $type
            ];

        }
        else
            return [
                'type' => $this->trimName($this->trimNameHyphen($type)),
                'length' => $this->getLengthField($type)
            ];
    }


    public function getAnnotation($elem)
    {

        if($title = $this->getCurrentAnnotation($elem))
            return $title;
        else {
            return null;
        }
    }


    protected function getLengthField($name)
    {
        $expName = explode('-',$name);
        return $expName[1] ?? null;
    }

    /**
     * Ищет тип и описание элемента
     * @param $name
     * @return array|false|string|null
     * @throws Exception
     */
    public function  getTypes($name)
    {

        //Дублируются клонируемые панели
        if($name === null)
            return null;

        $trimName = $this->trimName($name);
        $trimName = $this->trimNameHyphen($trimName);


        if(method_exists(new Map(),$trimName))
            return $name;

        else{
            return false;
        }
    }


    /**
     * Обработка типа
     * @param $elem
     * @return array|null
     */
    public function processType($elem)
    {

        if($this->trimName($elem->nodeName) == 'simpleType'){
            return $this->processSimpleType($elem);
        }
        elseif($this->trimName($elem->nodeName) == 'complexType'){
            return $this->processComplexType($elem);
        }
        return null;
    }

    /**
     * Обработка комплексных типов complexType
     * @param $elem
     * @return array
     */
    public function processComplexType($elem)
    {

        //TODO::Добавить обработку choice

        $elements = $elem->getElementsByTagName('element');

        if($elements->length > 0){
            return [
                'type'=>'parentField',
                'fields' => $this->getFields($elements)
            ];
        }
        $simpleContent = $elem->getElementsByTagName('simpleContent');

        if ($simpleContent->length > 0) {
//           $simpleContent->item(0);
            $type = $this->processSimpleContent($simpleContent->item(0));
            return  $type;
        }

        return null;

//        return $newArr;
    }

    protected function processSimpleContent($simpleContent)
    {
        $attribute = $simpleContent->getElementsByTagName('attribute');
        if($attribute->length > 0)
        {
            return  $this->getTypes($attribute->item(0)->getAttribute('type'));
        }
        else
            return null;
    }


    /**
     * Возвращает поля в элементы
     * @param $elemnts
     * @return array
     * @throws Exception
     */
    public function getFields($elemnts)
    {
        $newArr= [];
        foreach ($elemnts as $k => $v)
        {
            $newArr[] = $this->getSingleField($v);
        }

        return $newArr;
    }

    /**
     * Возвращает поля в элементе
     * @param $elemnts
     * @return array
     * @throws Exception
     */
    public function getSingleField($elemnts)
    {

        $cloneablePanel = false;
        $required = true;
        if($elemnts->getAttribute('maxOccurs') == 'unbounded'){
            $cloneablePanel = true;
        }
        if($elemnts->getAttribute("minOccurs") == '0'){
            $required = false;
        }

        if($elemnts->getAttribute('type')){
            $type = $this->getTypes($elemnts->getAttribute('type'));
        }
        else{
            $type = 'fieldset';
        }


        return array_merge(
            $this->getArrayType($type),
            [
                'title' => $this->getAnnotation($elemnts),
                'name' => $this->trimName($elemnts->getAttribute('name')),
                'cloneablePanel' => $cloneablePanel,
                'required' => $required,
            ]);



    }

    /**
     * Поиск правил  ограничений в типах
     * @param $restriction
     * @return array|null
     */
    public function getRestriction($restriction)
    {
        $enumeration = $restriction->getElementsByTagName('enumeration');
        $pattern = $restriction->getElementsByTagName('pattern');
        if( $enumeration->length  > 0 ){
            $choice = [];
            foreach ($enumeration as $k => $v)
            {
                if($v->getElementsByTagName('documentation')->length > 0){
                    $name = ' - '.$v->getElementsByTagName('documentation')->item(0)->nodeValue;
                }
                else{
                    $name = '';
                }
                $choice[] = $v->getAttribute('value').$name;
            }
            return [
                'type' => 'combobox',
                'choice'=> $choice
            ];
        }
        elseif ($pattern->length  > 0){
            return [
                'type'=>'custom',
                'pattern'=>$pattern->item(0)->getAttribute('value') ?? null
            ];
        }
        else
            return null;
    }

    /**
     * Получение элемента по имени
     * @param $name
     * @param string $tag
     * @return bool
     */
    public function getElementsByAttrName($name, $tag='*')
    {
        foreach ($this->getElementsByTagName($tag) as $v){
            if($v->getAttribute('name') == $name)
                return $v;
        }
        return false;
    }



    /**
     * Получение элементов по ссылкам
     * @param $arr
     */
    public function getRef($arr)
    {
        $newArr = [];
        foreach ($arr as $key => $elem)
        {
            if(in_array($this->trimName($elem->nodeName), ['group', 'choice'])){
                if($ref = $elem->getAttribute('ref')){
                    $key = $ref;
                    $elem = $this->getRef([$this->getRefGroup($ref)]);
                }
                elseif ($elem->getElementsByTagName('choice')->length > 0){
                    $elem = ['choice' => $this->getRef($elem->getElementsByTagName('choice'))];
                }
                elseif ($elem->getElementsByTagName('group')->length > 0){
                    $elem = $this->getRef($elem->getElementsByTagName('group'));
                }
            }
            $newArr[$key] = $elem;
        }
        return $newArr;
    }

    /**
     * Вернуть аннотацию
     * @param $node
     * @return |null
     */
    public function getCurrentAnnotation($node)
    {
        foreach ($node->childNodes as $singleNode)
        {
            $nodeName = $this->removeNamespace($singleNode->nodeName);
            if($nodeName == 'annotation'){
                return $singleNode->getElementsByTagName('documentation')->item(0)->nodeValue ?? null;
            }
        }
        return null;
//        return $node->getElementsByTagName('documentation')->item(0)->nodeValue ?? null;
    }

    /**
     * Обработка групп
     * @param $group
     * @return array|array[]
     * @throws Exception
     */
    public function processGroup($group)
    {

        $newArr = [];
        $choice = $group->getElementsByTagName('choice');
        if($choice->length > 0){
            return
                [
                    'choiceFields'=>$this->processGroup($choice->item(0))
                ];

        }

        foreach ($group->getElementsByTagName('element') as $k => $v){
            $newArr[$k] = array_merge(
                $this->getArrayType($this->getTypes($v->getAttribute('type'))),
                [
                    'name' => $this->trimName($v->getAttribute('name')),

                ]);
        }
        return  $newArr;
    }

    /**
     * Отрезает namespace
     * @param $name
     * @return false|string
     */
    protected function trimName($name)
    {
        $name = $this->replaceRus($name);
        $strpos = strpos($name, ':');
        if($strpos !== false){
            $name = substr($name, $strpos + 1, strlen($name));
        }

        return $name;
    }

    /**
     * Отрезает все после "-"
     * @param $name
     * @return false|string
     */
    protected function trimNameHyphen($name)
    {
        $strpos = strpos($name, '-') ;
        if($strpos !== false){
            $name = substr($name, 0, $strpos);
        }
        return $name;
    }


    /**
     * Получает элемент группы по ссылке
     * @param $ref
     * @return bool
     */
    public function getRefGroup($ref)
    {
        return $this->getElementsByAttrName($this->trimName($ref),'group');
    }
}

<?php
namespace App\Modules\CreateForm;

class XsdParser extends \DOMDocument
{

    public function __construct($version = '', $encoding = '', $data = '')
    {
        parent::__construct($version, $encoding);
        if ($data) {
            $this->loadXML($data);
            $this->formatOutput = true;
        }
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
     * Поиск элементов и групп
     * @param null $node
     * @return array
     */
    public function searchElemAndGroup($node = null)
    {
        if(!$node){
            $node = $this;
        }
        $newArr = [];
        foreach ($node->getElementsByTagName('*') as $k => $v){
            if(in_array($this->trimName($v->nodeName),['group','element']))
                $newArr[] = $v;
        }
        if(empty($newArr) && $node->getAttribute('type') !== null){
            //Получаем элемент по указанному типу
             $newArr[] = $this->getElementsByAttrName($this->trimName($node->getAttribute('type')));
        }
        return $newArr;
    }

    /**
     * Сортировка массива элементов в удобный вид
     * @param $arr
     * @return array
     */

    public function sortArray($arr)
    {
        $newArr = [];
        foreach ($arr as $k => $v){
            if(is_a($v,\DOMElement::class)){

                $title = $this->getAnnotation($v);

                if(in_array($this->trimName($v->nodeName),['element', 'complexType'])){
                    if($v->getAttribute('type')){
                        $type = $this->getTypes($v->getAttribute('type'));
                    }
                    else {
                        $type = $this->searchTypeIntoElement($v);
                    }
                    $newArr[$k] =
                        [
                            'title' => $title,
                            'name' => $this->trimName($v->getAttribute('name')),
                            'type' =>$type ,
                            'tag'=>$v->nodeName
                        ];
                }
                elseif (in_array($this->trimName($v->nodeName),['group', 'choice'])){

                    $newArr[$k] =
                        [
                            'title' => $title,
                            'name' => $this->trimName($v->getAttribute('name')),
                            'fields' => $this->processGroup($v),
                            'tag'=>$v->nodeName
                        ];
                }


            }
            elseif (is_array($v)){
                $newArr[$k] = $this->sortArray($v);
            }
            else
                continue;
        }
        return $newArr;
    }

    public function getAnnotation($elem)
    {

            if($title = $this->getCurrentAnnotation($elem))
                return $title;
            else {
                return $elem->getAttribute('name');
            }
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
        $name = $this->trimName($name);
        $name = $this->trimNameHyphen($name);

        if(method_exists(new Map(),$name))
            return $name;

        else{

            //Иначе ищем описание типа в xsd
            $elem = $this->getElementsByAttrName($this->trimName($name));

            if($elem){
                return $this->processType($elem);
            }
            else
                return 'string';
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
                'type'=>'fields',
                'fields' => $this->getFields($elements)
            ];
        }


//        return $newArr;
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
        $required = false;
        if($elemnts->getAttribute('maxOccurs') == 'unbounded'){
            $cloneablePanel = true;
        }
        if($elemnts->getAttribute("minOccurs") == '1'){
            $required = true;
        }

        if($elemnts->getAttribute('type')){
            $type = $this->getTypes($elemnts->getAttribute('type'));
        }
        else{
            $type = 'fieldset';
        }


        return
            [
                'title' => $this->getAnnotation($elemnts),
                'name' => $this->trimName($elemnts->getAttribute('name')),
                'type' => $type,
                'cloneablePanel' => $cloneablePanel,
                'required' => $required,
            ];



    }

    /**
     * Ищет тип в дочерних элементах
     * @param $elem
     * @return array|string|null
     */
    public function searchTypeIntoElement($elem)
    {
        if($result = $this->getRestriction($elem))
            return $result;
        elseif($result = $this->processComplexType($elem))
            return $result;
        else
            return 'unknown';
    }

    /**
     * Обработка простых типов - simpleType
     * @param $elem
     * @return array|null
     */
    public function processSimpleType($elem)
    {
        $restriction = $elem->getElementsByTagName('restriction');
        if($restriction->length > 0){
            return $this->getRestriction($restriction->item(0));
        }

        return null;

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
        return $node->getElementsByTagName('documentation')->item(0)->nodeValue ?? null;
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
            $newArr[$k] = [
                'name' => $this->trimName($v->getAttribute('name')),
                'type' => $this->getTypes($v->getAttribute('type')),
            ];
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



    /**
     * Объединение xsd
     * @param $pathXsd
     */
    public function joinImportXsd($pathXsd)
    {
        $basePath = dirname($pathXsd);
        $pathXsdList  = $this->searchIncludeXsd($basePath);
        $importXsd = $this->getIncludeXsd($pathXsdList);
        foreach ($importXsd as $single) {
            $this->addXsdScheme($single);
        }
    }

    /**
     * Список подключенных xsd
     * @param $arrayPath
     * @return array
     */
    protected function getIncludeXsd($arrayPath){
        $importSchemeArr = [];
        foreach ($arrayPath as $path){
            $importScheme = new \DOMDocument("1.0", 'UTF-8');
            $importScheme->formatOutput = true;
            $importScheme->load($path);
            $importSchemeArr[] = $importScheme->documentElement;
        }
        return $importSchemeArr;
    }

    /**
     * Добавление схемы
     * @param $addScheme
     */
    protected  function addXsdScheme($addScheme)
    {
        foreach($addScheme->childNodes as $node)
        {
            $importNode = $this->importNode($node,TRUE);
            $this->documentElement->appendChild($importNode);
        }
    }

    /**
     * Поиск импортируемых схем в главной xsd
     * @param $basePath
     * @return array
     */
    protected function searchIncludeXsd($basePath)
    {
        $importXsd = [];
        foreach ($this->getElementsByTagName('include') as $singleInclude){
            $importXsd[] = $basePath.'/'.$singleInclude->getAttribute('schemaLocation');
        }
        foreach ($this->getElementsByTagName('import') as $singleInclude){
            $importXsd[] = $basePath.'/'.$singleInclude->getAttribute('schemaLocation');
        }

        return $importXsd;
    }
}

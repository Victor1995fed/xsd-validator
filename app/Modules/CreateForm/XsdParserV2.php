<?php

namespace App\Modules\CreateForm;

use App\Modules\CreateForm\traits\HelperXsd;
use App\Modules\CreateForm\traits\IncludeXsd;
use App\Modules\CreateForm\traits\TagsName;

class XsdParserV2 extends \DOMDocument
{
    use IncludeXsd;
    use HelperXsd;
    use TagsName;

    public function __construct($version = '', $encoding = '', $data = '')
    {
        parent::__construct($version, $encoding);
        if ($data) {
            $this->loadXML($data);
            $this->formatOutput = true;
        }
    }

    /**
     * @param $node
     * @return array
     * Должен возвращаться только строка с типом, либо массив
     */
    protected function searchType($node)
    {
        $attrType = $node->getAttribute('type');
        $type = $this->getTypes($attrType);
        if(!$type){
            $typeElement = $this->getElementsByAttrName($this->removeNamespace($attrType));
            if($typeElement) {
                $fields = $this->getArrayNodes($typeElement);
                return array_merge(
                    $this->getDataField($node),
                    ['fields' => $fields]
                );
            }
        }
        else {
            return null;
        }

    }



    public function getArrayNodes($node)
    {
        $elementsList = [];
        $name = $node->getAttribute('name');
        if($node->hasAttribute('type')){
            $searchType = $this->searchType($node);
            if(!empty($searchType)){
                $elementsList[] = $searchType;
            }
        }
        else {
            foreach ($node->childNodes as $singleNode)
            {
                $nodeName = $this->removeNamespace($singleNode->nodeName);
                if(method_exists($this, $nodeName)){
                    $elementsList[] = $this->$nodeName($singleNode);
                }
            }
        }

        return $elementsList;
    }

    protected function getDataField($node)
    {
        $type = $node->getAttribute('type');
        return [
            'name'=>$node->getAttribute('name'),
            'title' => $this->getAnnotation($node),
            'type' => $this->trimName($this->trimNameHyphen($type)),
            'length' => $this->getLengthField($type),
            'required' => ($node->getAttribute("minOccurs") == '0') ? false : true,
            'cloneablePanel' => ($node->getAttribute('maxOccurs') == 'unbounded') ? true : false
        ];
    }




}

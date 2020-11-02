<?php

namespace App\Modules\CreateForm;

use App\Modules\CreateForm\traits\HelperXsd;
use App\Modules\CreateForm\traits\IncludeXsd;

class XsdParserV2 extends \DOMDocument
{
    use IncludeXsd;
    use HelperXsd;

    public function __construct($version = '', $encoding = '', $data = '')
    {
        parent::__construct($version, $encoding);
        if ($data) {
            $this->loadXML($data);
            $this->formatOutput = true;
        }
    }

    public function getArrayNodes($node)
    {
        $elementsList = [];
        foreach ($node->childNodes as $singleNode)
        {
            $nodeName = $this->removeNamespace($singleNode->nodeName);

            $tagObject = new ProcessTagsXsd();
            if(method_exists($tagObject, $nodeName)){
                $elementsList[] = $tagObject->$nodeName($singleNode);
            }
        }
        return $elementsList;
    }




}

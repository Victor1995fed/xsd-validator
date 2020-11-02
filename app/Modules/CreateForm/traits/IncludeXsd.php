<?php
namespace App\Modules\CreateForm\traits;

trait IncludeXsd {



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

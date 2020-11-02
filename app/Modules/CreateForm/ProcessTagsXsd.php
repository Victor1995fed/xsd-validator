<?php


namespace App\Modules\CreateForm;


class ProcessTagsXsd extends XsdParserV2
{

    //TODO:: Возможно сделать трейт
    public function annotation($node)
    {
        return [
            'type' => 'fieldset',
            'title' => $node->getElementsByTagName('documentation')->item(0)->nodeValue ?? null
        ];
    }

    public function sequence($node)
    {
        return [
            'type'=>'parentField',
            'fields'=> $this->getArrayNodes($node),
        ];
    }

    public function element($node)
    {
        //Ищем тип, если он есть и известен, то просто возвращаем
        //Иначе, если он есть, но не известен, то пытаемся найти его в xsd и в текущий массив ставим тип "parentField" и label, если есть

        return [
            'type'=>'element',
            'label' => '',
        ];
    }

    public function choice($node)
    {

        return [
            'type'=>'choice'
        ];
    }
}

<?php


namespace App\Modules\CreateForm;


class ProcessTagsXsd extends XsdParserV2
{


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
            'type'=>'sequence',
            'fields'=> $this->getArrayNodes($node),
        ];
    }

    public function element($node)
    {

        return array_merge(
            [
                'tag'=>'element',
                'title' => $this->getAnnotation($node)
            ],
            $this->getDataField($node),
            ['fields' =>$this->getArrayNodes($node)]
        );
    }

    public function choice($node)
    {
        return [

            'type'=>'choice',
            'fields' => $this->getArrayNodes($node),
            'title' => $this->getAnnotation($node)
        ];
    }


}

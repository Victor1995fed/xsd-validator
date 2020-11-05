<?php


namespace App\Modules\CreateForm\traits;


trait TagsName
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
        return array_merge(
            [
                'tag'=>'sequence',
            ],
            $this->getDataField($node),
            ['fields' => $this->getArrayNodes($node)]
        );
    }

    public function element($node)
    {
        $type = $node->getAttribute('type');
        $getTypes = $this->getTypes($type);
        if(!$getTypes){
            $fields = $this->getArrayNodes($this->getElementsByAttrName($this->removeNamespace($type)));
        }
        return array_merge(
            [
                'tag'=>'element',
            ],
            $this->getDataField($node),
            ['fields' => $fields ?? []]
        );
    }

    public function choice($node)
    {
        return array_merge(
            [
                'tag'=>'choice',
            ],
            $this->getDataField($node),
            ['fields' => $this->getArrayNodes($node)]
        );
    }
}

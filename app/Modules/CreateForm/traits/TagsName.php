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
            $this->getDataField($node),
            ['fields' => $this->getArrayNodes($node)]
        );
    }

//    public function simpleType($node)
//    {
//        $fields = $this->getDataField($node);
//        foreach ($fields as $field) {
//            if(isset($field['type']) && $field['type'] == 'combobox') {
//                $type = 'combobox';
//                $items = $field['choice'];
//                break;
//            }
//        }
//        return
//            [
//                'itemType' => $type ?? 'parent',
//                'tag'=>'simpleType',
//                'choice' => $items ?? []
//            ];
//
//    }

    public function element($node)
    {
        $type = $node->getAttribute('type');
        $getTypes = $this->getTypes($type);
        if(!$getTypes){
            $fields = $this->getArrayNodes($node);
        }

        return array_merge(
            $this->getDataField($node),
            ['fields' => $fields ?? []]
        );
    }

    public function complexType($node)
    {
        $type = $node->getAttribute('type');
        $getTypes = $this->getTypes($type);
        if(!$getTypes){
            $fields = $this->getArrayNodes($node);
        }
        return array_merge(
            $this->getDataField($node),
            ['fields' => $fields ?? []]
        );
    }

    public function simpleContent($node)
    {
        $type = $node->getAttribute('type');
        $getTypes = $this->getTypes($type);
        if(!$getTypes){
            $fields = $this->getArrayNodes($node);
        }
        return array_merge(
            $this->getDataField($node),
            ['fields' => $fields ?? []]
        );
    }

    public function extension($node)
    {
        $type = $node->getAttribute('base');
        $getTypes = $this->getTypes($type);
        if(!$getTypes){
            $fields = $this->getArrayNodes($node);
        }
        return array_merge(
            [
                'type'=>$this->trimName($this->trimNameHyphen($type)),
                'tag' => $this->removeNamespace($node->nodeName),
                'name'=>$node->getAttribute('name'),
                'title' => $this->getAnnotation($node),
                'length' => $this->getLengthField($type),
                'required' => ($node->getAttribute("minOccurs") == '0') ? false : true,
                'cloneablePanel' => false
                ],
            ['fields' => $fields ?? []]
        );
    }

    public function choice($node)
    {
        return array_merge(
            $this->getDataField($node),
            ['fields' => $this->getArrayNodes($node)]
        );
    }

    public function restriction($node)
    {
        $enumeration = $node->getElementsByTagName('enumeration');
        $pattern = $node->getElementsByTagName('pattern');
        if( $enumeration->length  > 0 ){
            $choice = [];
            foreach ($enumeration as $k => $v)
            {
                if($v->getElementsByTagName('documentation')->length > 0){
                    $name = $v->getElementsByTagName('documentation')->item(0)->nodeValue;
                }
                else{
                    $name = '';
                }
                $choice[] = ['value' => $v->getAttribute('value'), 'title' => $name];
            }
            return [
                'type' => 'combobox',
                'tag' => 'restriction',
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
}

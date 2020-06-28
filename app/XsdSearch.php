<?php


namespace App;


use Illuminate\Support\Facades\Auth;

class XsdSearch extends Xsd
{

    public  $sortable = ['title','description','updated_at'];
    public  $paramsCondition = ['user_id','public'];
    public  $pageSize = 5;

    public $params = [];
    public $paramSortName = 'sort';

    protected function constructorConditions() : array
    {
        $conditions = [];
        foreach ($this->params as $key => $val){
            if(array_search($key,$this->paramsCondition) !== false){
                if($key != 'public')
                    $conditions[] = [$key,'=',$val];
            }
        }
        $userId = $this->params['user_id'] ?? false;
        //Если пользователь неавторизирован, то вывод только публичных xsd
        if (Auth::check()  && Auth::id() == $userId){
            if(isset($this->params['public']))
                $conditions[] = ['public','=',$this->params['public']];
        }
        else
            $conditions[] = ['public','=',1];

        return $conditions;
    }

    protected function tagConditions() : array
    {
        $conditions = [];
        foreach ($this->params as $key => $val){
                if($key == 'tag')
                    $conditions[] = ['tag_id','=',$val];
        }

        return $conditions;
    }

    protected function getSort() : array
    {
        $sort = $this->params[$this->paramSortName] ?? null;
        if($sort !== null && array_search($sortAttr = str_replace('-','',$sort), $this->sortable) !== false){
            $sortType = strripos($sort,'-') === false ? 'asc' : 'desc';
            return [
                'sortType' => $sortType,
                'sortAttr' => $sortAttr
            ];
        }
        else
            return [
                'sortType' => 'asc',
                'sortAttr' => 'id'
            ];
    }

    public function getXsdList()
    {
        $sort = $this->getSort();
        $conditions = $this->constructorConditions();
        $tagCondition = $this->tagConditions();
        if(empty($tagCondition))
            $xsd = $this->with('files','tags')->where($conditions)->orderBy($sort['sortAttr'], $sort['sortType'])->paginate($this->pageSize);

        //Если есть выбор по тегам
        else
            $xsd = $this->whereHas('tags', function ($query) {
                $query->where($this->tagConditions());
            })->with('files','tags')->where($conditions)->orderBy($sort['sortAttr'], $sort['sortType'])->paginate($this->pageSize);

        return $xsd;

    }

}

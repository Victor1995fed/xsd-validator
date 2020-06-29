<?php


namespace App\Models\Filters;


use App\Models\abstractModels\QuerySearch;
use Illuminate\Support\Facades\Auth;

class XsdSearch extends QuerySearch
{

    //Наименование параметра для применения сортировки
    protected $paramSortName = 'sort';
    //Сортировка по умолчанию
    protected $sortDefault = [
        'sortType' => 'asc',
        'sortAttr' => 'id'
    ];

    public static $pageSize = 10;
    //Переменные, которые разрешены в запросе
    protected $queryAccess = ['user_id', 'tag', 'public','sort'];

    //Список полей для сортировки
    protected $sortParameters = ['title', 'description', 'updated_at'];

    protected function user_id($value)
    {
        if(Auth::id() == $value){
            $this->model->where('user_id','=',$value);
        }
        else
            $this->model->where('user_id','=',$value)->where('public','=',1);
    }


    protected function tag($value)
    {
        $this->model->whereHas('tags', function ($query) use ($value) {
                $query->where('tag_id','=',$value);
            });
    }

    protected function applyFunction()
    {
        if(!property_exists($this->request,'user_id')){
            $this->model->where(function($query){
                $query->where('user_id', '=',Auth::id())
                    ->orWhere('public', '=', 1);
            });
        }

    }

    protected function public()
    {
        $this->model->where('public','=',1);

    }


    protected function applySort()
    {
        $sortInfo = $this->getSort();
        $this->model->orderBy($sortInfo['sortAttr'], $sortInfo['sortType']);
    }


    private function getSort() : array
    {
        $sort = $this->request[$this->paramSortName] ?? null;
        if($sort !== null && array_search($sortAttr = str_replace('-','',$sort), $this->sortParameters) !== false){
            $sortType = strripos($sort,'-') === false ? 'asc' : 'desc';
            return [
                'sortType' => $sortType,
                'sortAttr' => $sortAttr
            ];
        }
        else
            return $this->sortDefault;
    }




}

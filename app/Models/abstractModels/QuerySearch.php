<?php


namespace App\Models\abstractModels;


abstract class QuerySearch
{
    protected $model;
    protected $request;


    public function __construct($model,$request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    abstract protected function applyFunction();
    abstract protected function applySort();

    public function apply()
    {
        //Применение фильтрации
        foreach ($this->filters() as $filter => $value){
            if(method_exists($this,$filter) && in_array($filter,$this->queryAccess)){
                $this->$filter($value);
            }
        }
        //Дополнительная обработка данных перед сортировкой, если требуется
        $this->applyFunction();
        //Применение сортировки
        $this->applySort();
        return $this->model;
    }


    public function filters()
    {
        return $this->request->all();
    }
}

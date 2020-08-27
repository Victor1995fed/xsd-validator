<?php


namespace App\Modules;


class ConvertXml
{

    public $xml;
    public $defaultValue = null;
    public $clearValue = false;
    protected $array;


    /**
     * ConvertXml constructor.
     * @param $xml
     * @param $setValue
     * @throws \Exception
     */
   public function __construct($xml,$setValue,$clearValue)
   {
       $this->xml = $xml;
       $this->defaultValue = $setValue;
       $this->clearValue = $clearValue;
       $this->convertBase();

   }

    /**
     * @throws \Exception
     */
    public  function convertBase()
    {
        $xml = simplexml_load_string($this->xml);
        if(!$xml)
            throw new \Exception('Ошибка при конвертации xml, проверьте корректность переданных данных');

        $json = json_encode($xml, JSON_UNESCAPED_UNICODE);
        $this->array = json_decode($json,true);

        if($this->clearValue){
            $this->array = $this->setValueArray($this->array,$this->defaultValue);
        }

    }


    public function getArray()
    {
        return $this->array;
    }

    protected function varexport()
    {
        $export = var_export($this->array, true);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        return $export;
    }

    protected function setValueArray($array,$value=null)
    {
        $newArr = [];
        foreach ($array as $key=>$val){
            if(is_array($val))
                $newArr[$key] = $this->setValueArray($val,$value);
            else
                $newArr[$key] = $value;
        }
        return $newArr;
    }
}

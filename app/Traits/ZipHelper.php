<?php


namespace App\Traits;


trait  ZipHelper
{

    protected $extensionPermitted =  [
        'xsd'
        ];

    public function getListFiles($path)
    {
        $zip = new \ZipArchive;
        $listFiles = [];
        if ($zip->open($path) === true) {
            for( $i = 0; $i < $zip->numFiles; $i++ ){
                $stat = $zip->statIndex( $i );
                //Файлы только с расширением xsd
                if($this->isXsd($stat['name'])){
                    $listFiles[] = $stat['name'];

                }
            }
            return $listFiles;

        } else {
            throw new \Exception('Ошибка при  разборе архива',500);
        }
    }

    protected function isXsd($name)
    {
        $info = new \SplFileInfo($name);
        return in_array($info->getExtension(),$this->extensionPermitted);
    }
}

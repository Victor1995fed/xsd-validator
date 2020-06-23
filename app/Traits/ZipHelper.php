<?php


namespace App\Traits;


trait  ZipHelper
{
    public function getListFiles($path)
    {
        $zip = new \ZipArchive;
        $listFiles = [];
        if ($zip->open($path) === true) {
            for( $i = 0; $i < $zip->numFiles; $i++ ){
                $stat = $zip->statIndex( $i );
                $listFiles[] = basename( $stat['name'] );
            }
            return $listFiles;

        } else {
            throw new \Exception('Ошибка при  разборе архива',500);
        }
    }
}

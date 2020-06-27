<?php
namespace App\Modules;

use App\Constants\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\File as ModelFile;

class File {


    /**
     * Загрузка файла
     * @param UploadedFile $file
     * @param int $typeSave
     * @throws \Exception
     */
    public static function upload(UploadedFile $file, int $typeSave = 1)
    {
        $extention = $file->getClientOriginalExtension();
        $uuid = Str::uuid();
        $fileHash = md5_file($file->getRealPath());
        $fileName = "$uuid.$extention";
        //Временное сохранение файла
        if($typeSave == Storage::TMP_FILE) {
            $pathDir = base_path().'/'.Storage::TEMPORARY_STORAGE_PATH.'/'.$uuid;
            $file->move($pathDir,$fileName);
            return "$pathDir/$fileName";
        }
        //Сохранение файла с записью в БД
        elseif ($typeSave == Storage::LONG_TERM_FILE) {
            if($fileIsset = self::getFile($fileHash)) {
                return $fileIsset;
            }
            else {
                $pathDir = base_path().'/'.Storage::LONG_STORAGE_PATH.'/'.$uuid;
                $file->move($pathDir,$fileName);
                //сохранение данных файла в базу
                $newFile = new ModelFile();
                $newFile->title = $file->getClientOriginalName();
                $newFile->uuid = $uuid;
                $newFile->file_hash = $fileHash;
                $newFile->url = "$uuid/$fileName";
                if($newFile->save()) {
                    return $newFile;
                }
                else {
                    throw new \Exception('Ошибка при записи данных файла в БД');
                }
            }

        }


    }


    public static function getFile(string $hash)
    {
        if($file = ModelFile::where('file_hash',$hash)->first())
            return $file;
        else
            return false;
    }

}

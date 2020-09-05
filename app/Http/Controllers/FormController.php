<?php


namespace App\Http\Controllers;


use App\Constants\Storage as StorageConstants;
use App\Http\Requests\Form\GetForm;
use App\Modules\CreateForm\FormOldAis;
use App\Modules\CreateForm\Map;
use App\Modules\CreateForm\XsdParser;
use App\Modules\XsdValidator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function main()
    {
        return view('form.index', [

        ]);
    }

    public function getJson(GetForm $request)
    {

        try{
            $file = $request->file('zip');
            $zip = new \ZipArchive;
            $pathDirectory = base_path().'/'.StorageConstants::TEMPORARY_STORAGE_PATH.'/'.Str::uuid();
            $rootXsd = $request['main-xsd'];
            if ($zip->open($file->getPathname()) === true) {
                $zip->extractTo($pathDirectory);
                $zip->close();
                $pathXsd  = $pathDirectory.'/'.$rootXsd;
                $main = new XsdParser("1.0", 'UTF-8', file_get_contents($pathXsd));
                $main->joinImportXsd($pathXsd);
                //Поиск всех ссылок и вставка
                $searchElemAndGroup = $main->searchElemAndGroup($main->getElementsByAttrName($request['root-element']));

                $res =  $main->getRef($searchElemAndGroup);
                $res = $main->sortArray($res);
                File::deleteDirectory($pathDirectory);
                $form = new FormOldAis($res);
                return response()->json($form->getJsonForm(), 200,[],JSON_UNESCAPED_UNICODE);

            } else {
                throw new \Exception('Ошибка при  разборе архива',500);
            }

        }
        catch (\Exception $e) {
            File::deleteDirectory($pathDirectory);
            throw new \Exception($e->getMessage(),$e->getCode());
        }




    }
}

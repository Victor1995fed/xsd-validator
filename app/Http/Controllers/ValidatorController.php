<?php

namespace App\Http\Controllers;

use App\Http\Requests\Validate\CheckValidate;
use App\Modules\XsdValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Constants\Storage as StorageConstants;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ValidatorController extends Controller
{
    public function index()
    {
        return view('validator.index', [

        ]);
    }

    public function test()
    {
        return 'df';
    }

    public function check(CheckValidate $request)
    {
        try{
            $file = $request->file('zip');
            $zip = new \ZipArchive;
            $pathDirectory = base_path().'/'.StorageConstants::TEMPORARY_STORAGE_PATH.'/'.Str::uuid();
            $rootXsd = $request['main-xsd'];
            if ($zip->open($file->getPathname()) === true) {
                $zip->extractTo($pathDirectory);
                $zip->close();
                $validator = new XsdValidator;
                $validator->feedSchema =$pathDirectory.'/'.$rootXsd;
                $validated = $validator->validateFeedsStr($request['xml']);
                File::deleteDirectory($pathDirectory);

                if ($validated) {
                    return [
                        'status'=>true,
                        'message'=>'XML соответствует схеме',
                        'warning' => $validator->getWarnings()
                    ];
                } else {
                    return [
                        'status'=>false,
                        'message'=>'XML не соответствует схеме. Обнаружены следующие ошибки',
                        'errors' => $validator->getErrors()
                    ];
                }
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

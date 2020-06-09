<?php

namespace App\Http\Controllers;

use App\Modules\XsdValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ValidatorController extends Controller
{
    public function index()
    {
        return view('validator.index', [

        ]);
    }

    public function check(Request $request)
    {
        try{
            $file = $request->file('zip');
            $zip = new \ZipArchive;
            $pathDirectory = base_path().'/upload/'.Str::uuid(); //upload заменить константой
            $rootXsd = $request['main-xsd'];
            if ($zip->open($file->getPathname()) === true) {
                $zip->extractTo($pathDirectory);
                $zip->close();
                $validator = new XsdValidator;
                $validator->feedSchema =$pathDirectory.'/'.$rootXsd;
                $validated = $validator->validateFeedsStr($request['xml']);
                File::deleteDirectory($pathDirectory);

                if ($validated) {
                    return "Feed successfully validated";
                } else {
                   return print_r($validator->displayErrors(), 1);
                }
            } else {
                return 'Ошибка при  разборе архива';
            }

        }
        catch (\Exception $e) {
            File::deleteDirectory($pathDirectory);
            throw new \Exception($e->getMessage());
        }

    }
}

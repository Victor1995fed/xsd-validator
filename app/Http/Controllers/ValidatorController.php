<?php

namespace App\Http\Controllers;

use App\Modules\XsdValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public function check(Request $request)
    {
        $messages = [
            'xml.required' => 'Заполните xml для проверки',
            'zip.required' => 'Загрузите архив с xsd',
            'main-xsd.required' => 'Укажите имя корневой xsd',
        ];
        $validator = Validator::make($request->all(), [
            'main-xsd' => 'required|max:255',
            'zip' => 'required|max:20000|mimes:zip',
            'xml' => 'required',
        ],$messages);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->messages()
            ];
            return response()->json($response, 400 , [], JSON_UNESCAPED_UNICODE);
            return $validator->errors();
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }
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
                    return [
                        'status'=>true,
                        'message'=>'XML соответствует схеме'
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

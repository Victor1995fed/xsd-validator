<?php

namespace App\Http\Controllers;

use App\Constants\Storage;
use App\Modules\File;
use App\Modules\XsdValidator;
use App\Xsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Serializer;

class XsdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->page) && ( int )$request->page > 0)
            $page = (int)--$request->page;
        return view('xsd.index', [
            'xsd' =>  Xsd::with('files')->paginate(10,['*'],'page', $page ?? 0)
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('xsd.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['description'] = $request['description'] ?? '';

        DB::beginTransaction();
        try {
            $request['user_id'] = 1; //TODO:: Пока без авторизации

            if($xsd = Xsd::create($request->all())) {
                if($request->hasFile('xsd-file')) {
                    //Сохранение файла
                    $file = File::upload($request->file('xsd-file'),Storage::LONG_TERM_FILE);
                    //Сохранение связи
                    $xsd->files()->save($file);
                }
                else
                    throw new \Exception('Не передан файл с xsd');
            }
            else
                 throw new \Exception('Ошибка обработки пользовательских данных');



        }
        catch(\Exception $e)
        {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return redirect()->route('xsd.show',$xsd->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $xsd = Xsd::with('files')->findOrFail($id);
        return view('xsd.show', [
            'xsd' =>  $xsd
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function testXml($id)
    {
        $xsd = Xsd::with('files')->findOrFail($id);
        return view('xsd.test', [
            'xsd' =>  $xsd
        ]);
    }

    public function runTestXml(Request $request, $id)
    {
        //TODO:: Перенести в отдельный модуль
        $xsdModel = Xsd::with('files')->findOrFail($id);
        try{
            if(!isset($xsdModel->files[0]))
                throw new \Exception("Не найден файл  для данной схемы");

            $path = base_path().'/'.Storage::LONG_STORAGE_PATH.'/'.$xsdModel->files[0]->url;
            $zip = new \ZipArchive;
            $pathDirectory = base_path().'/'.Storage::TEMPORARY_STORAGE_PATH.'/'.Str::uuid();
            $rootXsd = $xsdModel->root_xsd;
            if ($zip->open($path) === true) {
                $zip->extractTo($pathDirectory);
                $zip->close();
                $validator = new XsdValidator;
                $validator->feedSchema =$pathDirectory.'/'.$rootXsd;
                $validated = $validator->validateFeedsStr($request['xml']);
                \Illuminate\Support\Facades\File::deleteDirectory($pathDirectory);

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

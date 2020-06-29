<?php

namespace App\Http\Controllers;

use App\Constants\Storage;
use App\Modules\File;
use App\Models\Tag;
use App\Traits\ZipHelper;
use App\Models\Filters\XsdSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use App\Modules\XsdValidator;
use App\Models\Xsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Serializer;

class XsdController extends Controller
{
    use ZipHelper;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show','indexPublic','testXml','runTestXml', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $xsd = Xsd::with('files','tags');
        $xsd = (new XsdSearch($xsd,$request))
            ->apply()
            ->paginate(XsdSearch::$pageSize);
        return view('xsd.index', [
            'xsd' =>  $xsd,
            'tags'=>Tag::all()
        ]);
    }

    /**
     * Display a listing of the resource public
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic(Request $request)
    {
        return view('xsd.index', [
            'xsd' =>  Xsd::with('files')->where('public', 1)->paginate(Xsd::$pageSize)
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('xsd.create', [
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $request['description'] = $request['description'] ?? '';
            $request['user_id'] = Auth::id();
            $request['public'] = isset($request['public']) ? 1 : 0;
            if($xsd = Xsd::create($request->all())) {
                //Сохранение меток
                $xsd->tags()->attach($request->tags);
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
        $xsd = Xsd::with('files', 'tags')->findOrFail($id);
        $tagsId =  $xsd->getIdTags($xsd->tags);
        $this->checkAccess($xsd);
        $file = $xsd->files->first();
        $listFilesZip = $this->getListFiles(base_path().'/'.Storage::LONG_STORAGE_PATH.'/'.$file->url);
        return view('xsd.edit',  [
            'xsd' =>  $xsd,
            'listFilesZip' => $listFilesZip,
            'tags' => Tag::all(),
            'choiceTag' => $tagsId
        ]);

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
        $xsd = Xsd::with('files')->findOrFail($id);
        $this->checkAccess($xsd);
        $request['description'] = $request['description'] ?? $xsd->description;
        $request['public'] = isset($request['public']) ? 1 : 0;
        $idFiles = $this->getIdFiles($xsd->files);
        DB::beginTransaction();
        try {
            if($xsd->fill($request->all())->save()){
                //Загрузка новых меток
                $xsd->tags()->detach();
                $xsd->tags()->attach($request->tags);
                //Если загружен новый файл
                if($request->hasFile('xsd-file')){
                    $xsd->files()->detach($idFiles);
                    $file = File::upload($request->file('xsd-file'),Storage::LONG_TERM_FILE);
                    //Сохранение связи
                    $xsd->files()->save($file);
                }
            }
            else
                throw new \Exception('Ощибка при обновлени данных');

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $xsd = Xsd::with('files')->findOrFail($id);
        $this->checkAccess($xsd);
        $idFiles = $this->getIdFiles($xsd->files);
        //destroy  relations
        $xsd->files()->detach($idFiles);
        //FIXME:: Удаляются связи, но не файлы, т.к. файл может иметь еще одну связь с другой xsd (доработать логику)
        //ModelFile::destroy($idFiles);
        $xsd->delete();
        return redirect()->route('xsd.index');
    }

    /**
     * Получает id файлов
     *
     * @param  object  $files
     * @return array
     */
    private function getIdFiles( $files ):array
    {
        $idFiles = [];
        foreach ($files as $fileOne) {
            $idFiles[] = $fileOne->id;
        }
        return  $idFiles;
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
        $messages = [
            'xml.required' => 'Заполните xml для проверки',
        ];
        $validator = Validator::make($request->all(), [
            'xml' => 'required',
        ],$messages);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->messages()
            ];
            return response()->json($response, 400 , [], JSON_UNESCAPED_UNICODE);
        }
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
                FacadesFile::deleteDirectory($pathDirectory);

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
                throw new \Exception('Ошибка при разборе архива',500);
            }

        }
        catch (\Exception $e) {
            FacadesFile::deleteDirectory($pathDirectory);
            throw new \Exception($e->getMessage(),$e->getCode());
        }
    }

}

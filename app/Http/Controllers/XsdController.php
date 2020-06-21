<?php

namespace App\Http\Controllers;

use App\Constants\Storage;
use App\Modules\File;
use App\Xsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Serializer;

class XsdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('xsd.index', [
            'trainings' =>  Xsd::with('tries.exercises')->paginate(10,['*'],'page', $page ?? 0)
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

        DB::beginTransaction();
        try {
            $request['user_id'] = 1; //TODO:: Пока без авторизации

            if($xsd = Xsd::create($request->all())) {
                if($request->hasFile('xsd-file')) {
                    //Сохранение файла
                    $file = File::upload($request->file('xsd-file'),Storage::LONG_TERM_FILE);
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
        return $xsd->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}

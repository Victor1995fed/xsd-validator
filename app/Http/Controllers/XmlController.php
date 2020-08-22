<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Xml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class XmlController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request['user_id'] = Auth::id();
        if($xml = Xml::create($request->all())) {
            return response()->json($xml, 200 , [], JSON_UNESCAPED_UNICODE);
        }
        else
            throw new \Exception('Ошибка при сохранении');
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
        $xml = Xml::findOrFail($id);
        $this->checkAccess($xml);
        if($xml->fill($request->all())->save())
            return response()->json($xml, 200 , [], JSON_UNESCAPED_UNICODE);
        else
            throw new \Exception('Ошибка при сохранении');
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

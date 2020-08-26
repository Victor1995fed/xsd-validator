<?php

namespace App\Http\Controllers;

use App\Http\Requests\Xml\StoreXml;
use App\Http\Requests\Xml\UpdateXml;
use App\Models\Tag;
use App\Models\Xml;
use App\Modules\ConvertXml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class XmlController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'getFormat']]);
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
     * @param StoreXml $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(StoreXml $request)
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
        $xml = Xml::where(function($query){
            $query->where('user_id', '=',Auth::id())
                ->orWhere('public', '=', 1);
        })->findOrFail($id);
        return response($xml->content, 200, [
            'Content-Type' => 'application/xml'
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
     * @param UpdateXml $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateXml $request, $id)
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


    public function getFormat(Request $request)
    {
        $format = $request->get('format');
        $clearValue = $request->get('clear_value') == 1;
        $convert = new ConvertXml($request->getContent(),$request->get('set_value'),$clearValue);

        switch ($format){
            case 'json':
                return $convert->convertJson();
            case 'php_array':
                return $convert->convertPhpArray();
            default :
                return 'Не указан корректный формат (примеры: json, php_array, ...)';

        }
    }

    public function converter()
    {
        return view('xml.convert',  [

        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\UpdateStoreTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tag.index', [
            'tag' =>  Tag::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateStoreTag $request)
    {

            $request['user_id'] = Auth::id();
            if($tag = Tag::create($request->all())) {
                return redirect()->route('tag.index');
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
    public function update(UpdateStoreTag $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $this->checkAccess($tag);
        if($tag->fill($request->all())->save())
            return redirect()->route('tag.index');

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
        $tag = Tag::findOrFail($id);
        $this->checkAccess($tag);
        $tag->delete();
        $tag->xsd()->detach();
        return redirect()->route('tag.index');
    }
}

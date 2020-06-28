<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Xsd extends Model
{
    protected $table = 'xsd';

    protected $fillable = ['title', 'root_xsd', 'user_id', 'description', 'public'];


    /**
     * Связь с files
     */
    public function files()
    {
        return $this->belongsToMany(File::class,'xsd_files','xsd_id','file_id');
    }

    /**
     * Связь с tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'xsd_tags','xsd_id','tag_id');
    }

    /**
     * Получить только id меток
     */
    public function getIdTags($tags):array
    {
        $tagsId = [];
        foreach ($tags as $tag){
            $tagsId[] = $tag->id;
        }
        return $tagsId;
    }

}

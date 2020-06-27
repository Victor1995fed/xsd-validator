<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title',  'user_id'];

    /**
     * Связь с xsd
     */
    public function xsd()
    {
        return $this->belongsToMany(Xsd::class,'xsd_tags','tag_id','xsd_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Связь с xsd
     */
    public function xsd()
    {
        return $this->belongsToMany(Xsd::class,'xsd_files','file_id','xsd_id');
    }
}

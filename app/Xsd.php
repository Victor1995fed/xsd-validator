<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xsd extends Model
{
    protected $table = 'xsd';

    protected $fillable = ['title', 'root_xsd', 'user_id', 'description'];


    /**
     * Связь с files
     */
    public function files()
    {
        return $this->belongsToMany(File::class,'xsd_files','xsd_id','file_id');
    }

}

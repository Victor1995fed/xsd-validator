<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Xml extends Model
{
    protected $table = 'xml';

    protected $fillable = ['title',  'user_id', 'content'];
    /**
     * Связь с xsd
     */
    public function xsd()
    {
        return $this->belongsToMany(Xsd::class,'xsd_xml','xml_id','xsd_id');
    }
}

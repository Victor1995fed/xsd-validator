<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xsd extends Model
{
    protected $table = 'xsd';

    protected $fillable = ['title', 'root_xsd',  'description'];
}

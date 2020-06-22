<?php

namespace App\Http\Controllers;

use App\Constants\Storage;
use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function download($uuid)
    {
        $file = File::where('uuid', '=', $uuid)->firstOrFail();
        return response()->download(base_path().'/'.Storage::LONG_STORAGE_PATH.'/'.$file->url);
    }


}

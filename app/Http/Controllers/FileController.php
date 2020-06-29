<?php

namespace App\Http\Controllers;

use App\Constants\Storage;
use App\Constants\Storage as StorageConstants;
use App\Models\File;
use App\Modules\XsdValidator;
use App\Traits\ZipHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    use ZipHelper;

    public function download($uuid)
    {
        $file = File::where('uuid', '=', $uuid)->firstOrFail();
        return response()->download(base_path().'/'.Storage::LONG_STORAGE_PATH.'/'.$file->url);
    }

    /**
     * Проверка zip-архива
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function getListFilesZip(Request $request)
    {
        $messages = [
            'zip.required' => 'Загрузите архив с xsd',
        ];
        $validator = Validator::make($request->all(), [
            'zip' => 'required|max:20000|mimes:zip',
        ],$messages);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->messages()
            ];
            return response()->json($response, 400 , [], JSON_UNESCAPED_UNICODE);
        }
        try{
            $file = $request->file('zip');
            return $this->getListFiles($file->getPathname());
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage(),$e->getCode());
        }
    }


}

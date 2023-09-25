<?php

namespace App\Http\Controllers;

use App\Models\ReportedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportedFileController extends Controller
{
    
    public function download($id){
        $file = ReportedFile::where("id",$id)
            -> where("user_id", Auth::id())
            -> firstOrFail();

        return Storage::download($file->path_on_storage);
    }

    public function metadata($id) {
        $file = ReportedFile::where("id",$id)
            -> where("user_id", Auth::id())
            -> firstOrFail();

        return response()->json($file);
    }
}

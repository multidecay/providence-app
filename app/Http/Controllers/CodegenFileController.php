<?php

namespace App\Http\Controllers;

use App\Models\Codegen;
use App\Models\CodegenFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodegenFileController extends Controller
{

    public function create(int $codegen_id)
    {
        return view(
            'pages.dashboard.codegen-file-new',
            [
                "codegen_id" => $codegen_id,
                "template" => "{{# commands}}
This enumrate the commands from maids : {{.}}
{{/commands}}

{{# abilities}}
This enumrate the abilities from maids : {{.}}
{{/abilities}}"
            ]
        );
    }

    public function add_file(Request $request)
    {
        if(!$request->has("codegen_id"))
        {
            return response("need codegen_id",422);
        }

        if(!$request->has("filename") || !$request->has("content"))
        {
            return response("need filename or content",422);
        }
        $filename = $request->input("filename");
        $content = $request->input("content");

        $codegen = Codegen::where('user_id',Auth::id())
            -> where("id", $request->input("codegen_id"))
            -> firstOrFail();

        try {
            $file = CodegenFile::create([
                'codegen_id' => $codegen->id,
                'user_id' =>$codegen->user_id,
                'filename' => $filename,
                'content' => $content,
            ]);;
    
            if($file){
                return redirect("/dashboard/codegen/$codegen->id");
            }
        } catch (\Throwable $th) {
            return response($th->getMessage(),500);
        }
    }

    public function update($codegen_id,$id)
    {
        $file = CodegenFile::where('user_id',Auth::id())
        -> where("id", $id)
        -> where("codegen_id", $codegen_id)
        -> firstOrFail();

        return view('pages.dashboard.codegen-file-update',[
            'file' => $file,
        ]);
    }

    public function update_file(Request $request)
    {
        if(!$request->has("codegen_id"))
        {
            return response("need codegen_id",422);
        }

        if(!$request->has("filename") || !$request->has("content"))
        {
            return response("need filename or content",422);
        }
        $filename = $request->input("filename");
        $content = $request->input("content");

        $codegen = Codegen::where('user_id',Auth::id())
            -> where("id", $request->input("codegen_id"))
            -> firstOrFail();

        $file = CodegenFile::where('user_id',Auth::id())
        -> where("id", $request->input("id"))
        -> where("codegen_id", $codegen->id)
        -> firstOrFail();

        try {
            $file->filename = $filename;
            $file->content = $content;
            $file->save();

            return redirect("/dashboard/codegen/$codegen->id");
        } catch (\Throwable $th) {
            return response($th->getMessage(),500);
        }
    }

    public function delete_file($id)
    {
        $file = CodegenFile::where('user_id',Auth::id())
        -> where("id", $id)
        -> firstOrFail();

        $codegen_id = $file->codegen_id;
        $file->delete();

        return redirect("/dashboard/codegen/$codegen_id");
    }
}

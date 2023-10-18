<?php

namespace App\Http\Controllers;

use App\Models\Codegen;
use App\Models\CodegenFile;
use App\Models\Maid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mustache_Engine;

class CodegenController extends Controller
{
    //
    public function index()
    {
        $codegens = Codegen::where("user_id", Auth::id())->get();
        return view('pages.dashboard.codegens', [
            "codegens" => $codegens
        ]);
    }

    public function show($id){
        $codegen = Codegen::where("user_id", Auth::id())
            -> where("id",$id)
            -> firstOrFail();

        $files = CodegenFile::where("user_id", Auth::id())
        -> where("codegen_id",$codegen->id)->get();

        return view('pages.dashboard.codegen', [
            "codegen" => $codegen,
            "files" => $files
        ]);
    }

    public function create()
    {
        return view('pages.dashboard.codegen-new');
    }

    public function store(Request $request)
    {
        if(!$request->has(["name","language"]))
        {
            return response("need name and language input",422);
        }

        if(!$request->has(["filename","content"]))
        {
            return response("need filename and contens field", 422);
        }

        $filenames = $request->input("filename");
        $contens = $request->input("content");

        if(!is_array($filenames))
        {
            return response("filenames is not array",422);
        }

        if(!is_array($contens))
        {
            return response("contents is not an array",422);
        }

        $codegen = Codegen::create([
            "name" => $request->input("name"),
            "language" => $request->input("language"),
            "user_id" => Auth::id()
        ]);

        for ($filei=0; $filei < sizeof($filenames) ; $filei++) { 
            $filename = $filenames[$filei];
            $content = $contens[$filei];

            if($filename != "" and $content != ""){
                CodegenFile::create([
                    "codegen_id" => $codegen->id,
                    "user_id" => Auth::id(),
                    "filename" => $filename,
                    "content" => $content,
                ]);
            }
        }

        return redirect("/dashboard/codegens");

    }

    public function update($id)
    {

        return view('pages.dashboard.codegen-update', ["codegen_id"=>$id]);
    }

    public function update_name_and_language(Request $request)
    {
        $codegen_id = $request->input("codegen_id");
        $name = $request->input("name");
        $lang = $request->input("language");

        $codegen = Codegen::where("id",$codegen_id)
            -> firstOrFail();

        $codegen->name = $name;
        $codegen->language = $lang;
        $codegen->save();

        return redirect("/dashboard/codegen/$codegen->id");
    }

    public function generate_page(Request $request)
    {
        $maid_id = $request->input("maid_id");
        $codegen_id = $request->input("codegen_id");
        $content = $this->gencode($maid_id,$codegen_id);

        if(!is_array($content)){
            return $content;
        }
        
        return view('pages.dashboard.codegen-generated', $content);
    }

    private function gencode($maid_id, $codegen_id)
    {
        $maid = Maid::where("id",$maid_id)
            -> where("user_id", Auth::id())
            -> firstOrFail();

        $codegen = Codegen::where("id",$codegen_id)
            -> where("user_id", Auth::id())
            -> firstOrFail();

        $files = CodegenFile::where("codegen_id",$codegen->id)
            -> where("user_id", Auth::id())
            -> get();

       

        $payload = array(
            "commands" => $maid->commands,
            "abilites" => $maid->abilities,
        );

        $engine = new Mustache_Engine();
        $rendered = array();

        foreach($files as $file)
        {
            $content = $engine->render($file->content,$payload);
            $rendered["$file->filename"] = $content;
        }

        return array(
            "codes" => $rendered,
            "maid_name" => $maid->name,
            "codegen_name" => $codegen->name,
        );
    }
}

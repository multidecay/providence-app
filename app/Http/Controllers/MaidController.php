<?php

namespace App\Http\Controllers;

use App\Models\Maid;
use App\Http\Requests\StoreMaidRequest;
use App\Http\Requests\UpdateMaidRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class MaidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maids = Maid::where("user_id",Auth::id())->forPage(1,10)->get();
        return view('pages.dashboard.maids', [
            "maids"=>$maids,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.maid-new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaidRequest $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string', Rule::unique(Maid::class)],
            'abilities' => ['required', 'string'],
            'commands' => ['required','string'],
        ]);

        // validate abilites input is json array and commands json assoc array

        $signature = Str::random(64);
        $auth = Auth::id();

        $maid = Maid::create([
            'name' => $request->name,
            'abilities' => $request->abilities,
            'commands' => $request->commands,
            'signature' => $signature,
            'user_id' => $auth,
        ]);

        return redirect("/dashboard/maid/{$maid->id}");
         
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maid = Maid::where("id",$id)->firstOrFail();
        return view('pages.dashboard.maid',["maid" => $maid]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maid $maid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaidRequest $request, Maid $maid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maid $maid)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Maid;
use App\Models\Task;
use App\Models\Device;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($device_id)
    {
        if(is_null($device_id)){
            return response(422);
        };

        $tasks = Task::where('user_id',Auth::id())
        ->where('device_id', $device_id)
        ->get();

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     * @param device_id number 
     */
    public function create($device_id)
    {
        // 1. Get device information
        $device = Device::where("id","=",$device_id)
            ->where("user_id",Auth::id())
            ->firstOrFail();

        // 2. Get the device's maids information
        $maid = Maid::where("id","=",$device->maid_id)
            ->where("user_id",Auth::id())
            ->firstOrFail();

        // 3. Return with command and device ability for
        // option matching at view, javascript took the job

        return view('pages.dashboard.tasks-new',[
            "device_abilities" => json_encode($device->abilities),
            "maid_commands" => json_encode($maid->commands),
            "device_id" => $device->id ,
            "maid_id" => $maid->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $maid = Maid::where('user_id', Auth::id())
            -> where('id', $request->maid_id)
            -> firstOrFail();

        $device = Device::where('user_id', Auth::id())
            -> where('id',$request->device_id)
            -> firstOrFail();

        // Parse Maid Commands list, transform to assoc_value
        // then grab the ability based on commands from request
        $command = json_decode($maid->commands);
        if(is_null($command)){
            return Redirect::back()->withErrors(['task_new' => 'Failed read maid command definition, check your maid configuration.']);
        }

        // checking is commands from request are available 
        // in maid commands list
        $command_abilties = $command->{$request->command};
        if(is_null($command_abilties) or !is_array($command_abilties))
        {
            return Redirect::back()->withErrors(['task_new' => 'Failed read maid command abilities definiton, check your maids configuration.']);
        }

        // mix-match device abilities and command abilities
        // requirment
        foreach ($command_abilties as $ability) {
            if(!in_array($ability,json_decode($device->abilities)))
            {
                $command_compatible = false;
                return Redirect::back()->withErrors(['task_new' => 'Maid command incompatible with abilities privilege that device own.']);
            }
        };

        $task = Task::create([
            'command' => $request->command,
            'argument' => $request->argument,
            'device_id' => $device->id,
            'maid_id' => $maid->id,
            'state' => 'wait_to_pick',
            'user_id' => Auth::id(),
        ]);

        return redirect("/dashboard/device/{$device->id}");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::where("id",$id)
            ->where("user_id",Auth::id())
            ->firstOrFail();

        // // 1. Get device information
        // $device = Device::where("id","=",$task->device_id)
        //     ->where("user_id",Auth::id())
        //     ->firstOrFail();

        // // 2. Get the device's maids information
        // $maid = Maid::where("id","=",$task->maid_id)
        //     ->where("user_id",Auth::id())
        //     ->firstOrFail();
    
        
        return view('pages.dashboard.task-report',[
            // "device_abilities" => json_encode($device->abilities),
            // "maid_commands" => json_encode($maid->commands),
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Device::destroy($id);
    }

    public function reporting()
    {

    }
}

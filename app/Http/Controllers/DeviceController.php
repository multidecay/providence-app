<?php

namespace App\Http\Controllers;
use App\Enum\TaskStateEnum;
use App\Models\ReportedFile;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Maid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Enum\ReportTypeEnum;
use JOSE_JWE;
use JOSE_JWT;
use Torann\GeoIP\Facades\GeoIP;

class DeviceController extends Controller
{

    public function devices()
    {
        return view('pages.dashboard.devices', [
            "devices" => Device::where('user_id','=',Auth::id())->get(),
        ]);
    }

    // get devices info
    public function device($device_id)
    {
        $device = Device::where("id","=",$device_id)
            -> where("user_id","=",Auth::id())
            ->firstOrFail();

        return view('pages.dashboard.device', [
            "device" => $device
        ]);
    }

    public function delete($device_id) 
    {
        $device = Device::where("id","=",$device_id)
            -> where("user_id","=",Auth::id())
            ->firstOrFail();

        $device->delete();

        return redirect("/dashboard/devices");
    }

    // device register to providence
    public function device_register(Request $request)
    {

        // 1. check there registered maid signature
        if($request->input('signature') == ""){
            return response('nosign',422);
        }

        if($request->input('hwid') == ""){
            return response('nohwid',422);
        }

        if($request->input('operating_system') == ""){
            return response('noos',422);
        }

        if($request->input('hostname') == "") {
            return response('nohostname',422);
        }

        $maid = Maid::where('signature','=',$request->input('signature'))
             ->firstOrFail();

        // 2. check is hwid already registered
        $device = Device::where('hwid','=',$request->input('hwid'))->first();
        if(!is_null($device)) {
            return response("already registered",422);
        }

        // 2.5 Validate maid abilities with device abilities
        $device_ablities = json_decode($request->input('abilities'));
        if(!is_array($device_ablities)){
            return response("ability not array",422);
        };

        $maid_abilities = json_decode($maid->abilities);

        if(array_count_values($maid_abilities) < array_count_values($device_ablities)) {
            return response("ability not compatible ".json_encode($device_ablities,true),422);
        }

        $is_device_compatible = true;
        foreach ($device_ablities as $ability) {
            $is_device_compatible &= in_array($ability,$maid_abilities);
        }

        if(!$is_device_compatible){
            return response("device not compatible",422);
        }

        // 3. this should retrive device meta data
        $device = Device::create([
            'hwid' => $request->input("hwid"),
            'operating_system' => $request->input("operating_system","unknown"),
            'maid_id'=> $maid->id,
            'ip' => $request->ip(),
            'hostname' => $request->input("hostname"),
            'country_code' => geoip($request->ip())['iso_code'],
            'abilities' => json_encode($device_ablities),
            'notes' => $request->input("notes",""),
            'user_id' => $maid->user_id,
        ]);

        // 3.5 encrypt the payload
        try {
            $jwe = new JOSE_JWE("$device->id|$device->hwid");
            $jwe->encrypt(file_get_contents(env('APP_PUBLIC_KEY')));
            return response($jwe->toString(),200);
        } catch (\Throwable $th) {
            $device->delete();
            return response("",500);
        }

        // 4. return device signature for it
    }

    // device ask for task
    public function device_task(Request $request)
    {
        // 1. Get user_id
        $valid = $request->header("Authorization",null);

        if(is_null($valid)){
            return response("invalid token",422);
        }

        $jwe = "";
        $jwe_payload = "";
        try {
            $jwe = JOSE_JWT::decode($valid);
            $jwe_payload = $jwe->decrypt(file_get_contents(env('APP_PRIVATE_KEY')))->plain_text;
        } catch (\Throwable $th) {
            return response("",422);
        }
        if ($jwe == "" || $jwe_payload == ""){
            return response("",422);
        }

        $device = explode("|",$jwe_payload);
        if(count($device) != 2){
            return response("unable parse auth token $jwe_payload",422);
        }

        $device = Device::where('id',$device[0])
            -> firstOrFail();

        $device->ip = $request->ip();
        $device->country_code = geoip($request->ip())["iso_code"];
        $device->save();

        // 2. Find the oldest task
        $task = Task::where("device_id",$device->id)
            ->where("state",TaskStateEnum::WTP)
            ->orderBy('created_at')
            ->first();

        if(is_null($task)){
            return response("",200);
        }

        // this place can is troublesome if error
        // so JWT thingy should do before write anything 
        // to DB

        $jwt = new JOSE_JWT(array(
            'task_id' => $task->id,
            'command' => $task->command,
            'argument' => $task->argument,
        ));

        $jws = $jwt->sign(file_get_contents(env('APP_PRIVATE_KEY')),'RS256');

        $task->state = TaskStateEnum::Delivered;
        $task->received_at = now();
        $task->save();

        // 3. Return the task as request
        return response()->json([
            "token" => $jws->toString(),
            "command" => $task->command,
            "argument" => $task->argument
        ]);
    }

    // device report the task result
    public function device_report(Request $request)
    {
         // 1. Find Task id
         $valid = $request->validate([
            'token' => 'required',
            'type' => ['required', new Enum(ReportTypeEnum::class)],
            'message' => 'required',
        ]);

        if(!$valid){
            return response("invalid request payload",422);
        }

        // 1.2 Parse get device id from authorization token
        $valid = $request->header("Authorization",null);

        if(is_null($valid)){
            return response("invalid token",422);
        }

        $jwe = "";
        $jwe_payload = "";
        try {
            $jwe = JOSE_JWT::decode($valid);
            $jwe_payload = $jwe->decrypt(file_get_contents(env('APP_PRIVATE_KEY')))->plain_text;
        } catch (\Throwable $th) {
            return response("",422);
        }
        if ($jwe == "" || $jwe_payload == ""){
            return response("",422);
        }

        $device = explode("|",$jwe_payload);
        if(count($device) != 2){
            return response("unable parse auth token $jwe_payload",422);
        }

        // 1.3 
        $jws = JOSE_JWT::decode($request->token);
        if(!$jws->verify(file_get_contents(env("APP_PUBLIC_KEY")))){
            return response("cannot verify report",422);
        }

         // 2. Do reporting
        $task = Task::where("device_id",$device[0])
        -> where("id",$jws->claims['task_id'])
         ->where("state","delivered")
         ->firstOrFail();

        if( ($jws->claims["command"] != $task->command) &&
            ($jws->claims["argument"] != $task->argument)
        ) {
            return response("token forged", 422);
        }

        //2.5 Handle upload form
        if(($request->input('type') != ReportTypeEnum::File->value) && $request->hasFile('message')){
            return response("type invalid, given ".$request->input("type"),422);
        }

        $message = $request->input('message');
        if($request->hasFile('message')){
            $file = $request->file('message');
            if(!$file->isValid()){
                return response("file upload fail", 422);
            }

            $filename = $file->getClientOriginalName()."_".time().".".$file->getClientOriginalExtension();

            $path = $file->storeAs("report_files/".$task->user_id,$filename);

            $rfile = ReportedFile::create([
                'user_id' => $task->user_id,
                'task_id' => $task->id,
                'filename' => $file->getClientOriginalName(),
                'mimes' => $file->getClientMimeType(),
                'path_on_storage' => $path
            ]);

            $message = $rfile->id;
        }

        $task->state = TaskStateEnum::Reported;
        $task->report_type = $request->input('type');
        $task->report_message = $message;
        $task->reported_at = now();
        $task->save();
         // 3. Return nothing
        return response("",200);
    }
}

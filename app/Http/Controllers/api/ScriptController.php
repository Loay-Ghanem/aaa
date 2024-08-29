<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\settings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class ScriptController extends Controller
{
    // hi daddy
    public function callPythonScript(Request $request)
    {
        // ... (rest of your code)
        $request->validate([
            "image" => "required",
        ]);
        //$settings = settings::first();
        $path = 'temp';
        $imagePath = $request->file('image')->storeAs($path, '1.png', 'public');
        $imagePath = Storage::url($imagePath);

        // Define Python path and script path
        // $python_path = 'C:\\Users\\digit\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
        $python_path = 'C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
        $script_path = 'C:\\xampp\\htdocs\\aaa\\imageRec.py';

        // Pass data as argument (modify based on Python script)
        //$data1 = 3;
        // Assuming script expects an integer
        //$var = escapeshellarg($data);
        $command = $python_path . ' ' . $script_path;
        // $settings->counter++;
        // $settings->save();
        try {
            $output = shell_exec($command);
            $result = json_decode($output, true);
            File::delete(public_path($imagePath));
            dd($result);
            if (Employee::where('plate', $this->extract_alphanumeric($result))->where('is_active', true)->exists()) {
                $activity = Activity::lastest();
                $activity->update(['status' => true]);
                return response()->json([
                    'message' => 'Employee is registered and active in the system ',
                    'result' => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Employee is inactive or doesn\'t exist',
                    'result' => false
                ], 404);
            }
        } catch (Exception $e) {
            // Handle errors appropriately (e.g., log error, return error response)
            return response()->json(['message' => 'Error executing Python script'], 500);
        }
    }
    function extract_alphanumeric($string)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }

    public function close(){
        $activities=Activity::orderBy('id','desc')->first();
        // dd($activities->status);
        $activities->update(['status'=>0]);
        return response()->json([$activities->status],200);
    }
    public function open(){
        $activities=Activity::orderBy('id','desc')->first();
        // dd($activities->status);
        $activities->update(['status'=>1]);
        return response()->json([$activities->status],200);
    }
    public function status(){
        $activities=Activity::orderBy('id','desc')->first('status');
        return $activities;
    }


}

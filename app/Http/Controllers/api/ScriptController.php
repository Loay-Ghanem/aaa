<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $settings = settings::first();
        $path = 'temp';
        $imagePath = $request->file('image')->storeAs($path, '1.png', 'public');
        $imagePath = Storage::url($imagePath);
        // Define Python path and script path
        $python_path = 'C:\\Users\\digit\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
        $script_path = 'C:\\xampp\\htdocs\\aaa\\imageRec.py';

        // Pass data as argument (modify based on Python script)
        //$data1 = 3;
        // Assuming script expects an integer
        //$var = escapeshellarg($data);
        $command = $python_path . ' ' . $script_path . ' ' . escapeshellarg($settings->counter);
        // $settings->counter++;
        // $settings->save();
        try {
            $output = shell_exec($command);
            $result = json_decode($output, true);
            File::delete(public_path($imagePath));
            if (Employee::where('plate', $this->extract_alphanumeric($result))->where('is_active', true)->exists()) {
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


}

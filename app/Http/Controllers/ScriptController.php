<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function callPythonScript(Request $request)
    {
        // ... (rest of your code)

        // Define Python path and script path
        $python_path = 'C:\\Users\\digit\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
        $script_path = 'C:\\xampp\\htdocs\\aaa\\imageRec.py';

        // Pass data as argument (modify based on Python script)
        $data1 = 199;
        $data2 = 299; // Assuming script expects an integer
        //$var = escapeshellarg($data);
        $command = $python_path . ' ' . $script_path . ' ' . escapeshellarg($data1) . ' ' . escapeshellarg($data2);

        try {
            $output = shell_exec($command);
            $result = json_decode($output, true);

            return response()->json([
                'message' => 'Success',
                'result' => $result
            ]);
        } catch (Exception $e) {
            // Handle errors appropriately (e.g., log error, return error response)
            return response()->json(['message' => 'Error executing Python script'], 500);
        }
    }
}

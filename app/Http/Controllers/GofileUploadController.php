<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GofileUploadController extends Controller
{
    public function upload(Request $request)
    {

        $token = "x6TmjmufPiEM5zqqCRtr1AbdnHtdN2jm";
        $id = "eed8f40a-69c0-4aca-bd87-2d21b6667122";
        $request->validate([
            'file' => 'required|file|max:512000', // 500MB limit
        ]);

        $file = $request->file;

        // Get best server to upload
        $serverResponse = Http::get('https://api.gofile.io/getServer');

        if (!$serverResponse->ok()) {
            return response()->json(['error' => 'Server not found'], 500);
        }

        $server = $serverResponse['data']['server'];

        // Upload to GoFile
    
        $uploadResponse = Http::attach(
            'file', file_get_contents($file), $file->getClientOriginalName()
        )->post("https://{$server}.gofile.io/uploadFile");

        if (!$uploadResponse->ok()) {
            return response()->json(['error' => 'Upload failed'], 500);
        }

        $data = $uploadResponse['data'];

        return response()->json([
            'downloadPage' => $data['downloadPage'],
            'directLink' => $data['directLink'],
        ]);
    }
}

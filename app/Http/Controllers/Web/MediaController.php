<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MediaController extends Controller
{
    public function show($path)
    {
        // Construct the full file path
        pre('test');
        $fullPath = public_path("media/{$path}");

        // Check if the file exists
        if (file_exists($fullPath)) {
            return Response::file($fullPath);
        }

        // Return a 404 response if the file does not exist
        abort(404);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PictureController extends Controller
{
    public function index(string $file)
    {
        $path = 'pictures/' . $file;

        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['message' => 'File not found.'], Response::HTTP_NOT_FOUND);
        }

        $mimeType = Storage::disk('public')->mimeType($path);
        $image = Storage::disk('public')->get($path);
        return response($image, 200)->header('Content-Type', $mimeType);
    }
}

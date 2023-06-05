<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $image = $request->file('file');

            $imageName = Str::uuid() . '.' . $image->extension();

            $imageToStore = Image::make($image);
            $imageToStore->fit(1000, 1000);
            $imageToStore->save(public_path('uploads/') . $imageName);

            return response()->json(['image' => $imageName]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}

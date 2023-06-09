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

            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0777, true);
            }
            
            $image = $request->file('file');

            $imageName = Str::uuid() . '.' . $image->extension();

            $imageToStore = Image::make($image);
            $imageToStore->fit(1000, 1000);
            $imageToStore->save(public_path('uploads/') . $imageName);

            return response()->json(['image' => $imageName]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}

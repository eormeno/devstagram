<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request, User $user)
    {
        return view('profile.index', [
            'user' => $user
        ]);
    }

    public function store(Request $request, User $user)
    {
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => [
                'required',
                'min:3', 'max:20',
                'unique:users,username,' . $user->id,
                'alpha_dash',
                'lowercase',
                'not_in:twitter,facebook,instagram'
            ],
        ]);

        $current_profile_image = $user->profile_image;

        if ($request->profile_image) {
            $image = $request->file('profile_image');

            if ($current_profile_image !== 'default.svg') {
                unlink(public_path('profile_images/') . $current_profile_image);
            }

            $current_profile_image = Str::uuid() . '.' . $image->extension();
    
            $imageToStore = Image::make($image);
            $imageToStore->fit(512, 512);
            $imageToStore->save(public_path('profile_images/') . $current_profile_image);
        }

        $user->update([
            'username' => $request->username,
            'profile_image' => $current_profile_image
        ]);

        return redirect()->route('profile.index', $user);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helper;


class ImageController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'Image' => 'mimes:png,jpg,jpeg,svg|max:2048',
        ]);

 
        $image = $request->file('Image');

        $imageName = str_replace(' ', '-', "en") . '-' . time();

        $imageWithExt = $imageName . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('img'),   $imageWithExt);
        if ($image->getClientOriginalExtension() != 'svg') {

            Helper::convertImageToWebP(public_path('img')."/" . $imageWithExt, public_path('img/webp')."/" . $imageName . '.webp', 80);
        }
        $ImageWebp="";

        if ($image->getClientOriginalExtension() != 'svg') {

           $ImageWebp = $imageName . '.webp';
        }

       return response()->json(['file' =>url("/img/{$imageWithExt}"), 'type' => $image->getClientOriginalExtension(),'Webp' => $ImageWebp?url("/img/webp/{$ImageWebp}"):"",]);

    }
}

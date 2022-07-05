<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Icon;
use Illuminate\Http\Request;
use Validator;

class IconUploadController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' => 'required|mimes:png,img,jpg,jpeg|max:2048',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if ($file = $request->file('file')) {
            $name = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->storeAs('public/icons', $name);

            $icon = new Icon();
            $icon->name = $name;
            $icon->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $icon->name
            ]);
        }
    }
}

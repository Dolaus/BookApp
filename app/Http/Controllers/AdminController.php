<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function makeMap()
    {
        $user = auth()->user();
        return view('admin.makemap', compact('user'));
    }

    public function settings()
    {
        return view('admin.settings.edit');
    }

    public function setupSettings(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        if (isset($data['fileToUpload'])) {
            $fileToUpload = time() . '1.' . $data['fileToUpload']->getClientOriginalExtension();
            $data['fileToUpload']->move(public_path('uploads'), $fileToUpload);
            $user['table_img_url'] = $fileToUpload;
        }
        if (isset($data['backgroundFile'])) {
            $NameBackgroundFile = time() . '2.' . $data['backgroundFile']->getClientOriginalExtension();
            $data['backgroundFile']->move(public_path('uploads'), $NameBackgroundFile);
            $user['back_img_url'] = $NameBackgroundFile;
        }
        $user['interval'] = $data['interval'];
        $user['site_name'] = $data['site_name'];
        $user['from_time'] = $data['from_time'];
        $user['to_time'] = $data['to_time'];
        $user->save();

        return redirect()->back();
    }
}

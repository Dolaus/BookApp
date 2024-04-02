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
        dd($request->all());
    }
}

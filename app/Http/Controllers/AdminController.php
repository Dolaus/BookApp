<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function makeMap($id)
    {
        $user = User::findOrFail($id);
        return view('admin.makemap', compact('user'));
    }
}

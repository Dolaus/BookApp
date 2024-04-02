<?php

namespace App\Http\Controllers;

use App\Models\CustomTabl;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function saveTable(Request $request) {
        $data = $request->all();
        CustomTabl::create([
           'x'=> $data['x'],
            'y' => $data['y'],
            'user_id' => $data['userId']
        ]);

        return response()->json('200');
    }

    public function deleteTable(Request $request) {
        $data = $request->all();
        $table = CustomTabl::where('x', $data['x'])->where('y', $data['y'])->where('user_id', $data['userId'])->first();
        $table->delete();
        return response()->json('deleted');
    }
}

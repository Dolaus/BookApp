<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        $users = User::where('role', 'customer')
            ->get();
        return view('superAdmin.users.index', compact('users'));
    }
    public function create()
    {
        return view('superAdmin.users.create');
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'confirmed'
        ])->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        return redirect()->route('user.index');
    }

    public function edit(User $user){
        return view('superAdmin.users.edit', compact('user'));
    }

    public function update(Request $request) {
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->user_id)],
            'password' => 'confirmed',
        ])->validated();

        $oldEmail = auth()->user()->email;
        if ($data['password'] == null) {
            auth()->user()->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        } else {
            auth()->user()->update([
                'name' => $data['name'],
                'password' => $data['password'],
                'email' => $data['email'],
            ]);
        }

        return redirect()->route('user.index');
    }

    public function delete(User $user) {
        $user->delete();
        return redirect()->route('user.index');
    }
}

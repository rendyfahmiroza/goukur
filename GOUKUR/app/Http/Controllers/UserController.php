<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ], 200);
    }
    
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    public function change_pass(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Hash::check($request->passwordLama, $user->password)) {
            $user->password = bcrypt($request->passwordBaru);
            $user->save();
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'password salah'], 500);
        }
        
    }
}

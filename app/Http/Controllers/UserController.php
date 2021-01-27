<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    // This is to get all users
    public function index(){
            return response()->json( User::all(),200);
    }

    // This is to return a user
    public function user(Request $request){
        return $request->user();
    }

    // This is to get specific User detail Using ID
    public function getUserById($id) {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        return response()->json($user::find($id), 200);
    }

    // This is to add user
    public function register(UserRegisterRequest $request){
        User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
        ]);
        return 'user is created successfully!';
    }

    // This is to update User
    public function updateUser(Request $request, $id) {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        $user->update($request->all());
        return response($user, 200);
    }

    // This is to delete USer
    public function deleteUser(Request $request, $id) {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        $user->delete();
        return response()->json(null, 204);
    }
}

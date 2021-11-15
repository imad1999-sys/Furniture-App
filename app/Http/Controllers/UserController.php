<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createAccount(Request  $request){
        $this->validate($request, [
            'first_name' => 'required',
        ]);
        $this->validate($request, [
            'last_name' => 'required',
        ]);
        $this->validate($request, [
            'email' => 'required',
        ]);
        $this->validate($request, [
            'password' => 'required',
        ]);
        $this->validate($request, [
            'phone' => 'required',
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->first_address = $request->input('first_address');
        $user->second_address = $request->input('second_address');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->pincode = $request->input('pincode');
        $user->save();
        return $user;
    }
    public function loginAccount(Request $request){
        $admin = User::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return ['result' => "error email or password" ];
        }

        $token = $admin->createToken('my-app-token')->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token,
            'id' => $admin->id
        ];

        return $response;
    }
}

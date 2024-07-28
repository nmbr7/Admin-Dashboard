<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use Illuminate\Support\Str;

/** 
 * Login Controller
 */
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $req = json_decode($request->getContent());

        // Check if user with provided username and password exists.
        $user = User::where([['username', '=', $req->username], ['password', '=', $req->password]])->firstOrFail();

        // Generate api token from random string.
        $api_token = Str::random(60);
        $user->update(['api_token' => $api_token]);


        $cookie = Cookie::create("session")
            ->withValue($api_token)
            ->withExpires(strtotime("+12 months"));

        return response()->json("Ok", 200)->cookie($cookie);
    }
}

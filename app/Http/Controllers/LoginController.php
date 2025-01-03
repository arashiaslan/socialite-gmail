<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function provider(){
        return Socialite::driver('google')->redirect();
    }
    
    public function callbackHandle(){
        $user = Socialite::driver('google')->user();
        
        $data = User::where('email', $user->email)->first();
        if (is_null($data)) {
            $users['name'] = $user->name;
            $users['email'] = $user->email;
            $users['password'] = bcrypt('12345678');
            $data = User::create($users);
        }

        Auth::login($data);
        return redirect('dashboard');
    }
}

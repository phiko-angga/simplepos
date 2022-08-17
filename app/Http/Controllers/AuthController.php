<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Response;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use Log;

class AuthController extends Controller
{

    protected $maxAttempts = 5;
    protected $decayMinutes = 2;

    public function index()
    {
        // Log::debug("index : ".json_encode(Auth::user()));
        if (Auth::check() == true) {
            return redirect('/');
        } else {
            return view('login');
        }
    }

    public function postLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }else{

            request()->validate([
                'name' => 'required',
                'password' => 'required'
            ]);

            $credentials    = $request->only('name', 'password');
            $remember = $request->remember ? true : false;
            if (Auth::attempt($credentials, $remember)) {
                //Login Success
                Session::put('level', auth()->user()->level_id);
                return Redirect::to('/');
    
            } else { // false
                //Login Fail
                return Redirect::to("/login")->withInput($request->all())->withErrors(['error' => 'Username atau Password salah']);
            }
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }

}

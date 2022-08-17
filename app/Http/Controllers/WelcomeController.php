<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Response;
use App\User;
use App\UserLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use Log;

class WelcomeController extends Controller
{

    public function index()
    {
        $titlebar = 'Welcome';
        $describebar = 'Dashboard';
        return view('welcome', compact('titlebar', 'describebar'));
    }

}

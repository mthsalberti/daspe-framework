<?php

namespace Daspeweb\Framework\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginAsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function loginAs($userId){
        if (Auth::user()->role->name_api != 'admin') abort(403);
        Auth::loginUsingId($userId);
        return redirect()->to('/admin');
    }
    public function logoutGet(){
        \Auth::logout();
        return redirect()->back();
    }
}

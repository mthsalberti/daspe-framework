<?php
namespace Daspeweb\Framework\Controller;

use App\DwModel;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateRefreshToken($id)
    {
        $token = Str::random(60);

        User::find($id)->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return redirect()->back();
    }

    public function activate($id){
        $user = User::find($id);
        $user->is_active = 1;
        $user->email = str_replace('.desativado', '', $user->email);
        $user->save();
        return redirect()->to('/admin/user_for_admins/'.$id);
    }

    public function deactivate($id){
        $userToLogout = User::find($id);
        $userCurrent = Auth::user();
        $userToLogout->is_active = 0;
        $userToLogout->email = $userToLogout->email . '.desativado';
        $userToLogout->save();

        Auth::setUser($userToLogout);
        Auth::logout();
        Auth::setUser($userCurrent);
        Auth::login($userCurrent);
        return redirect()->to('/admin/user_for_admins/'.$id);
    }
}

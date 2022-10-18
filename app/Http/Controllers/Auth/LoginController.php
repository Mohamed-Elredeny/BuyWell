<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\models\City;
use App\Models\LandingPage;
use App\Models\LandingSection;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function showLoginForm()
    {
        return view('site.login');
    }

    public function UserLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'admin');
            $status = auth()->user()->status;
            $this->id = auth()->user()->id;
            //return 1;
            // if successful, then redirect to their intended location
            return redirect()->route('admin.home');
        }
        if (Auth::guard('brand')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'brand');
            $status = auth()->user()->status;

            $this->id = auth()->user()->id;
            // if successful, then redirect to their intended location
            //return redirect()->route('vendor.profile-index',['type'=>'vendor','id'=>$this->id]);
            return redirect()->route('brand.home');

        }
        if (Auth::guard('delivery')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'delivery');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            //return redirect()->route('maintenance.profile-index',['type'=>'maintenance','id'=>$this->id]);
            // if successful, then redirect to their intended location
            //return redirect()->route('admin.home');
            return redirect()->route('delivery.home', ['filter' => 'today']);
        }


        return redirect()->route('auth.login')->withErrors(['msg' => 'Make Sure you entered correct credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('brand')->logout();
        Auth::guard('delivery')->logout();
        return redirect()->back();
    }
}

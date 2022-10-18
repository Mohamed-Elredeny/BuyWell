<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use App\Models\Brand;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class checkAuth
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        $type = $request->header('type');
        if ($type == 'user') {
            $exist = User::where('remember_token', $token)->get();
        } elseif ($type == 'brand') {
            $exist = Brand::where('remember_token', $token)->get();
        } else {
            $exist = [];
        }
        if (count($exist) > 0) {
           /* foreach ($exist as $ex) {
                if ($ex->status == 0) {
                    return $this->returnError(200, 'active your account');
                    //2 please active your account
                }
            }*/
            $this->user = $exist[0];
            return $next($request);
        } else {
            return $this->returnError(200, 'unauthenticated user');
        }
    }
}

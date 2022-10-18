<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use App\Models\Brand;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkBrand
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
        if(!$token){
            return $this->returnError(200, 'unauthenticated user');
        }
        $type = 'brand';
        if ($type == 'user') {
            $exist = User::where('remember_token', $token)->get();
        } elseif ($type == 'brand') {
            $exist = Brand::where('remember_token', $token)->get();
        } else {
            $exist = [];
        }
        if (count($exist) > 0) {
            $this->user = $exist[0];
            Auth::guard('brands-api')->login($this->user);
            return $next($request);
        } else {
            return $this->returnError(200, 'unauthenticated user');
        }
    }
}

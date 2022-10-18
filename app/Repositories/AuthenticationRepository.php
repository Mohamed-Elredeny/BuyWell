<?php

namespace App\Repositories;

use App\Interfaces\AuthenticationRepositoryInterface;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{
    public function login($recordDetails)
    {
        $email = $recordDetails['email'];
        $phone = $recordDetails['phone'] ?? '';
        $password = $recordDetails['password'];
        $type = $recordDetails['type'];

        if ($type == 'user') {
            $users_with_email = User::where('email', $email)->first();
            if ($users_with_email) {
                if (Hash::check($password, $users_with_email->password)) {
                    return $this->response(1, $users_with_email);
                } else {
                    return $this->response(0, []);
                }
            } else {
                $users_with_phone = User::where('phone', $phone)->first();
                if ($users_with_phone) {
                    if (Hash::check($password, $users_with_phone->password)) {
                        return $this->response(1, $users_with_phone);
                    } else {
                        return $this->response(0, []);
                    }
                } else {
                    return $this->response(0, []);
                }
            }
        } else {
            $users_with_email = Brand::where('email', $email)->first();
            if ($users_with_email) {
                if (Hash::check($password, $users_with_email->password)) {
                    return $this->response(1, $users_with_email);
                } else {
                    return $this->response(0, []);
                }
            } else {
                $users_with_phone = Brand::where('phone', $phone)->first();
                if ($users_with_phone) {
                    if (Hash::check($password, $users_with_phone->password)) {
                        return $this->response(1, $users_with_phone);
                    } else {
                        return $this->response(0, []);
                    }
                } else {
                    return $this->response(0, []);
                }
            }
        }

    }

    public function response($status, $data)
    {
        return [
            'status' => boolval($status),
            'data' => $data
        ];
    }

    public function loginSocial(array $recordDetails)
    {
        // TODO: Implement loginSocial() method.
    }

    public function register(array $recordDetails)
    {
        if ($recordDetails['type'] == 'user') {
            $user = User::create($recordDetails);
        } else {
            unset(
                $recordDetails['type']
            );
            $user = Brand::create($recordDetails);
        }
        if ($user) {
            return $this->response(1, $user);
        }
        return $this->response(0, []);
    }

    public function logout($token, $type)
    {
        if ($type == 'user') {
            $user = User::where('remember_token', $token)->first();
        } else {
            $user = Brand::where('remember_token', $token)->first();
        }
        if ($user) {
            Auth::logout();
            $user->update(['remember_token'=>'']);
            return $this->response(1, $user);
        } else {
            return $this->response(0, []);
        }
    }

    public function viewProfile($token,$type)
    {
        if($type == 'user') {
            $user =  User::where('remember_token', $token)->first();
        }else{
            $user =  Brand::where('remember_token', $token)->first();
        }
        if($user){
            return $user;
        }else{
            return null;
        }
    }

    public function updateProfile($token, array $recordDetails)
    {
        // TODO: Implement updateProfile() method.
    }

    public function updateToken(Request $request, $user)
    {
        $credentials = $request->only('email', 'password');
        if ($request->type == 'brand') {
            $token = Auth::guard('brands-api')->attempt($credentials);
        } else {
            $token = Auth::guard('api')->attempt($credentials);
        }
        $user->update([
            'remember_token' => $token
        ]);
    }

}

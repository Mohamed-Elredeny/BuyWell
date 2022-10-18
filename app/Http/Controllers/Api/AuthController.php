<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Interfaces\AuthenticationRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\GeneralTrait;

class AuthController extends Controller
{
    use GeneralTrait;

    public $userAuthentication;

    public function __construct(AuthenticationRepositoryInterface $userAuthentication)
    {
        $this->userAuthentication = $userAuthentication;
    }

    public function login(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|max:20',
        ]);
        if ($type == 'brand') {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|exists:brands,email',
                'phone' => 'nullable|exists:brands,phone'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|exists:users,email',
                'phone' => 'nullable|exists:users,phone'
            ]);
        }
        if ($validator->fails()) {
            return $this->returnValidationError(500, $validator);
        } else {
            $recordDetails = [
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'type' => $type
            ];
            if ($request->phone) {
                $recordDetails['phone'] = $request->phone;
            }
            $user_login = $this->userAuthentication->login($recordDetails);
            if ($user_login['status']) {
                $token = $this->updateToken($request, $user_login['data']);
                return $this->returnData(
                    ['token', 'status', 'type']
                    , [$token, 200, $type]
                    , 'User login successfully');
            } else {
                return $this->returnError(500, 'Unable to login');
            }
        }
    }

    public function updateToken(Request $request, $user)
    {
        $credentials = $request->only('email', 'password');
        if ($request->type == 'brand') {
            $token = Auth::guard('brands-api')->attempt($credentials);
            if (!$token) {
                $credentials = $request->only('phone', 'password');
                $token = Auth::guard('brands-api')->attempt($credentials);
            }
        } else {
            $token = Auth::guard('api')->attempt($credentials);
            if (!$token) {
                $credentials = $request->only('phone', 'password');
                $token = Auth::guard('api')->attempt($credentials);
            }
        }
        $user->update([
            'remember_token' => $token
        ]);
        return $token;
    }

    public function register(Request $request, $type)
    {
        if ($type == 'user') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:5|max:255',
                'phone' => 'nullable|string|min:9|unique:users',
                'email' => 'required|string|email|min:5|max:255|unique:users',
                //'area_id' => 'required|exists:areas,id',
                'password' => 'required|string|min:6|max:20',
                'image' => 'nullable',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:5|max:255',
                'phone' => 'nullable|string|min:9|unique:brands',
                'email' => 'required|string|email|min:5|max:255|unique:brands',
                // 'area_id' => 'required|exists:areas,id',
                'password' => 'required|string|min:6|max:20',
                'image' => 'nullable',
            ]);
        }
        if ($validator->fails()) {
            return $this->returnValidationError(500, $validator);
        } else {
            if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'users');
            } else {
                $image = null;
            }
            $directions = [];
            if ($request->directions) {
                $directions['street_name'] = $request->directions['street_name'];
                $directions['building_name'] = $request->directions['building_name'];
                $directions['floor_number'] = $request->directions['floor_number'];
                $directions['flat_number'] = $request->directions['flat_number'];

            } else {
                $directions['street_name'] = $request->directions['street_name'] ?? '';
                $directions['building_name'] = $request->directions['building_name'] ?? '';
                $directions['floor_number'] = $request->directions['floor_number'] ?? '';
                $directions['flat_number'] = $request->directions['flat_number'] ?? '';
            }
            $recordDetails = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => hash::make($request->password),
                'image' => $image,
            ];
            if ($type == 'user') {
                $recordDetails['status'] = 1;
                $recordDetails['type'] = 'user';
            } else {
                $recordDetails['type'] = 'brand';
            }
            $response = $this->userAuthentication->register($recordDetails);
            $user = $response['data'];
            $this->updateToken($request, $user);
            return $this->returnData(['userDetails'], [$user]);
        }

    }

    public function profile(Request $request, $type, $profile)
    {
        $token = $request->header('token');
        $auth_user = $this->userAuthentication->viewProfile($token, $type);
        if (!$auth_user) {
            return $this->returnError(200, 'Invalid Token');
        }
        $wanted_user = User::find($profile);
        if ($wanted_user) {
            if ($profile == $auth_user->id) {
                $auth_user->myProfile = 1;
                return $this->returnData(['userDetails'], [$auth_user], 'userDetails');
            } else {
                $wanted_user->myProfile = 0;
                return $this->returnData(['userDetails'], [new UsersResource($auth_user)]);
            }
        } else {
            return $this->returnError(500, 'There is no user with this id');
        }
    }

    public function logout(Request $request)
    {
        if (!$request->header('token')) {
            return $this->returnError(500, 'You Din not enter your token !');
        }
        if (!$request->header('type')) {
            return $this->returnError(500, 'You Din not enter your token !');
        } else {
            if ($request->header('type') != 'user' && $request->header('type') != 'brand') {
                return $this->returnError(500, 'invalid type you type must be user or brand');
            }
        }
        if ($this->userAuthentication->logout($request->header('token'), $request->header('type'))['status']) {
            return $this->returnSuccessMessage('user logged out successfully !');
        } else {
            return $this->returnError(500, 'user did not log out !');

        }
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('remember_token', $request->header('token'))->first();
        if ($user) {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|min:9|unique:users,phone,' . $user->id,
                'name' => 'required|string|min:5|max:255',
                'image' => 'nullable',
            ]);
            if ($validator->fails()) {
                return $this->returnValidationError(500, $validator);
            } else {
                $array = [];
                if ($request->name) {
                    $array['name'] = $request->name;
                }
                if ($request->email) {
                    $array['email'] = $request->email;
                }
                if ($request->phone) {
                    $array['phone'] = $request->phone;
                }

                if ($request->image) {
                    $image = $this->uploadImage($request, 'image', 'users');
                } else {
                    $image = $user->image;
                }
                $array['image'] = $image;
                $user->update($array);
                return $this->returnData(['userDetails'], [new UsersResource($user)]);
            }
        } else {
            return $this->returnError(500, 'There is no user with this id');
        }
    }
}

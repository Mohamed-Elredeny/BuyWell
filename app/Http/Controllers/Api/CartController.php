<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\CartProducts;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Str;

class CartController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('UserCart');
        $this->records = 'carts';
        $this->record = 'cart';
        $this->middleware(function ($request, $next) {
            if ($request->MMDevice) {
                $this->device = 'mobile';
            } else {
                $this->device = 'web';
            }
            return $next($request);
        });

    }

    public function coupon(Request $request, $action)
    {
        //$bytes = random_bytes(30);
        //$code = bin2hex($bytes);
        $code = '950c0ac0df7bbded7f9cdbca3c520613f7a79a961d0f52d2df9c551dbed1';
        $request_code = $request->header('secret_key');

        switch ($action) {
            case 'generate':
                if ($request_code == $code) {
                    return Coupon::create([
                        'expire_date' => date('Y-m-d', strtotime('+10 days')),
                        'amount' => $request->amount ?? 10,
                        'coupon' => bin2hex(random_bytes(6)),
                        'is_valid' => 1
                    ]);
                } else {
                    return $this->returnError(201, 'you are not allowed to use this endpoint');
                }
            case 'valid':
                $coupon = Coupon::where('coupon', $request->coupon)->first();
                if ($coupon) {
                    if ($coupon->expire_date > Carbon::today() && $coupon->is_valid == 1) {
                        $token = $request->header('token');
                        $user = User::where('remember_token', $token)->first();

                        $user_cart = UserCart::where('user_id', $user->id)->first();
                        if (!$user_cart) {
                            $user_cart = UserCart::create([
                                'coupon' => $coupon->coupon,
                                'discount' => $coupon->amount,
                                'user_id' => $user->id
                            ]);
                        } else {
                            $user_cart->update([
                                'coupon' => $coupon->coupon,
                                'discount' => $coupon->amount
                            ]);
                        }
                        $coupon->update([
                            'is_valid' => 0
                        ]);
                        return $this->returnSuccessMessage('Discount implemented successfully', 200);
                    } else {
                        return $this->returnError(201, 'invalid coupon');
                    }
                }
                return;
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $keys = [])
    {
        $token = $request->header('token');
        $user = User::where('remember_token', $token)->first();
        $keys['user_id'] = $user->id;
        $records = $this->base->index($keys);
        if (count($records) > 0) {
            $records = $records[0];
            return $this->returnData([$this->records], [new CartResource($records), '']);
        } else {
            $records = [];
            return $this->returnData([$this->records], [[]], '');
        }


    }

    public function show($id)
    {
        return $this->returnData([$this->records], [$this->base->show($id)]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products.*.id' => 'required|exists:products',
            'products.*.amount' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            $token = $request->header('token');
            $user = User::where('remember_token', $token)->first();
            $user_cart = UserCart::where('user_id', $user->id)->first();
            if (!$user_cart) {
                $user_cart = UserCart::create([
                    'user_id' => $user->id
                ]);
            }

            if ($request->products) {
                foreach ($request->products as $pro) {
                    $exist_before = CartProducts::where('cart_id', $user_cart->id)->where('product_id', $pro['id'])->first();
                    if ($exist_before) {
                        $new_amount =  $pro['amount'];
                        $exist_before->update([
                            'amount' => $new_amount
                        ]);
                    } else {
                        CartProducts::create([
                            'cart_id' => $user_cart->id,
                            'product_id' => $pro['id'],
                            'amount' => $pro['amount']

                        ]);
                    }
                }
            }

            return $this->returnData([$this->record], [new CartResource($user_cart), '']);
        }

    }

    public function update(Request $request, $id)
    {
        $token = $request->header('token');
        $user = User::where('remember_token', $token)->first();
        $record = \App\Models\UserAddress::find($id);
        if ($record) {
            if ($record->user_id != $user->id) {
                return $this->returnError(201, $this->record . 'Is Not Belong to you , so you can not edit it');
            }
            $data = [];
            if (isset($request->is_default)) {
                $data['is_default'] = $request->is_default;
            } else {
                $data['is_default'] = $record->is_default;
            }
            $this->base->update($data, $id);
            $record = \App\Models\UserAddress::find($id);

            return $this->returnData([$this->record], [$record]);
        } else {
            return $this->returnError(201, $this->record . ' Not Found With This ID ');
        }

    }


    public function destroy(Request $request, $id)
    {
        $token = $request->header('token');
        $user = User::where('remember_token', $token)->first();
        $user_cart = UserCart::where('user_id', $user->id)->first();
        $user_cart_products = $user_cart->products;

        $record = CartProducts::where('cart_id', $user_cart->id)->where('product_id', $id)->get();
        if (count($record) > 0) {
            foreach ($record as $r) {
                $r->delete();
            }
            return $this->returnSuccessMessage('items Deleted Successfully', 200);
        }
        return $this->returnError(201, 'items Not Found With This ID ');
    }

    public function getDevice(Request $request)
    {

    }
}

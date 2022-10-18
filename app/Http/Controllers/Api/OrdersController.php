<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductsResource;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderProducts;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('Order');
        $this->records = 'orders';
        $this->record = 'order';
        $this->middleware(function ($request, $next) {
            if ($request->MMDevice) {
                $this->device = 'mobile';
            } else {
                $this->device = 'web';
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $keys = [])
    {
        if (isset($this->device) && $this->device == 'mobile') {
            $token = $request->header('token');
            $user = User::where('remember_token', $token)->first();
            $key['user_id'] = $user->id;
        }
        $records = $this->base->index($keys);
        foreach ($records as $record) {
            if($request->header('lang') == 'ar') {
                $status = $this->trans_status($record->status);
            }else{
                $status = $record->status;
            }
            $record->status =$status;
        }
        return $this->returnData([$this->records], [$records]);
    }

    public function trans_status($status)
    {
        switch ($status) {
            case 'pending':
                return 'قيد الانتظار';
            case 'accepted':
                return 'مقبول';
            case 'refused':
                return 'مرفوض';
            case 'delivered':
                return 'تم التسليم';
            case 'notDelivered':
                return 'لم يتم التسليم';
        }
    }

    public function show($id)
    {
        return $this->returnData([$this->records], [new OrderResource($this->base->show($id))]);
    }

    public function track(Request $request, $order_id)
    {
        $token = $request->header('token');
        $user = User::where('remember_token', $token)->first();
        $order = Order::find($order_id);
        $history = $order->history;
        $current_step = 0;
        foreach ($history as $record) {
            if ($record->status == $order->status) {
                $current_step = $this->trans_status_steps($record->status);
            }
        }


        foreach ($history as $record) {

            if ($record->status == $order->status) {
                $record->is_active = 1;
            } else {
                $record->is_active = 0;
            }
            $record->step_number = $this->trans_status_steps($record->status);
            if($request->header('lang') == 'ar') {
                $status = $this->trans_status($record->status);
            }else{
                $status = $record->status;
            }
            $record->status = $status;
            $record->date = date('h:i a , d M Y', strtotime($record->created_at));
            unset(
                $record->created_at
            );
        }
        return $this->returnDataCustome(['log'], [$history], '', $current_step);

    }

    public function trans_status_steps($status)
    {
        switch ($status) {
            case 'pending':
                return 1;
            case 'accepted':
                return 2;
            case 'refused':
                return 3;
            case 'delivered':
                return 4;
            case 'notDelivered':
                return 5;
        }
    }

    public function returnDataCustome($keys, $values, $msg = '', $current_step = 0)
    {
        $data = [];
        for ($i = 0; $i < count($keys); $i++) {
            $data[$keys[$i]] = $values[$i];
        }
        $data['current_step'] = $current_step;

        return response()->json([
            'status' => true,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            $token = $request->header('token');
            $user = User::where('remember_token', $token)->first();
            $user_cart = UserCart::where('user_id', $user->id)->first();
            if ($user_cart) {
                $products = $user_cart->products;
                if (count($products) > 0) {
                    $address = \App\Models\UserAddress::where('user_id', $user->id)->where('is_default', 1)->first();
                    $order = Order::create([
                        'user_id' => $user->id,
                        'status' => 'pending',
                        'is_paid' => 0,
                        'discount' => $user_cart->discount,
                        'total' => $user_cart->total,
                        'total_after_discount' => $user_cart->total_after_discount,
                        'address_id' => $address->id ?? null
                    ]);
                    foreach ($products as $pro) {
                        OrderProducts::create([
                            'order_id' => $order->id,
                            'product_id' => $pro->id,
                            'amount' => $pro->amount
                        ]);
                        $pro->delete();
                    }
                    $user_cart->update([
                        'coupon' => null,
                        'discount' => null,
                        'total' => null,
                        'total_after_discount' => null
                    ]);


                    OrderHistory::create([
                        'order_id' => $order->id,
                        'status' => 'pending'
                    ]);
                    return $this->returnData([$this->record], [new OrderResource($order)]);

                } else {
                    return $this->returnError(422, 'your cart must have atleast one product to make an order !');
                }
            } else {
                return $this->returnError(422, 'no products in your cart');

            }

            $data = [
                'name' => $request['name'],
                'image' => asset('assets/images/categories/' . $image),
            ];

            return $this->returnData([$this->record], [$this->base->store($data), '']);
        }

    }

    public function update(Request $request, $id)
    {

        $record = Order::find($id);
        if ($record) {

            $data = [];
            /*if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'categories');
            } else {
                $image = $re;
            }*/
            /* $data = [
                 'image' => asset('assets/images/categories/' . $image),
             ];*/

            if ($request->status) {
                $data['status'] = $request->status;
            } else {
                $data['status'] = $record->status;
            }
            OrderHistory::create([
                'order_id' => $record->id,
                'status' => $request->status
            ]);
            if ($request->status == 'تم التسليم') {
                Transaction::create([
                    'order_id' => $record->id,
                    'user_id' => $record->user->id,
                    'payment_method' => 'كاش'
                ]);
            }


            $this->base->update($data, $id);
            $record = Order::find($id);

            return $this->returnData([$this->record], [$record]);
        } else {
            return $this->returnError(201, $this->record . ' Not Found With This ID ');
        }

    }


    public function destroy($id)
    {
        $order = Order::find($id);
        if($order) {
            $order_products = $order->products;
            foreach ($order_products as $record) {
                $record->delete();
            }
            $order_history = $order->history;
            foreach ($order_history as $record) {
                $record->delete();
            }
            $order_transactions = $order->transactions;
            foreach ($order_transactions as $record) {
                $record->delete();
            }
            $this->base->destroy($id);
            return 1;
        }else{
            return $this->returnError(201, $this->record . ' Not Found With This ID ');

        }


    }

    public function getDevice(Request $request)
    {

    }
}

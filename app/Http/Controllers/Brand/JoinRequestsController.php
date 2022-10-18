<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\Brand;
use App\Models\Collage;
use App\Models\CollageProducts;
use App\Models\JoinRequest;
use App\Models\UserCollage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JoinRequestsController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('JoinRequest');
        $this->records = 'join_requests';
        $this->record = 'join_request';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $keys = [
            'status' => intval($status)
        ];
        $records = $this->base->index($keys);
        return view('admin.sections.users.userRequests.index', compact('records', 'status'));
        //return $this->returnData([$this->records], [$collages]);
    }

    public function show($id)
    {
        $collage = $this->base->show($id);
        if ($collage) {
            $collage->products = $collage->products;
        }
        return $this->returnData([$this->records], [$collage]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:join_requests',
            'phone' => 'required|unique:join_requests',
            'message' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->getMessageBag());
            //  return $this->returnValidationError(422, $validator);
        } else {
            if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'collages');
            } else {
                $image = '';
            }
            if (Brand::where('email', $request->email)->orWhere('phone', $request->phone)->count() > 0) {
                return redirect()->back()->with('errors', 'Try Another Email or Phone !');
            }
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'message' => $request['message'],
                'status' => 0
            ];
            $record = $this->base->store($data);
            return redirect()->back()->with('success', 'We Have Received Your Request and will contact you soon !');
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->getMessageBag());
        } else {
            $record = JoinRequest::find($id);
            if ($record) {
                $data = [];
                if ($request->name) {
                    $data['name'] = $request->name;
                } else {
                    $data['name'] = $record->name;
                }

                if ($request->email) {
                    $data['email'] = $request->email;
                } else {
                    $data['email'] = $record->email;
                }

                if ($request->phone) {
                    $data['phone'] = $request->phone;
                } else {
                    $data['phone'] = $record->phone;
                }

                if ($request->message) {
                    $data['message'] = $request->message;
                } else {
                    $data['message'] = $record->message;
                }

                if ($request->status) {
                    $data['status'] = 1;
                } else {
                    $data['status'] = 1;
                }
                if ($data['status'] == 1) {
                    Brand::create([
                        'name' => $record->name,
                        'email' => $record->email,
                        'phone' => $record->phone,
                        'password' => Hash::make(12345678)
                    ]);
                }

                $this->base->update($data, $id);
                $record = JoinRequest::find($id);
                return redirect()->back()->with('success', 'updated Successfully');
//                return $this->returnData([$this->record], [$record]);
            } else {
                return $this->returnError(201, $this->record . ' Not Found With This ID ');
            }
        }

    }

    public function destroy($id)
    {
        if (JoinRequest::find($id)) {

            if ($this->base->destroy($id)) {
                return $this->returnSuccessMessage($this->record . 'Deleted Successfully', 200);
            }
        }
        return $this->returnError(201, $this->record . ' Not Found With This ID ');
    }
}

@extends("layouts.admin")
@section("pageTitle", "Cities")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive ">


                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <form class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Type</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="example-text-input" name="type"
                                                        onchange="submit()">
                                                    @if(isset($keys['brand_id']) && $keys['brand_id'] != 'system')
                                                        <option
                                                            value="{{$keys['brand_id']}}">{{\App\Models\Brand::find($keys['brand_id'])->name}}</option>
                                                        <option value="system">System</option>

                                                        @foreach($brands as $brand)
                                                            @if($keys['brand_id'] != $brand->id)
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="system">System</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-striped table-bordered pt-3">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Model Type</th>
                                                    <th>Is Brand</th>
                                                    <th>Price</th>
                                                    <th>Discount</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($records as $record)
                                                    <tr>
                                                        <td>{{$record->id}}</td>
                                                        <td>{{$record['name_' . App::getlocale()]}}</td>
                                                        <td>{{$record->model_type}}</td>
                                                    @if($record->is_brand)
                                                            <td>{{$record->brand->name ?? 'Unknown'}}</td>
                                                        @else
                                                            <td>{{'System'}}</td>
                                                        @endif
                                                        <td>
                                                            {{$record->price . ' LE'}}
                                                        </td>
                                                        <td>
                                                            {{$record->discount_price . ' %' }}
                                                       </td>

                                                       <td>
                                                           <a href="{{route('products.edit',['product'=>$record->id])}}"
                                                               class="mr-3 text-muted" data-bs-toggle="tooltip"
                                                               data-bs-placement="top" title=""
                                                               data-bs-original-title="Edit">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </a>
                                                            <a href="{{route('products.show',['product'=>$record->id])}}"
                                                               class="mr-3 text-muted" data-bs-toggle="tooltip"
                                                               data-bs-placement="top" title=""
                                                               data-bs-original-title="Show">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </a>

                                                            <form
                                                                action="{{route('products.destroy',['product'=>$record->id])}}"
                                                                method="post" style="display:inline-block">
                                                                @method('DELETE')
                                                                @csrf
                                                                <span type="submit" class="mr-3 text-muted"
                                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                                      title="" data-bs-original-title="Delete"
                                                                      onclick="$(this).closest('form').submit();"> <i
                                                                        class="mdi mdi-close font-size-18"></i> </span>

                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div> <!-- container-fluid -->

                    {{--
                                        {{ $data->links() }}
                    --}}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

@endsection

{{--    <script>
        function modelDes(x, y) {
            document.getElementById('modelImagee').innerHTML = `
            <div class="modal " id="image` + x + `" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">  {{__('admin/category.Image')}}  </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="group-img-container text-center post-modal">
                                <img  src="{{asset('assets/images/users/`+ y +`')}}" alt="" class="group-img img-fluid" style="width:400px; hieght:400px" ><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        }

        function modelAddProduct(x) {
            document.getElementById('modelAdd').innerHTML = `
            <div class="modal " id="form` + x + `" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('admin/category.Image')}} </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('usersTypes.store')}}" >
                            @csrf
            <input type="hidden" name="category_id" value="` + x + `">
                            <input type="hidden" name="state" value="available">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">{{__('admin/category.Code')}}:</label>
                                    <textarea class="form-control" name="code" id="message-text"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('admin/category.Save')}}</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin/category.Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        }
    </script>--}}

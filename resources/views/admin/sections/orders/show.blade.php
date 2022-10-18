@extends("layouts.admin")
@section("pageTitle", "Add City")
@section("content")
    <style>
        .form-control {
            margin-bottom: 5px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{route('products.update',['product'=>$record->id])}}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-12 col-form-label text-center">Edit
                                Product Details</label>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                @if($record->model_type == 'category')
                                    <div class="form-control">
                                   {{$record->category['name_ar']}}
                                    </div>
                                @elseif($record->model_type == 'subcategory')
                                    <div class="form-control">
                                        {{$record->subCategory->category['name_ar']}}
                                    </div>
                                @else
                                    <div class="form-control">
                                       Unknown
                                    </div>
                                @endif
                           {{--     <select class="form-control" id="category_id" name="category_id"
                                        required>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category->id}}">{{$category['name_' . App::getlocale()]}}</option>
                                    @endforeach
                                </select>--}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Sub Category</label>
                            <div class="col-sm-10">
                                @if($record->model_type == 'subcategory')
                                    <div class="form-control">
                                         {{$record->subCategory['name_ar']}}
                                    </div>
                                @else
                                    <div class="form-control">
                                        Unknown
                                    </div>
                                @endif
                         {{--       <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    @if($record->model_type == 'subcategory')
                                        <option
                                            value="{{$record->subCategory['id']}}">{{$record->subCategory['name_' . App::getlocale()]}}</option>
                                    @endif
                                </select>--}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="name" required readonly
                                       value="{{ $record['name_' . App::getlocale()] }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-1 col-form-label">Price</label>
                            <div class="col-sm-5">
                                <input class="form-control" min="0" type="number" id="example-text-input" name="price"
                                       required readonly value="{{ $record['price'] }}">
                            </div>
                            <label for="example-text-input" class="col-sm-1 col-form-label">Discount</label>
                            <div class="col-sm-5">
                                <input class="form-control" min="0" type="number" id="example-text-input"
                                       name="discount"
                                        readonly
                                       required value="{{ $record['discount_price'] }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-12 col-form-label">Dimensions</label>
                            <div class="row form-group">
                                <label for="example-text-input" class="col-sm-1 col-form-label">Height</label>

                                <div class="col-sm-3">
                                    <input class="form-control" name="dimensions[height]" id="example-text-input"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->dimensions->height ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-1 col-form-label">Weight</label>
                                <div class="col-sm-3">
                                    <input class="form-control" name="dimensions[weight]" id="example-text-input"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->dimensions->weight ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-1 col-form-label">Length</label>
                                <div class="col-sm-3">
                                    <input class="form-control" name="dimensions[length]" id="example-text-input"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->dimensions->length ?? null}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-12 col-form-label">Shipping To Egypt</label>
                            <div class="row form-group">

                                <label for="example-text-input" class="col-sm-1 col-form-label">Price</label>
                                <div class="col-sm-11">
                                    <input class="form-control" min="0" type="number" id="example-text-input"
                                           name="shipping[price]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->shipping->price ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-12 col-form-label">Duration with
                                    [Days]</label>
                                <div class="row form-group">
                                    <label for="example-text-input" class="col-sm-1 col-form-label">From</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" min="0" type="number" id="example-text-input"
                                               name="shipping[days_from]"
                                               required readonly
                                               value="{{json_decode($record['specifications_ar'])->shipping->days_from ?? null}}">
                                    </div>
                                    <label for="example-text-input" class="col-sm-1 col-form-label">To</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" min="0" type="number" id="example-text-input"
                                               name="shipping[days_to]"
                                               required readonly
                                               value="{{json_decode($record['specifications_ar'])->shipping->days_to ?? null}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-12 col-form-label">Specifications</label>
                            <div class="row form-group">

                                <label for="example-text-input" class="col-sm-2 col-form-label">Material</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="example-text-input"
                                           name="specifications[material]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->material ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Color</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="example-text-input"
                                           name="specifications[color]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->color ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Length</label>
                                <div class="col-sm-4">
                                    <input class="form-control" min="0" type="number" id="example-text-input"
                                           name="specifications[length]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->length ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Fit</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="example-text-input"
                                           name="specifications[fit]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->fit ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Occasion</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="example-text-input"
                                           name="specifications[occasion]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->occasion ?? null}}">
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Care
                                    Instructions</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="example-text-input"
                                           name="specifications[care]"
                                           required readonly
                                           value="{{json_decode($record['specifications_ar'])->specifications->care ?? null}}">
                                </div>


                            </div>
                        </div>

                        <div class="form-group row">
                            @if($record->images)
                                <?php $images = explode('|', $record->images);
                                $counter = 0;
                                ?>
                                @foreach($images as $image)
                                    <div class="col-sm-4 text-center">
                                        <img class="d-block" src="{{asset('assets/images/products/' . $image)}}"
                                             style="height:300px">
                                        <br>
                                    </div>
                                    <?php $counter++; ?>
                                @endforeach
                            @endif
                        </div>


                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous">
    </script>

    <script>


        $(document).ready(function () {
            $('#category_id').on('change', function () {
                var id = $(this).val();
                //alert(id);

                $.ajax({
                    url: '{{route('api.indexAjax')}}',
                    method: "get",
                    data: {keys: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var cities = document.getElementById('sub_category_id');
                        console.log(data.data.subCategories);
                        cities.innerHTML = "";
                        cities.innerHTML = "<option value='0'>No Sub Categories</option>"
                        data.data.subCategories.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['name_en'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
        });

    </script>
@endsection

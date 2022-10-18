@extends("layouts.admin")
@section("pageTitle", "Add Collage")
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


                    <form method="post" action="{{route('collages.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-12 col-form-label text-center">Add New
                                Collage</label>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Collage Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="name" required
                                       value="{{ old('name')}}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Images</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="example-text-input" name="image"
                                       multiple required>
                            </div>
                        </div>

                        <section class="shop-page">
                            <div class="shop-container">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-xl-3">
                                                <div class="btn-mobile-filter d-xl-none"><i
                                                        class='bx bx-slider-alt'></i>
                                                </div>
                                                <div class="filter-sidebar d-none d-xl-flex">
                                                    <div class="card w-100">
                                                        <div class="card-body">
                                                            <div class="align-items-center d-flex d-xl-none">
                                                                <h6 class="text-uppercase mb-0">Filter</h6>
                                                                <div
                                                                    class="btn-mobile-filter-close btn-close ms-auto cursor-pointer"></div>
                                                            </div>

                                                            <div class="product-brands">
                                                                <h6 class="text-uppercase mb-3">Brands</h6>
                                                                <ul class="list-unstyled mb-0 categories-list">
                                                                    <a href="{{route('collages.create',['brand'=>0])}}"
                                                                       class="form-control">
                                                                        <label class="form-check-label"
                                                                               for="Diesel">{{'System'}}</label>
                                                                    </a>
                                                                    @foreach($brands as $brand)
                                                                        <a href="{{route('collages.create',['brand'=>$brand->id])}}"
                                                                           class="form-control">

                                                                            <label class="form-check-label"
                                                                                   for="Diesel">{{$brand->name}} </label>
                                                                        </a>
                                                                    @endforeach
                                                                </ul>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-9">
                                                <div class="product-wrapper">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control ps-5"
                                                                       placeholder="Search Product..." id="Search">
                                                                <span
                                                                    class="position-absolute top-50 product-show translate-middle-y"><ion-icon
                                                                        name="search-sharp"
                                                                        class="ms-3 fs-6"></ion-icon></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-grid">
                                                        <div
                                                            class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
                                                            @foreach($products as $product)
                                                                <div class="col target">
                                                                    <div class="card product-card text-center">
                                                                        <div
                                                                            class="card-header bg-transparent border-bottom-0">
                                                                            <div
                                                                                class="d-flex align-items-center justify-content-end">
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        $img = explode('|', $product->images);
                                                                        ?>
                                                                        <img
                                                                            src="{{asset('assets/images/products/' . $img[0] ?? '')}}"
                                                                            class="card-img-top" alt="...">
                                                                        <div class="card-body text-center">
                                                                            <div class="product-info ">
                                                                                <a href="javascript:;">
                                                                                    <p class="product-catergory font-13 mb-1">
                                                                                        {{$product->category['name_' . App::getlocale()]}}</p>
                                                                                </a>
                                                                                <a href="ecommerce-product-details.html">
                                                                                    <h6 class="product-name mb-2">
                                                                                        {{$product['name_' . App::getlocale()]}}
                                                                                    </h6>
                                                                                </a>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mb-1 product-price">
                                                                                        <span class="fs-5"> {{$product->price}} EP</span>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                            <input type="checkbox"
                                                                                   class="checkbox btn btn-primary"
                                                                                   value="{{$product->id}}"
                                                                                   name="products[][id]">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end row-->
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--end shop area-->


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
        $("#Search").on("keyup", function () {
            val = $(this).val().toLowerCase();
            $(".target").each(function () {
                $(this).toggle($(this).text().toLowerCase().includes(val));
            });
        });

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
        $(document).ready(function () {
            $('#filter_products').on('click', function () {
                var id = $(this).val();
                var ids = document.querySelector('.brands_id').checked;
                console.log(ids);
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

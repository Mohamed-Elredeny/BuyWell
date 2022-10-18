@extends("layouts.admin")
@section("pageTitle", 'EDIT' . strtoupper($collection) )
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{route($collections . '.update',[$collection=>$record->id])}}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name Arabic</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="name_ar"
                                       value="{{$record->name_ar}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name English</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="name_en"
                                       value="{{$record->name_en}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_id" id="">
                                    @if($record->category_id)
                                        <option
                                            value="{{$record->category_id}}">{{\App\Models\Category::find($record->category_id)['name_' . App::getlocale()]}}</option>
                                        @foreach($categories as $category)
                                            @if($category->id != $record->category_id)
                                                <option
                                                    value="{{$category->id}}">{{$category['name_' . App::getlocale()]}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->id}}">{{$category['name_' . App::getlocale()]}}</option>

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="example-text-input" name="image">
                            </div>
                            <div class="col-sm-12 text-center">
                                <br>
                                @if($record->image)
                                    <img src="{{ $record->image}}" alt="" style="width:250px;height:250px">
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">{{__('Save Changes')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section("script")
    <script src="{{asset("assets/admin/js/app.js")}}"></script>

@endsection

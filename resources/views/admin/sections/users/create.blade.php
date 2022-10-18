@extends("layouts.admin")
@section("pageTitle", "Add City")
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="example-text-input" name="type" required>
                                    <option value="">Vendor</option>
                                    <option value="">Sub Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="password"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Privileges</label>
                            <div class="col-sm-10">
                                <div class="form-control">
                                    <input type="checkbox">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Users
                                        Section</label>
                                    <div class="form-group">
                                        <input type="checkbox">
                                        <label for="" class="col-sm-2 col-form-label">User Requests</label>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">Contacted</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">Pending</label>
                                        </div>
                                        <input type="checkbox">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">CRUD</label>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">View All</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">Update</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">Delete</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox">
                                            <label for="">Edit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="example-text-input" name="image">
                            </div>
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


@endsection

@extends("layouts.site")
@section("content")

    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mt-5">
                <div class="card radius-10">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h4>Sign In</h4>
                            <p>Sign In to your account</p>
                        </div>
                        <form class="form-body row g-3" method="POST" action="{{ route('auth.login.post')}}">
                            @csrf
                            <div class="col-12">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="abc@example.com">
                            </div>
                            <div class="col-12">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="inputPassword"
                                       placeholder="Your password">
                            </div>
                            <div class="col-12 col-lg-6">

                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                <a href="authentication-reset-password-basic.html">Forgot Password?</a>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 text-center">
                                <p class="mb-0">Don't have an account? <a href="" data-bs-toggle="modal"
                                                                          data-bs-target="#feedbackModal">Start Your
                                        Brand</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script src="{{asset("assets/admin/js/app.js")}}"></script>

@endsection

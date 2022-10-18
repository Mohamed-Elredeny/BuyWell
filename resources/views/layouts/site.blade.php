<!doctype html>
<html lang="en" dir="rtl" class="light">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- loader-->
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <?php $lang = 'rtl'?>
        <style>
            * {
                direction: rtl;
                text-align: right;
            }
        </style>
    @else
        <?php $lang = 'ltr'?>
        <style>
            * {
                direction: ltr;
                text-align: left;
            }

            a {
                text-decoration: none !important;
            }
        </style>
    @endif


    <link rel="icon" type="image/x-icon" href="{{asset('assets/web/favicon.ico')}}"/>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap"
          rel="stylesheet"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap"
          rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('assets/web/css/styles.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/css/header-colors.css')}}" rel="stylesheet"/>

    <style>
        .form-group {
            margin: 10px;
        }
    </style>
    <title>COD AFRICA NETWORK | شريك النجاح في التجاة الإلكترونية داخل إفريقيا</title>

</head>

<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm " id="mainNav">
    <div class="container px-5">
        <a class="navbar-brand fw-bold" href="{{route('index')}}">Multi Vendor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('index')}}#features">Features</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('index')}}#download">Download</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('login-site')}}">Login</a></li>

            </ul>
            <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal"
                    data-bs-target="#feedbackModal">
                        <span class="d-flex align-items-center">
                            <i class="bi-chat-text-fill me-2"></i>
                            <span class="small">Start Your Brand</span>
                        </span>
            </button>
        </div>
    </div>
</nav>

<!--start wrapper-->
<div class="container wrapper mt-5 "  style="height:100% !important">
    <div class="row">
        @if($errors->any())
            <center>
                <div class="alert alert-danger alert-block mt-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>{{ implode('', $errors->all()) }}</strong><br>
                </div>
            </center>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block mt-5">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
    </div>
    <div class="row">
        @yield("content")

    </div>

</div>


<!-- Feedback Modal-->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary-to-secondary p-4">
                <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">Start Your Brand</h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 p-4">
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form id="contactForm" method="post" action="{{route('brand.joinRequests.store')}}">
                @csrf
                <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" type="text" name="name" placeholder="Enter your name..."
                               data-sb-validations="required"/>
                        <label for="name">Full name</label>
                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" name="email" placeholder="name@example.com"
                               data-sb-validations="required,email"/>
                        <label for="email">Email address</label>
                        <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="tel" name="phone" placeholder="(123) 456-7890"
                               data-sb-validations="required"/>
                        <label for="phone">Phone number</label>
                        <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.
                        </div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message" type="text" name="message"
                                  placeholder="Enter your message here..." style="height: 10rem"
                                  data-sb-validations="required"></textarea>
                        <label for="message">Message</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Form submission successful!</div>
                            To activate this form, sign up at
                            <br/>
                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage">
                        <div class="text-center text-danger mb-3">Error sending message!</div>
                    </div>
                    <!-- Submit Button-->
                    <div class="d-grid">
                        <button class="btn btn-primary rounded-pill btn-lg" id="submitButton" type="submit">Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{asset('assets/web/js/scripts.js')}}"></script>
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>

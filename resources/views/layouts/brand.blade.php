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
        </style>
    @endif


    <link href="{{asset('assets/admin/'. $lang . '/css/pace.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('assets/admin/'. $lang . '/js/pace.min.js')}}"></script>
    <!--plugins-->
    <link href="{{asset("assets/admin/old/css/icons.min.css")}}" rel="stylesheet" type="text/css"/>


    <!--plugins-->
    <link href="{{asset('assets/admin/'. $lang . '/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}"
          rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/plugins/datatable/css/dataTables.bootstrap5.min.css')}}"
          rel="stylesheet"/>


    <!-- CSS Files -->
    <link href="{{asset('assets/admin/'. $lang . '/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/'. $lang . '/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/'. $lang . '/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/'. $lang . '/css/icons.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!--Theme Styles-->
    <link href="{{asset('assets/admin/'. $lang . '/css/dark-theme.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/css/semi-dark.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/'. $lang . '/css/header-colors.css')}}" rel="stylesheet"/>

    <style>
        .form-group {
            margin: 10px;
        }
    </style>

</head>

<body>


<!--start wrapper-->
<div class="wrapper">

    <!--start sidebar -->
    <aside class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <a href="" target="_blank">
                    <img src="{{asset('assets/admin/'. $lang . '/images/logo-icon-2.png')}}" class="logo-icon"
                         alt="logo icon">
                </a>
            </div>
            <div>
                <a href="" target="_blank">
                    <h4 class="logo-text">Multi Vendor</h4>
                </a>
            </div>
            <div class="toggle-icon ms-auto">
                <ion-icon name="menu-sharp"></ion-icon>
            </div>

        </div>
        <!--navigation-->

        <ul class="metismenu" id="menu">

            @include('brand.sections')

        </ul>

        <!--end navigation-->
    </aside>
    <!--end sidebar -->


    <header class="top-header">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-menu-button">
                <ion-icon name="menu-sharp"></ion-icon>
            </div>
            <form class="searchbar">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
                    <ion-icon name="search-sharp"></ion-icon>
                </div>
                <input class="form-control" type="text" placeholder="Search for anything">
                <div class="position-absolute top-50 translate-middle-y search-close-icon">
                    <ion-icon name="close-sharp"></ion-icon>
                </div>
            </form>
            <div class="top-navbar-right ms-auto">

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-button">
                        <a class="nav-link" href="javascript:;">
                            <div class="">
                                <ion-icon name="search-sharp"></ion-icon>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dark-mode-icon" href="javascript:;">
                            <div class="mode-icon">
                                <ion-icon name="moon-sharp"></ion-icon>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-large dropdown-apps">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                           data-bs-toggle="dropdown">
                            <div class="">
                                <ion-icon name="apps-sharp"></ion-icon>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <div class="row row-cols-3 g-3 p-3">
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-purple text-white">
                                        <ion-icon name="cart-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Orders</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-info text-white">
                                        <ion-icon name="people-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Teams</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-success text-white">
                                        <ion-icon name="shield-checkmark-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Tasks</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-danger text-white">
                                        <ion-icon name="videocam-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Media</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-warning text-white">
                                        <ion-icon name="file-tray-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Files</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-branding text-white">
                                        <ion-icon name="notifications-sharp"></ion-icon>
                                    </div>
                                    <div class="app-title">Alerts</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                           data-bs-toggle="dropdown">
                            <div class="position-relative">
                                <span class="notify-badge">8</span>
                                <ion-icon name="notifications-sharp"></ion-icon>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">Marks all as read</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-primary">
                                            <ion-icon name="cart-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
                            ago</span></h6>
                                            <p class="msg-info">You have recived new orders</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-danger">
                                            <ion-icon name="person-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
                            ago</span></h6>
                                            <p class="msg-info">5 new user registered</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-success">
                                            <ion-icon name="document-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
                            ago</span></h6>
                                            <p class="msg-info">The pdf files generated</p>
                                        </div>
                                    </div>
                                </a>

                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-info">
                                            <ion-icon name="checkmark-done-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Product Approved <span class="msg-time float-end">2 hrs ago</span>
                                            </h6>
                                            <p class="msg-info">Your new product has approved</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-warning">
                                            <ion-icon name="send-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
                            ago</span></h6>
                                            <p class="msg-info">5.1 min avarage time response</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-danger">
                                            <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
                            ago</span></h6>
                                            <p class="msg-info">New customer comments recived</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-primary">
                                            <ion-icon name="albums-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
                            ago</span></h6>
                                            <p class="msg-info">24 new authors joined last week</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-success">
                                            <ion-icon name="shield-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
                            ago</span></h6>
                                            <p class="msg-info">Successfully shipped your item</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify text-warning">
                                            <ion-icon name="cafe-outline"></ion-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
                            ago</span></h6>
                                            <p class="msg-info">45% less alerts last 4 weeks</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-user-setting">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                           data-bs-toggle="dropdown">
                            <div class="user-setting">
                                <img src="{{asset('assets/admin/'. $lang .'/images/avatars/06.png')}}" class="user-img"
                                     alt="">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex flex-row align-items-center gap-2">
                                        <img src="{{asset('assets/admin/'. $lang .'/images/avatars/06.png')}}" alt=""
                                             class="rounded-circle" width="54" height="54">
                                        <div class="">
                                            <h6 class="mb-0 dropdown-user-name">{{Auth::guard('brand')->user()->name}}</h6>
                                            <small class="mb-0 dropdown-user-designation text-secondary">System Admin</small>
                                        </div>
                                    </div>
                                </a>
                            </li>


                            <li>
                                <form class="dropdown-item" action="{{route('logout')}}" method="post">
                                    @csrf
                                    <div class="d-flex align-items-center">
                                        <input class="btn btn-danger" type="submit" value="{{__('layout.logout')}}">
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </nav>
    </header>

    <div class="page-content-wrapper">
        <div class="page-content">
            @if($errors->any())
                <center>
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                        <strong>{{ implode('', $errors->all()) }}</strong>
                    </div>
                </center>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @yield("content")


        </div>
    </div>
    <!--end page content wrapper-->
    <!--start switcher-->
    <div class="switcher-body">
        <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
            <ion-icon name="color-palette-sharp" class="me-0"></ion-icon>
        </button>
        <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false"
             tabindex="-1" id="offcanvasScrolling">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <h6 class="mb-0">Theme Variation</h6>
                <hr>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme"
                           value="option2">
                    <label class="form-check-label" for="DarkTheme">Dark</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDark" value="option3"
                           checked>
                    <label class="form-check-label" for="SemiDark">Semi Dark</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme"
                           value="option1">
                    <label class="form-check-label" for="LightTheme">Light</label>
                </div>
                <hr/>
                <h6 class="mb-0">Header Colors</h6>
                <hr/>
                <div class="header-colors-indigators">
                    <div class="row row-cols-auto g-3">
                        <div class="col">
                            <div class="indigator headercolor1" id="headercolor1"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor2" id="headercolor2"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor3" id="headercolor3"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor4" id="headercolor4"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor5" id="headercolor5"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor6" id="headercolor6"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor7" id="headercolor7"></div>
                        </div>
                        <div class="col">
                            <div class="indigator headercolor8" id="headercolor8"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--start footer-->
    <!--    <footer class="footer">
            <div class="footer-text">
                Copyright © 2021. All right reserved.
            </div>
        </footer>-->
    <!--end footer-->


    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top">
        <ion-icon name="arrow-up-outline"></ion-icon>
    </a>
    <!--End Back To Top Button-->


    <!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->

</div>
<!--end wrapper-->


<!-- JS Files-->
<script src="{{asset('assets/admin/'. $lang . '/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/plugins/chartjs/chart.min.js')}}"></script>
<script src="{{asset('assets/admin/'. $lang . '/js/index.js')}}"></script>
<!-- Main JS-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<!--plugins-->
<script src="{{asset('assets/admin/'. $lang . '/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/admin/' . $lang . '/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/' . $lang . '/plugins/datatable/js/dataTables.bootstrap5.min.js')}} "></script>
<script src="{{asset('assets/admin/' . $lang . '/js/table-datatable.js')}}"></script>


<!--plugins-->
<script src="{{asset('assets/admin/' . $lang . '/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/admin/' . $lang . '/plugins/apexcharts-bundle/js/apex-custom.js')}}"></script>


<!-- Main JS-->
<script src="{{asset('assets/admin/'. $lang . '/js/main.js')}}"></script>
<script>


    $(document).ready(function () {
        //$("html").attr("class", "light-theme")
    });


</script>
@yield("scripts")

</body>

</html>

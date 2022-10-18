@extends("layouts.admin")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
    @section("pageTitle", "كل التذاكر")
@else
    @section("pageTitle", "All Tickets")
@endif
@section('style')
    <link href="{{asset("assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>
@endsection
@section("content")
    <form action="{{route('mark_as_read')}}" method="POST">
        @csrf
        <div class-="card mt-4">
            <input class="form-control btn btn-light" type="text" id="myInput" onkeyup="myFunction()" placeholder="{{__('home.search_for_products')}}" title="Type in a name" style="border: 1px solid black">
            <br><br>
            <div class="row">
                <div class="col-sm-6 text-center">
                    <a  class="btn btn-dark"  style="width: 300px" href="{{route('mark_all_as_read',['user_id'=>$id])}}" >
                        {{__('home.mark_all_as_read')}}
                    </a>
                </div>
                <div class="col-sm-6 text-center">
                    <input type="submit" class="btn btn-dark" value="{{__('home.mark_as_read')}}" style="width: 300px">
                </div>
            </div>
            <br>
            <ul class="message-list" id="myUL">
                @foreach($notifications as $notify)
                        @if($notify->read == 0)
                            <li class="unread">
                        @else
                            <li>
                        @endif
                        <div class="col-mail col-mail-1">
                            <div class="checkbox-wrapper-mail">
                                <input type="checkbox" id="chk{{$notify->id}}" value="{{$notify->id}}" name="list[]">
                                <label for="chk{{$notify->id}}" class="toggle"></label>
                            </div>
                            <a href="#" class="title">
                                {{$notify->category->name}}
                            </a>
                        </div>
                        <div class="col-mail col-mail-2 ">
                            <a href="#" class="subject ">
                                <span class="teaser   ">
                                    <center>
                                            {{__('home.warning_product')}} {{$notify->curent_number}}

                                    </center>
                                </span>
                            </a>
                            <div class="date">{{date_format($notify->created_at,'D m  Y')}}</div>
                        </div>
                    </li>
                @endforeach

            </ul>
            {{$notifications->links()}}

        </div>
    </form>
@endsection
@section("script")



    <script>
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
    <script src="{{asset("assets/admin/js/app.js")}}"></script>

@endsection

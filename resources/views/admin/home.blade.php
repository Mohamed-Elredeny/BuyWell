@extends("layouts.admin")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
    @section("pageTitle", "الرئيسية")
@else
    @section("pageTitle", "Home")
@endif
<?php $res=[];?>

@section("content")
    <div class="container">
        <div class="row">
            <div class="container">
                <form class="row text-center" action="" method="POST">
                    @csrf
                    <div class="col-sm-1"></div>
                        <div class="col-sm-2 h6 ">
                            <label for="filter">Filter</label> :
                            <select class="form-control" id="filter" name="date">
                                <option value="today">Today</option>
                                <option value="all">All</option>
                                <option value="from">From To</option>
                            </select>
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">From</label> : <input type="date" class="form-control" id="from" name="from">
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">To</label> : <input type="date" class="form-control" id="to" name="to">
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">Country</label> :
                            <select class="form-control"  name="country" id="country_id">


                            </select>
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from"> &#160;</label>
                            <input class="form-control btn btn-dark" type="submit">

                        </div>
                    <div class="col-sm-1"></div>

                </form>
            </div>
        </div>
        <hr>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="person-add-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0">Total Sales</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0"> Dollars</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="heart-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0"> New Orders</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0"> Orders</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="chatbox-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0">Confirmed Orders</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0"> Orders</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="mail-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0">Delivered Orders</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0"> Orders</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end row-->
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Statistics</h6>
                            <div class="ms-auto">
                                <div class="d-flex align-items-center font-13 gap-2">
                      <span class="border px-1 rounded cursor-pointer"><i
                              class="bx bxs-circle me-1 text-primary"></i>Downloads</span>
                                    <span class="border px-1 rounded cursor-pointer"><i
                                            class="bx bxs-circle me-1 text-primary opacity-50"></i>Earnings</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container1">
                            <canvas id="chart5"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <h6 class="mb-0 text-uppercase">Confirmation Percentage</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div id="chart12"></div>
                    </div>
                </div>

            </div>
            <div class="col-xl-6 mx-auto">
                <h6 class="mb-0 text-uppercase">Delivered Percentage</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div id="chart12"></div>
                    </div>
                </div>
            </div>

        </div>




        <!-- end row -->


    </div>
@endsection

@section("script")


    <script>
        $(document).ready(function () {
            $('#country_id').on('change', function () {
                var id = $(this).val();
                //alert(id);
                $.ajax({
                    url: '',
                    method: "get",
                    data: {country_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var cities = document.getElementById('city_id');
                        cities.innerHTML = "<option>Select City</option>";
                        data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_ar'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
        });

        var xValues = [0];
        var yValues = [0];
        <?php $max = 0; ?>

        @foreach($res as $key => $value)
            xValues.push('<?php echo $key ?>');
            yValues.push('<?php echo $value ?>');
            <?php $max +=$value; ?>
        @endforeach
         <?php $node = $max / 10 ; ?>
        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: true,
                    lineTension: 0,
                    backgroundColor: "rgb(190,137,234)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: {{0}}, max: {{$max}}}}],
                }
            }
        });
    </script>

    <script>
        var yarab = [];
        var ii = 0;
        <?php $categories = [] ?>
            @foreach( $categories as $course)
            yarab[ii] = "{{$course['name']}}";
        ii++;
        @endforeach
        <?php
            $xx = 0;
            $yy = 0;
            ?>
            !function (e) {
            "use strict";

            function a() {
            }

            a.prototype.init = function () {
                c3.generate({
                    bindto: "#chart", data: {
                        columns: [
                            ["{{__('admin/section.available_products')}}"{{$xx}}],
                            ["{{__('admin/section.sold_products')}}"{{$yy}}],
                        ],
                        type: "bar",
                    },
                    tooltip: {
                        contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                            var $$ = this, config = $$.config,
                                titleFormat = config.tooltip_format_title || defaultTitleFormat,
                                nameFormat = config.tooltip_format_name || function (name) {
                                    return name;
                                },
                                valueFormat = config.tooltip_format_value || defaultValueFormat,
                                text, i, title, value, name, bgcolor;
                            for (i = 0; i < d.length; i++) {
                                var y = 0;
                                if (!(d[i] && (d[i].value || d[i].value === 0))) {
                                    continue;
                                }

                                if (!text) {
                                    title = titleFormat ? titleFormat(d[i].x) : d[i].x;
                                    var list = document.getElementsByClassName("c3-axis")[0];
                                    list.getElementsByTagName("tspan")[title].innerHTML = yarab[title];
                                    text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2'>" + yarab[title] + "</th></tr>" : "");
                                }

                                name = nameFormat(d[i].name);
                                value = valueFormat(d[i].value, d[i].ratio, d[i].id, d[i].index);
                                bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

                                text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                                text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + name + "</td>";
                                text += "<td class='value'>" + value + "</td>";
                                text += "</tr>";
                                y++;
                            }
                            return text + "</table>";
                        }
                    }

                }),
                    c3.generate({
                        bindto: "#donut-chart",
                        data: {
                            columns: [
                                ["{{__('admin/home.Open')}}", {{1}}],
                                ["{{__('admin/home.Close')}}", {{1}}],
                                ["{{__('admin/home.Accept')}}", {{1}}],
                                ["{{__('admin/home.Refused')}}", {{1}}],
                                ["{{__('admin/home.Pending')}}", {{1}}]
                            ],
                            type: "donut"
                        },
                        donut: {
                            title: "{{__('admin/home.Ticket')}}",
                            width: 30,
                            label: {show: !1}
                        },
                        color: {
                            pattern: ["#ffbb44", "#39325c", "#4ac18e", "#f06292", "#3bc3e9"]
                        }
                    })
            }
            e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.ChartC3.init()
        }();

        ////////////
        !function (e) {
            "use strict";

            function a() {
            }

            a.prototype.init = function () {
            c3.generate({
                    bindto: "#chart-with-area-moka",
                    data: {
                        columns: [["SonyVaio", 30, 20, 50, 40, 60, 50], ["iMacs", 200, 130, 90, 240, 130, 220], ["Tablets", 300, 200, 160, 400, 250, 250], ["iPhones", 200, 130, 90, 240, 130, 220], ["Macbooks", 130, 120, 150, 140, 160, 150]],
                        types: {SonyVaio: "bar", iMacs: "bar", Tablets: "spline", iPhones: "line", Macbooks: "bar"},
                        colors: {
                            SonyVaio: "#67a8e4",
                            iMacs: "#4ac18e",
                            Tablets: "#3bc3e9",
                            iPhones: "#ffbb44",
                            Macbooks: "#ea553d"
                        },
                        groups: [["SonyVaio", "iMacs"]]
                    },
                    axis: {x: {type: "categorized"}}
                }), c3.generate({
                    bindto: "#donut-chart",
                    data: {
                        columns: [["Desktops", 78], ["Smart Phones", 55], ["Mobiles", 40], ["Tablets", 25]],
                        type: "donut"
                    },
                    donut: {title: "Candidates", width: 30, label: {show: !1}},
                    color: {pattern: ["#f06292", "#6d60b0", "#5468da", "#009688"]}
                }), c3.generate({
                    bindto: "#pie-chart",
                    data: {
                        columns: [["Desktops", 78], ["Smart Phones", 55], ["Mobiles", 40], ["Tablets", 25]],
                        type: "pie"
                    },
                    color: {pattern: ["#afb42b", "#fb8c00", "#8d6e63", "#90a4ae"]},
                    pie: {label: {show: !1}}
                })
            }, e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.ChartC3.init()
        }();
        //////////////////////////////////

    </script>

@endsection

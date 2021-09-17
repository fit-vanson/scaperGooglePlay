
@extends('layouts/contentLayoutMaster')

@section('title', 'Detail App')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection
@section('page-style')
    <!-- Page css files -->
    <style>
        .swiper-slide {
            width: auto;
        }
    </style>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-invoice-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-swiper.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')

    <section class="app-user-view">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-7">
                <div class="card user-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start">
                                        <img
                                                class="img-fluid rounded"
                                                src="{{$appInfo->logo}}"
                                                height="104"
                                                width="104"
                                                alt="User avatar"
                                        />
                                        <div class="d-flex flex-column ml-1">
                                            <div class="user-info mb-1">
                                                <h4 class="mb-0">{{$appInfo->name}}</h4>
                                                <span class="card-text">{{$appInfo->appId}}</span>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <a href="http://play.google.com/store/apps/details?id={{$appInfo->appId}}&hl=en" target="_blank" class="btn btn-primary">View</a>
                                                @if($appInfo->status ==1 )<button class="btn btn-outline-warning ml-1">Đang theo dõi</button>
                                                @else($appInfo->status ==1) <button class="btn btn-outline-dark ml-1">Theo dõi</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center user-total-numbers">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="color-box bg-light-primary">
                                            <i data-feather="download" class="text-primary"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">{{number_format($data[0]['installs'])}}</h5>
                                            <small>Install</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="color-box bg-light-success">
                                            <i data-feather="eye" class="text-success"></i>
                                        </div>
                                        <div class="ml-1">
                                            <h5 class="mb-0">{{number_format($data[0]['numberReviews'])}}</h5>
                                            <small>Review</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                <div class="user-info-wrapper">

                                    <div class="d-flex flex-wrap">
                                        <div class="user-info-title">
                                            <i data-feather="file" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Size</span>
                                        </div>
                                        <p class="card-text mb-0">{{$data[0]['size']}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="check" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">App Version</span>
                                        </div>
                                        <p class="card-text mb-0">{{$data[0]['appVersion']}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="link" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Police Url</span>
                                        </div>
                                        <a href="{{$appInfo['privacyPoliceUrl']}}" target="_blank"> <p class="card-text mb-0">{{$appInfo['privacyPoliceUrl']}}</p></a>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="upload" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Released</span>
                                        </div>
                                        <p class="card-text mb-0">{{date('d-m-Y',strtotime($appInfo['released']))}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="download" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Updated</span>
                                        </div>
                                        <p class="card-text mb-0">{{date('d-m-Y',strtotime($data[0]['updated']['date']))}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="dollar-sign" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">IAPCost</span>
                                        </div>
                                        <p class="card-text mb-0">@if($appInfo->offersIAPCost ==1)<div class="badge badge-light-success">True</div> @else <div class="badge badge-light-danger">False</div> @endif</p>
                                    </div>
                                    <div class="d-flex flex-wrap my-50">
                                        <div class="user-info-title">
                                            <i data-feather="dollar-sign" class="mr-1"></i>
                                            <span class="card-text user-info-title font-weight-bold mb-0">Ads</span>
                                        </div>
                                        <p class="card-text mb-0">@if($appInfo->containsAds ==1) <div class="badge badge-light-success">True</div> @else <div class="badge badge-light-danger">False</div> @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Screenshot</h4>
                    </div>
                    <div class="card-body">
                        <div class="swiper-responsive-breakpoints swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="img-fluid" style="width: auto;height: 350px"  src="{{$appInfo->cover}}" alt="banner" />
                                </div>
                                @foreach(\GuzzleHttp\json_decode($appInfo->screenshots,true) as $screenshot)
                                    <div class="swiper-slide">
                                        <img class="img-fluid" style="width: auto;height: 350px" src="{{$screenshot}}" alt="banner" />
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="col-xl-5 col-lg-5 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                <div class="card-header d-flex justify-content-between align-items-start pb-1">
                                    <div>
                                        <h4 class="card-title mb-25">Đánh giá</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="text-align: center">

                                    <p style="text-align: center;font-size: 64px; line-height: 64px;font-weight: 100;">{{number_format($data[0]['score'],1)}}</p>
                                    @for($b=1;$b<= number_format($data[0]['score']);$b++)
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="12px" height="12px" fill="#f39c12"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg>
                                    @endfor
                                    @for($a=1;$a<= 5- number_format($data[0]['score']);$a++)
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="12px" height="12px" fill="gray"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg>
                                    @endfor
                                    <p>
                                        <i data-feather="user"></i>  Tổng  <span class="" aria-label="2.401.495 xếp hạng">{{number_format($data[0]['numberVoters'])}}</span>
                                    </p>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                <div class="card-header d-flex justify-content-between align-items-start pb-1">
                                    <div>
                                        <h4 class="card-title mb-25">Histogram Rating</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="histogram-rating" class="mt-50"></div>
                                    <canvas class="chartjs_Histogram_Rating" data-height="175"></canvas>
                                </div>
                            </div>
                        </div>

                        <?php $i =0; ?>
                        @foreach(\GuzzleHttp\json_decode($appInfo->reviews,true) as $review)
                            @if(++$i <= 5)
                                <div class="d-flex align-items-start mb-1">
                                    <div class="avatar mt-25 mr-75">
                                        <img
                                                src="{{$review['avatar']}}"
                                                alt="Avatar"
                                                height="34"
                                                width="34"
                                        />
                                    </div>
                                    <div class="profile-user-info w-100">
                                        <h6 class="mb-0">{{$review['userName']}}</h6>
                                        @for($a=1;$a<= $review['score'];$a++)
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="12px" height="12px" fill="#f39c12"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg>
                                        @endfor
                                        @for($a=1;$a<= 5- $review['score'];$a++)
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="12px" height="12px" fill="gray"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg>
                                        @endfor

                                        <small class="text-muted">{{date('H:i:s d-m-Y',$review['date'])}}</small>
                                        <small class="text-muted"><i data-feather="thumbs-up" class="text-body font-medium-1"></i>
                                            <span class="align-middle text-muted">{{$review['countLikes']}}</span></small>
                                        <p class="card-text" >{{nl2br($review['text'])}}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-start pb-1">
                        <div>
                            <h4 class="card-title mb-25">Description</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                                <p>
                                    {{nl2br($appInfo->summary)}}
                                </p>
                            </div>
                            <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                                <p>
                                    {!! nl2br($appInfo->description) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                        <div>
                            <h4 class="card-title">Line Chart</h4>
                            <span class="card-subtitle text-muted">Commercial networks</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="line-area-chart"></div>
                        <div id="line-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/swiper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>



@endsection
@section('page-script')
    <!-- Page js files -->
{{--    <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('js/scripts/pages/app-invoice-list.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('js/scripts/extensions/ext-component-swiper.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('js/scripts/charts/chart-chartjs.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('js/scripts/charts/chart-apex.js')) }}"></script>--}}
    <script>
        $(window).on('load', function () {
            'use strict';

            var labelFormatter = function(value) {
                var val = Math.abs(value);
                if (val >= 1000000) {
                    val = (val / 1000000).toFixed(1) + "M";
                }
                if (val >= 1000) {
                    val = (val / 1000).toFixed(1) + "K";
                }
                return val;
            };
            function addCommas(nStr)
            {
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

            var id = window.location.search;
            var
                barChartEx = $('.chartjs_Histogram_Rating');
            // Color Variables
            var successColorShade = '#28dac6',
                tooltipShadow = 'rgba(0, 0, 0, 0.25)',
                labelColor = '#6e6b7b',
                grid_line_color = 'rgba(200, 200, 200, 0.2)'; // RGBA color helps in dark layout

            var flatPicker = $('.flat-picker'),
                isRtl = $('html').attr('data-textdirection') === 'rtl',
                chartColors = {
                    column: {
                        series1: '#826af9',
                        series2: '#d2b0ff',
                        bg: '#f8d3ff'
                    },
                    success: {
                        shade_100: '#7eefc7',
                        shade_200: '#06774f'
                    },
                    donut: {
                        series1: '#ffe700',
                        series2: '#00d4bd',
                        series3: '#826bf8',
                        series4: '#2b9bf4',
                        series5: '#FFA1A1'
                    },
                    area: {
                        series3: '#f2fa04',
                        series2: '#001af6',
                        series1: '#2bdac7'
                    }
                };


            // Detect Dark Layout
            if ($('html').hasClass('dark-layout')) {
                labelColor = '#b4b7bd';
            }
            var chart = new Chart(barChartEx, {
                    type: 'horizontalBar',
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 1,
                                borderSkipped: 'bottom'
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        responsiveAnimationDuration: 500,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            // Updated default tooltip UI
                            shadowOffsetX: 1,
                            shadowOffsetY: 1,
                            shadowBlur: 8,
                            shadowColor: tooltipShadow,
                            backgroundColor: window.colors.solid.white,
                            titleFontColor: window.colors.solid.black,
                            bodyFontColor: window.colors.solid.black
                        },
                        scales: {
                            xAxes: [
                                {
                                    barThickness: 15,
                                    display: false,
                                    gridLines: {
                                        display: true,
                                        color: grid_line_color,
                                        zeroLineColor: grid_line_color
                                    },
                                    scaleLabel: {
                                        display: false
                                    },

                                }
                            ],
                            yAxes: [
                                {
                                    display: true,
                                    gridLines: {
                                        color: grid_line_color,
                                        zeroLineColor: grid_line_color
                                    },
                                }
                            ]
                        }
                    },
                    data: {
                        labels: ['1', '2', '3', '4', '5'],
                        datasets: []
                    }
                });
            var lineChartEl = document.querySelector('#line-chart'),
                lineChartConfig = {
                    chart: {
                        height: 800,
                        // type: 'bar',
                        zoomType: 'x,y',
                        parentHeightOffset: 0,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [],
                    markers: {
                        strokeWidth: 7,
                        strokeOpacity: 1,
                        strokeColors: [window.colors.solid.white],
                        colors: [window.colors.solid.warning]
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
                    grid: {
                        padding: {
                            top: +30
                        }
                    },
                    tooltip: {
                        x: {
                            format: 'dd MM yyyy'
                        },
                        y: {
                            formatter: function(value) {
                                return addCommas(value.toFixed(1))
                            }
                        }

                    },
                    xaxis: {
                        type: 'datetime',
                        labels: {
                            datetimeFormatter: {
                                year: 'yyyy',
                                month: 'MM yyyy',
                                day: 'dd MM yyyy',
                                hour: 'HH:mm'
                            }
                        },

                    },
                };
            if (typeof lineChartEl !== undefined && lineChartEl !== null) {
                var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
                lineChart.render();
            }
            $.ajax({
                type: 'get', //post method
                url: "{{route('googleplay-detailApp-Ajax')}}" +id,
                dataType: "json",
                success: function (result)
                {
                    console.log((result[1]))
                    var length_histogramRating = result[0].length;
                    var histogramRating = result[0][length_histogramRating-1].histogramRating;
                    histogramRating = [histogramRating.one,histogramRating.two,histogramRating.three,histogramRating.four,histogramRating.five];
                    chart.data.datasets = [{data: histogramRating,backgroundColor:successColorShade}];
                    chart.update();
                    lineChart.updateSeries([
                        {
                            name: 'Installs',
                            type: 'line',
                            data:result[1],

                        },
                        {
                            name: 'Vote',
                            type: 'line',
                            data:result[2],

                        },
                        {
                            name: 'Review',
                            type: 'line',
                            data:result[3]
                        },
                    ])
                    var maxInstall= Math.max.apply(Math, result[1].map(function(o) { return o.y; }));
                    var minInstall= Math.min.apply(Math, result[1].map(function(o) { return o.y; }));
                    var maxVote= Math.max.apply(Math, result[2].map(function(o) { return o.y; }));
                    var minVote= Math.min.apply(Math, result[2].map(function(o) { return o.y; }));
                    var maxReview= Math.max.apply(Math, result[3].map(function(o) { return o.y; }));
                    var minReview= Math.min.apply(Math, result[3].map(function(o) { return o.y; }));
                    lineChart.updateOptions(
                            {
                                yaxis: [
                                    {
                                        seriesName: 'Installs',
                                        axisTicks: {
                                            show: true,
                                        },
                                        axisBorder: {
                                            show: true,
                                        },
                                        max:maxInstall,
                                        min:minInstall,
                                        labels: {
                                            formatter: labelFormatter
                                        },

                                    },
                                    {
                                        opposite: true,
                                        seriesName: 'Vote',
                                        axisTicks: {
                                            show: true
                                        },
                                        axisBorder: {
                                            show: true,
                                        },
                                        max:maxVote ,
                                        min:minVote,
                                        labels: {
                                            formatter: labelFormatter
                                        },
                                    },
                                    {
                                        opposite: true,
                                        seriesName: 'Review',
                                        axisTicks: {
                                            show: true
                                        },
                                        axisBorder: {
                                            show: true,
                                        },
                                        max:maxReview,
                                        min:minReview,
                                        labels: {
                                            formatter: labelFormatter
                                        },
                                    },
                                ]
                            })


                }
            });

            new Swiper('.swiper-responsive-breakpoints', {
                slidesPerView: 'auto',
                height:500,
                spaceBetween: 10,
                grabCursor: true,
                centeredSlides: true,
                // init: false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },

            });
        });


    </script>
@endsection

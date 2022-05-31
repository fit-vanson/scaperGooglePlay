
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-invoice-list.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-swiper.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

  @endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
  <div class="row match-height">
    <!-- Greetings Card starts -->
    <div class="col-lg-6 col-md-12 col-sm-12">
      <div class="card card-congratulations">
        <div class="card-body text-center">
          <img
            src="{{asset('images/elements/decore-left.png')}}"
            class="congratulations-img-left"
            alt="card-img-left"
          />
          <img
            src="{{asset('images/elements/decore-right.png')}}"
            class="congratulations-img-right"
            alt="card-img-right"
          />
          <div class="avatar avatar-xl bg-primary shadow">
            <div class="avatar-content">
              <i data-feather="award" class="font-large-1"></i>
            </div>
          </div>
          <div class="text-center">
            <h1 class="mb-1 text-white">Congratulations John,</h1>
            <p class="card-text m-auto w-75">
              You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Greetings Card ends -->

    <!-- Orders Chart Card starts -->
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header flex-column align-items-start pb-0">
          <div class="avatar bg-light-warning p-50 m-0">
            <div class="avatar-content">
              <i data-feather="package" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="font-weight-bolder mt-1">{{$totalAppFollow}}</h2>
          <p class="card-text">App đang theo dõi</p>
          <a href="{{route('googleplay-follow-app')}}">Chi tiết</a>
        </div>
        <div id="order-chart"></div>
      </div>
    </div>
    <!-- Orders Chart Card ends -->
  </div>
  <div class="row match-height">
    <!-- Browser States Card -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-browser-states">
        <div class="card-header">
          <div>
            <h4 class="card-title">Top App</h4>
          </div>
          <div class="col-lg-5">
            <select class="select2-size-sm form-control" id="select_category" onchange="chooseCategory()">
              <option>All</option>
{{-- @foreach($Categories as $Category)--}}
{{-- <option value="{{$Category['id']}}">{{$Category['name']}}</option>--}}
{{--  @endforeach--}}
            </select>
          </div>
        </div>
        <div class="card-body" id="top_app">
          @foreach($topApps as $app)
          <div class="browser-states">
            <div class="media">
              <img
                      src="{{$app['icon']}}"
                      class="rounded mr-1"
                      height="30"
                      alt="{{$app['name']}}"
              />
              <a href="{{$app['url']}}" target="_blank" ><h6 class="align-self-center mb-0">{{$app['name']}}</h6></a>
            </div>
            <div class="d-flex align-items-center">
              <div class="font-weight-bold text-body-heading mr-1">{{$app['score']}}</div>
              <div id="browser-state-chart-primary"></div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>
    <!--/ Browser States Card -->
    <!-- Browser States Card -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-browser-states">
        <div class="card-header">
          <div>
            <h4 class="card-title">Top Growth</h4>
          </div>
          <div class="col-lg-5">
            <select class="select2-size-sm form-control" id="select_key" onchange="chooseGrowth()">
                <option value="installs">Installs</option>
                <option value="numberVoters">Voters</option>
                <option value="numberReviews">Reviews</option>
            </select>
          </div>
          <div class="col-lg-3">
            <select class="select2-size-sm form-control" id="select_date" onchange="chooseGrowth()">
              <option value="7">7 ngày</option>
              <option value="15">15 ngày</option>
              <option value="30">30 ngày</option>
            </select>
          </div>
        </div>
        <div class="card-body" id="top_growths">
          @foreach($topGrowths as $app)
            <div class="browser-states">
              <div class="media">
                <a href="https://play.google.com/store/apps/details?id={{$app['appId']}}" target="_blank" >
                  <img
                          src="{{$app['icon']}}"
                          class="rounded mr-1"
                          height="30"
                          alt="{{$app['name']}}"
                  />
                </a>
                <a href="{{route('googleplay-detailApp')}}?id={{$app['appId']}}" target="_blank" ><h6 class="align-self-center mb-0">{{$app['name']}}</h6></a>
              </div>
              <div class="d-flex align-items-center">
                <div class="font-weight-bold text-body-heading mr-1">{{number_format($app['result'])}} <p class="text-success">+{{number_format($app['percent'],2)}}%</p></div>
                <div id="browser-state-chart-primary"></div>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
    <!--/ Browser States Card -->


    <!--/ Transaction Card -->
  </div>
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
          <div>
              <h4 class="card-title">Analytics</h4>
              <span class="card-subtitle text-muted">Khảo sát theo key word</span>
          </div>
          <div class=" align-items-center">
            <form id="searchKeyForm" name="searchKeyForm">
              <div class="form-group input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
                <input type="text" class="form-control" id="input_search_key" name="input_search_key" placeholder="Search Key word..." />
              </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <div id="line-area-chart"></div>
          <div id="line-chart"></div>
        </div>
      </div>
    </div>
  </div>


  <!--/ List DataTable -->
</section>
<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap.min.js')) }}"></script>

  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>

  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


@endsection
@section('page-script')
  <!-- Page js files -->
  <script>
    function chooseCategory() {
      var id = document.getElementById("select_category").value;
      $.get('{{route('dashboard-analytics')}}/?category='+id,function (data) {
        var html = '';
        data.forEach(function(item, index, array) {
          console.log(item.name)
          html += ' <div class="browser-states">'+
                  '<div class="media">'+
                  '<img src="'+item.icon+'" class="rounded mr-1" height="30" alt="'+item.name+'"/>'+
                  '<a href="'+item.url+'" target="_blank"><h6 class="align-self-center mb-0">'+item.name+'</h6></a>'+
        '</div>'+
        '<div class="d-flex align-items-center">'+
        '<div class="font-weight-bold text-body-heading mr-1">'+item.score+'</div>'+
        '<div id="browser-state-chart-primary"></div>'+
        '</div></div>';
        })
        $('#top_app').html(html);

      })
    }
    function chooseGrowth() {
      var key = document.getElementById("select_key").value;
      var date = document.getElementById("select_date").value;
      $.get('{{route('dashboard-analytics')}}/?key='+key+'&date='+date,function (data) {

        var html = '';
        data.forEach(function(item, index, array) {
          html += '<div class="browser-states">'+
                  '<div class="media">'+
                  '<a href="https://play.google.com/store/apps/details?id='+item.appId+'" target="_blank" >'+
                  '<img src="'+item.icon+'" class="rounded mr-1" height="30" alt="'+item.name+'"/></a>'+
                  '<a href="googleplay/detail?id='+item.appId+'" target="_blank"><h6 class="align-self-center mb-0">'+item.name+'</h6></a>'+
                  '</div>'+
                  '<div class="d-flex align-items-center">'+
                  '<div class="font-weight-bold text-body-heading mr-1">'+item.result.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0})+' <p class="text-success">+'+item.percent.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})+'%</p></div>'+
                  '<div id="browser-state-chart-primary"></div>'+
                  '</div></div>';
        })
        $('#top_growths').html(html);

      })
    }
    $(window).on('load', function () {
      'use strict';
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#select_category').select2();
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
      // Color Variables
      var successColorShade = '#28dac6',
              tooltipShadow = 'rgba(0, 0, 0, 0.25)',
              labelColor = '#6e6b7b',
              grid_line_color = 'rgba(200, 200, 200, 0.2)';
      // RGBA color helps in dark layout

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
      var lineChartEl = document.querySelector('#line-chart'),
              lineChartConfig = {
                chart: {
                  height: 600,
                  // type: 'bar',
                  zoomType: 'x,y',
                  parentHeightOffset: 0,
                  toolbar: {
                    show: true
                  }
                },
                noData: {
                  text: "No data ...",
                  align: "center",
                  verticalAlign: "middle",
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
                yaxis: [
                  {
                    seriesName: 'Installs',
                    axisTicks: {
                      show: true,
                    },
                    axisBorder: {
                      show: true,
                    },
                    labels: {
                      formatter: labelFormatter
                    },
                  },
                  {
                    seriesName: 'Review',
                    show: false
                  },
                  {
                    opposite: true,
                    seriesName: 'Review',
                    axisTicks: {
                      show: false
                    },
                    axisBorder: {
                      show: false,
                    },
                    labels: {
                      formatter: labelFormatter
                    },
                  },
                ]
              };
      if (typeof lineChartEl !== undefined && lineChartEl !== null) {
        var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
        lineChart.render();
      }
      $('#searchKeyForm').on('submit',function (event){
        event.preventDefault();
        $.ajax({
          data: $('#searchKeyForm').serialize(),
          url: "{{ route('dashboard-post-analytics') }}",
          type: "GET",
          dataType: 'json',
          success: function (result) {
            console.log(result.length)
            if(result.length >0) {
              lineChart.updateSeries([
                {
                  name: 'Installs',
                  type: 'line',
                  data:result[0],

                },
                {
                  name: 'Vote',
                  type: 'line',
                  data:result[1],

                },
                {
                  name: 'Review',
                  type: 'line',
                  data:result[2]
                },
              ])
            }else {
              lineChart.updateSeries([])
            }
          },
        });
      });
    });
  </script>
 @endsection


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

    <!-- Subscribers Chart Card starts -->
{{--    <div class="col-lg-3 col-sm-6 col-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header flex-column align-items-start pb-0">--}}
{{--          <div class="avatar bg-light-primary p-50 m-0">--}}
{{--            <div class="avatar-content">--}}
{{--              <i data-feather="users" class="font-medium-5"></i>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <h2 class="font-weight-bolder mt-1">92.6k</h2>--}}
{{--          <p class="card-text">Subscribers Gained</p>--}}
{{--        </div>--}}
{{--        <div id="gained-chart"></div>--}}
{{--      </div>--}}
{{--    </div>--}}
    <!-- Subscribers Chart Card ends -->

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
              @foreach($Categories as $Category)
                <option value="{{$Category['id']}}">{{$Category['name']}}</option>
              @endforeach
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

    <!-- Goal Overview Card -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Goal Overview</h4>
          <i data-feather="help-circle" class="font-medium-3 text-muted cursor-pointer"></i>
        </div>
        <div class="card-body p-0">
          <div id="goal-overview-radial-bar-chart" class="my-2"></div>
          <div class="row border-top text-center mx-0">
            <div class="col-6 border-right py-1">
              <p class="card-text text-muted mb-0">Completed</p>
              <h3 class="font-weight-bolder mb-0">786,617</h3>
            </div>
            <div class="col-6 py-1">
              <p class="card-text text-muted mb-0">In Progress</p>
              <h3 class="font-weight-bolder mb-0">13,561</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Goal Overview Card -->

    <!-- Transaction Card -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-transaction">
        <div class="card-header">
          <h4 class="card-title">Transactions</h4>
          <div class="dropdown chart-dropdown">
            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="transaction-item">
            <div class="media">
              <div class="avatar bg-light-primary rounded">
                <div class="avatar-content">
                  <i data-feather="pocket" class="avatar-icon font-medium-3"></i>
                </div>
              </div>
              <div class="media-body">
                <h6 class="transaction-title">Wallet</h6>
                <small>Starbucks</small>
              </div>
            </div>
            <div class="font-weight-bolder text-danger">- $74</div>
          </div>
          <div class="transaction-item">
            <div class="media">
              <div class="avatar bg-light-success rounded">
                <div class="avatar-content">
                  <i data-feather="check" class="avatar-icon font-medium-3"></i>
                </div>
              </div>
              <div class="media-body">
                <h6 class="transaction-title">Bank Transfer</h6>
                <small>Add Money</small>
              </div>
            </div>
            <div class="font-weight-bolder text-success">+ $480</div>
          </div>
          <div class="transaction-item">
            <div class="media">
              <div class="avatar bg-light-danger rounded">
                <div class="avatar-content">
                  <i data-feather="dollar-sign" class="avatar-icon font-medium-3"></i>
                </div>
              </div>
              <div class="media-body">
                <h6 class="transaction-title">Paypal</h6>
                <small>Add Money</small>
              </div>
            </div>
            <div class="font-weight-bolder text-success">+ $590</div>
          </div>
          <div class="transaction-item">
            <div class="media">
              <div class="avatar bg-light-warning rounded">
                <div class="avatar-content">
                  <i data-feather="credit-card" class="avatar-icon font-medium-3"></i>
                </div>
              </div>
              <div class="media-body">
                <h6 class="transaction-title">Mastercard</h6>
                <small>Ordered Food</small>
              </div>
            </div>
            <div class="font-weight-bolder text-danger">- $23</div>
          </div>
          <div class="transaction-item">
            <div class="media">
              <div class="avatar bg-light-info rounded">
                <div class="avatar-content">
                  <i data-feather="trending-up" class="avatar-icon font-medium-3"></i>
                </div>
              </div>
              <div class="media-body">
                <h6 class="transaction-title">Transfer</h6>
                <small>Refund</small>
              </div>
            </div>
            <div class="font-weight-bolder text-success">+ $98</div>
          </div>
        </div>
      </div>
    </div>
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

  <div class="row match-height">
    <!-- Timeline Card -->
    <div class="col-lg-4 col-12">
      <div class="card card-user-timeline">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <i data-feather="list" class="user-timeline-title-icon"></i>
            <h4 class="card-title">User Timeline</h4>
          </div>
        </div>
        <div class="card-body">
          <ul class="timeline ml-50 mb-0">
            <li class="timeline-item">
              <span class="timeline-point timeline-point-indicator"></span>
              <div class="timeline-event">
                <h6>12 Invoices have been paid</h6>
                <p>Invoices are paid to the company</p>
                <div class="media align-items-center">
                  <img class="mr-1" src="{{asset('images/icons/json.png')}}" alt="data.json" height="23" />
                  <h6 class="media-body mb-0">data.json</h6>
                </div>
              </div>
            </li>
            <li class="timeline-item">
              <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
              <div class="timeline-event">
                <h6>Client Meeting</h6>
                <p>Project meeting with Carl</p>
                <div class="media align-items-center">
                  <div class="avatar mr-50">
                    <img
                      src="{{asset('images/portrait/small/avatar-s-9.jpg')}}"
                      alt="Avatar"
                      width="38"
                      height="38"
                    />
                  </div>
                  <div class="media-body">
                    <h6 class="mb-0">Carl Roy (Client)</h6>
                    <p class="mb-0">CEO of Infibeam</p>
                  </div>
                </div>
              </div>
            </li>
            <li class="timeline-item">
              <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
              <div class="timeline-event">
                <h6>Create a new project</h6>
                <p>Add files to new design folder</p>
                <div class="avatar-group">
                  <div
                    data-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-placement="bottom"
                    data-original-title="Billy Hopkins"
                    class="avatar pull-up"
                  >
                    <img
                      src="{{asset('images/portrait/small/avatar-s-9.jpg')}}"
                      alt="Avatar"
                      width="33"
                      height="33"
                    />
                  </div>
                  <div
                    data-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-placement="bottom"
                    data-original-title="Amy Carson"
                    class="avatar pull-up"
                  >
                    <img
                      src="{{asset('images/portrait/small/avatar-s-6.jpg')}}"
                      alt="Avatar"
                      width="33"
                      height="33"
                    />
                  </div>
                  <div
                    data-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-placement="bottom"
                    data-original-title="Brandon Miles"
                    class="avatar pull-up"
                  >
                    <img
                      src="{{asset('images/portrait/small/avatar-s-8.jpg')}}"
                      alt="Avatar"
                      width="33"
                      height="33"
                    />
                  </div>
                  <div
                    data-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-placement="bottom"
                    data-original-title="Daisy Weber"
                    class="avatar pull-up"
                  >
                    <img
                      src="{{asset('images/portrait/small/avatar-s-7.jpg')}}"
                      alt="Avatar"
                      width="33"
                      height="33"
                    />
                  </div>
                  <div
                    data-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-placement="bottom"
                    data-original-title="Jenny Looper"
                    class="avatar pull-up"
                  >
                    <img
                      src="{{asset('images/portrait/small/avatar-s-20.jpg')}}"
                      alt="Avatar"
                      width="33"
                      height="33"
                    />
                  </div>
                </div>
              </div>
            </li>
            <li class="timeline-item">
              <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
              <div class="timeline-event">
                <h6>Update project for client</h6>
                <p class="mb-0">Update files as per new design</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Timeline Card -->

    <!-- Sales Stats Chart Card starts -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-start pb-1">
          <div>
            <h4 class="card-title mb-25">Sales</h4>
            <p class="card-text">Last 6 months</p>
          </div>
          <div class="dropdown chart-dropdown">
            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="d-inline-block mr-1">
            <div class="d-flex align-items-center">
              <i data-feather="circle" class="font-small-3 text-primary mr-50"></i>
              <h6 class="mb-0">Sales</h6>
            </div>
          </div>
          <div class="d-inline-block">
            <div class="d-flex align-items-center">
              <i data-feather="circle" class="font-small-3 text-info mr-50"></i>
              <h6 class="mb-0">Visits</h6>
            </div>
          </div>
          <div id="sales-visit-chart" class="mt-50"></div>
        </div>
      </div>
    </div>
    <!-- Sales Stats Chart Card ends -->

    <!-- App Design Card -->
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card card-app-design">
        <div class="card-body">
          <div class="badge badge-light-primary">03 Sep, 20</div>
          <h4 class="card-title mt-1 mb-75 pt-25">App design</h4>
          <p class="card-text font-small-2 mb-2">
            You can Find Only Post and Quotes Related to IOS like ipad app design, iphone app design
          </p>
          <div class="design-group mb-2 pt-50">
            <h6 class="section-label">Team</h6>
            <div class="badge badge-light-warning mr-1">Figma</div>
            <div class="badge badge-light-primary">Wireframe</div>
          </div>
          <div class="design-group pt-25">
            <h6 class="section-label">Members</h6>
            <div class="avatar">
              <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" width="34" height="34" alt="Avatar" />
            </div>
            <div class="avatar bg-light-danger">
              <div class="avatar-content">PI</div>
            </div>
            <div class="avatar">
              <img
                src="{{asset('images/portrait/small/avatar-s-14.jpg')}}"
                width="34"
                height="34"
                alt="Avatar"
              />
            </div>
            <div class="avatar">
              <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" width="34" height="34" alt="Avatar" />
            </div>
            <div class="avatar bg-light-secondary">
              <div class="avatar-content">AL</div>
            </div>
          </div>
          <div class="design-planning-wrapper mb-2 py-75">
            <div class="design-planning">
              <p class="card-text mb-25">Due Date</p>
              <h6 class="mb-0">12 Apr, 21</h6>
            </div>
            <div class="design-planning">
              <p class="card-text mb-25">Budget</p>
              <h6 class="mb-0">$49251.91</h6>
            </div>
            <div class="design-planning">
              <p class="card-text mb-25">Cost</p>
              <h6 class="mb-0">$840.99</h6>
            </div>
          </div>
          <button type="button" class="btn btn-primary btn-block">Join Team</button>
        </div>
      </div>
    </div>
    <!--/ App Design Card -->
  </div>

  <!-- List DataTable -->
  <div class="row">
    <div class="col-12">
      <div class="card invoice-list-wrapper">
        <div class="card-datatable table-responsive">
          <table class="invoice-list-table table">
            <thead>
              <tr>
                <th></th>
                <th>#</th>
                <th><i data-feather="trending-up"></i></th>
                <th>Clieáádasdasdasnt</th>
                <th>Total</th>
                <th class="text-truncate">Issued Date</th>
                <th>Balance</th>
                <th>Invoice Status</th>
                <th class="cell-fit">Actions</th>
              </tr>
            </thead>
          </table>
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
                    format: 'd MM yyyy'
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
          },
        });
      });
    });
  </script>
@endsection

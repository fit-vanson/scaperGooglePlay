@extends('layouts/contentLayoutMaster')

@section('title', 'Google Play')

@section('vendor-style')
  {{--   vendor css files--}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
  <link rel="stylesheet" href="{{asset('vendors/css/extensions/toastr.min.css')}}">



@endsection
@section('page-style')
  {{--   Page Css files--}}
  <style>
    .swiper-slide {
      width: auto;
    }
  </style>

  <link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-swiper.css')) }}">
  <link rel="stylesheet" href="{{asset('css/base/plugins/extensions/ext-component-toastr.css')}}">

@endsection

@section('content')

  <!-- Modal -->
@include('content.googleplay.modal')

  <section id="basic-datatable">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form id="checkAppForm" method="post" action="{{route('googleplay-chooseApp')}}" name="checkAppForm">
              @csrf
              <table class="datatables-basic table">
                <thead>
                <tr>
                  <th>AppID</th>
                  <th style="width: 310px">Logo</th>
                  <th style="width: 310px">Summary</th>
                  <th>IAP / Ads</th>
                  <th>Installs</th>
                  <th>Votes</th>
                  <th>Reviews</th>
                  <th>Score</th>
                  <th>Note</th>
                  <th>action</th>
                </tr>
                </thead>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection

@section('vendor-script')
  {{--   vendor files--}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/swiper.min.js')) }}"></script>
  <script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>

@endsection

@section('page-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(('js/scripts/googleplay/clipboard.js')) }}"></script>

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var swiper =  new Swiper('.swiper-responsive-breakpoints', {
      slidesPerView: 'auto',
      loop:true,
      spaceBetween: 10,

      // init: false,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
    });
    var table = $('.datatables-basic').DataTable({
      serverSide: true,
      processing: false,
      ajax: {
        url: "{{route('googleplay-get-filter-app-list')}}",
        type: "post",
      },
      columns: [
        { data: 'appId' },
        { data: 'logo' }, // used for sorting so will hide this column
        { data: 'summary' },
        { data: 'size' },
        { data: 'installs' },
        { data: 'numberVoters' },
        { data: 'numberReviews' },
        { data: 'score' },
        { data: 'note',className: "change-note" },
        { data: 'action',className: "text-center" }
      ],
      columnDefs: [
        {
          targets: 1,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            // Creates full output for row
            return '<span class="emp_name text-truncate font-weight-bold">' +full.name +'</span>'  +
                    '<div class="d-flex align-items-center">' +
                    '<div >' +
                    '<a href="http://play.google.com/store/apps/details?id='+full.appId+
                    '&hl=en" target="_blank" ><img class="img-fluid" width="100px" height="100px" src="'+
                    full.logo + '"></a>'+
                    ' <img class="img-fluid banner_click" style="height: 100px; width: 200px" src="'+full.cover+'" alt="banner" />'+
                    '</div>' +
                    '</div>';
          }
        },
        {
          targets: 2,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            // Creates full output for row
            return '<a target="_blank" href='+full.developer_url +' ><span class="emp_name text-truncate font-weight-bold" style="color: #517f40">' +full.developer_name +'</span></a>'+
                    '<p class="emp_name">' +full.summary +'</p>'+
                    '<p class="emp_name">Released: ' +full.released +'</p>'+
                    '<p class="emp_name">Updated: ' +full.updated +'</p>';
          }
        },
        {
          targets: [3],
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            if(full.containsAds == 1){
              $containsAds =  '<div class="badge badge-light-success">Yes</div>';
            } else {
              $containsAds =  '<div class="badge badge-light-danger">No</div>';
            }
            if(full.offersIAPCost == 1){
              $offersIAPCost =  '<div class="badge badge-light-success">Yes</div>';
            } else {
              $offersIAPCost =  '<div class="badge badge-light-danger">No</div>';
            }
            if(full.size != null){
              $size =  '<span class="emp_name text-truncate font-weight-bold">Size: ' +full.size +'</span>';
            } else {
              $size =  '<span class="emp_name text-truncate font-weight-bold">Size: Null</span>';
            }
            return $size + '<br> <br> IAP: ' + $offersIAPCost + '<br> <br> ADS: '+ $containsAds
          }
        },

      ],

      dom:
              '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                      ? '<tr data-dt-row="' +
                      col.rowIndex +
                      '" data-dt-column="' +
                      col.columnIndex +
                      '">' +
                      '<td>' +
                      col.title +
                      ':' +
                      '</td> ' +
                      '<td>' +
                      col.data +
                      '</td>' +
                      '</tr>'
                      : '';
            }).join('');

            return data ? $('<table class="table"/>').append(data) : false;
          }
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      },
      // scrollY: 200,
      scroller: {
        loadingIndicator: true
      },
    });
    table.on('click', '.change-note', e=> {
      e.preventDefault();
      const row = table.row(e.target.closest('tr'));
      const rowData = row.data();
      $('#modelHeading').html(rowData.name);
      $('#id').val(rowData.appId);
      $('#note').val(rowData.note);
      $('#myModal').modal('show');
      $('.input_screenshot_img').hide();
      $('.input_note').show();
      $('.modal-dialog').prop('class','modal-dialog modal-xm')
    });
    table.on('click', '.banner_click', e=> {
      e.preventDefault();
      const row = table.row(e.target.closest('tr'));
      const rowData = row.data();
      let a = '';
      rowData.screenshots.forEach(function(item, index, array) {
        a += '<div class="swiper-slide">'+
                        '<img class="img-fluid" style="width: auto;height: 450px" src="'+item+'" alt="screenshot" />'+
                '</div>';
      })
      document.getElementById("screenshot_img").innerHTML = a;
      $('.input_screenshot_img').show();
      $('.input_note').hide();
      $('.modal-dialog').prop('class','modal-dialog modal-xl')
      $('#modelHeading').html(rowData.name);
      $('#myModal').modal('show');
      $('#myModal').on('shown.bs.modal', function(e) {
        swiper.update();
      });
    });
    $('div.head-label').html('<h6 class="mb-0">Tìm kiếm Ứng dụng</h6>');
    $(document).on('click','.followApp', function (data) {
      const row = table.row(data.target.closest('tr'));
      const rowData = row.data();
      $.post('{{asset('googleplay/followApp')}}?id='+rowData.appId,function (data)
      {
        $('.modal').modal('hide');
        toastr['success']('Theo dõi thành công!');
        table.draw();
      })
    });
    $(document).on('click','.showLink', function (data) {
      const row = table.row(data.target.closest('tr'));
      const rowData = row.data();
      let a = '';
      rowData.screenshots.forEach(function(item, index, array) {
        a +=  item + '=w2560-h1297-rw'+ '\n\n'
      })
      $('#copy-icon-input').val(rowData.logo);
      $('#copy-banner-input').val(rowData.cover+ '=w2560-h1297-rw');
      $('#copy-preview-input').val(a);
      $('#modelHeading').html(rowData.name);
      $('#modal_link').modal('show');
      $('.modal').modal('hide');

    });
    $('#searchFilterAppForm').on('submit',function (event){
      event.preventDefault();
      $.ajax({
        data: $('#searchFilterAppForm').serialize(),
        url: "{{ route('googleplay-post-filter-app') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
          table.draw();
        },
      });
    });
    $('#change_note').on('submit',function (event){
      event.preventDefault();
      $.ajax({
        data: $('#change_note').serialize(),
        url: "{{ route('googleplay-change-note') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
          $('#myModal').modal('hide');
          toastr['success']('Thành công!');
          table.draw();
        },
      });
    });
    function unfollowApp(id) {
      $.get('{{asset('googleplay/unfollowApp')}}?id='+id,function (data)
      {
        $('.modal').modal('hide');
        toastr['warning']('', 'Bỏ theo dõi thành công!');
        table.draw();
      })
    }


  </script>


@endsection


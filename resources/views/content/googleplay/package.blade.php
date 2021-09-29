@extends('layouts/contentLayoutMaster')

@section('title', 'Google Play')

@section('vendor-style')
  {{--   vendor css files--}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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

  <section id="feather-icons">
    <div class="row">
      <div class="col-12">
        <div class="icon-search-wrapper my-3 mx-auto">
          <form id="searchAppForm" name="searchAppForm">
            <div class="form-group input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i data-feather="search"></i></span>
              </div>
              <input type="text" class="form-control" id="input_search" name="input_search" placeholder="Search Apps..." />
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="d-flex flex-wrap" id="icons-container"></div>
  </section>
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
                  <th></th>
                  <th></th>
                  <th>AppID</th>
                  <th style="width: 310px">Logo</th>
                  <th style="width: 310px">Summary</th>
                  <th>IAP / Ads</th>
                  <th>Installs</th>
                  <th>Votes</th>
                  <th>Reviews</th>
                  <th>Score</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                </div>
              </div>
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
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
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
      displayLength: 250,
      lengthMenu: [20,50, 100, 250, 500],
      serverSide: true,
      processing: false,
      ajax: {
        url: "{{route('googleplay-get-index')}}",
        type: "post",
      },
      columns: [
        { data: 'idr' },
        { data: 'id' },
        { data: 'appId' },
        { data: 'logo' }, // used for sorting so will hide this column
        { data: 'summary' },
        { data: 'size' },
        { data: 'installs' },
        { data: 'numberVoters' },
        { data: 'numberReviews' },
        { data: 'score' },
        { data: 'note',className: "change-note" },
        { data: 'action',className: "text-center" },
      ],
      columnDefs: [
        { orderable: false, targets: [10,11] },
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 0,
          targets: 0
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          responsivePriority: 2,
          render: function (data, type, full, meta) {
            return (
                    '<div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes" type="checkbox" value="'+full.appId+'" name="checkbox[]" id="checkbox' +
                    data +
                    '" /><label class="custom-control-label" for="checkbox' +
                    data +
                    '"></label></div>'
            );
          },
          checkboxes: {
            selectAllRender:
                    '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>'
          }
        },
        {
          orderable: false,
          targets: [2],
          visible: false,
        },
        {
          targets: 3,
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
          targets: 4,
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
          targets: [5],
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
      order: [[6, 'desc']],

      dom:
              '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle mr-2',
          text: feather.icons['share'].toSvg({ class: 'font-small-4 mr-50' }) + 'Export',
          buttons: [
            {
              extend: 'print',
              charset: 'UTF-8',
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Print',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8, 9] }
            },
            {
              extend: 'csv',
              charset: 'UTF-8',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8, 9] }
            },
            {
              extend: 'excel',
              charset: 'UTF-8',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8, 9] }
            },
            {
              extend: 'pdf',
              charset: 'UTF-8',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8, 9] }
            },
            {
              extend: 'copy',
              charset: 'UTF-8',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8, 9] }
            }
          ],
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
            $(node).parent().removeClass('btn-group');
            setTimeout(function () {
              $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
            }, 50);
          }
        },
      ],
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
    table.on('click', 'td:nth-child(10)', e=> {
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
    $('#searchAppForm').on('submit',function (event){
      event.preventDefault();
      $.ajax({
        data: $('#searchAppForm').serialize(),
        url: "{{ route('googleplay-post-index') }}",
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
    $(document)
            .ajaxStart(function () {
              $.blockUI({
                message:
                        '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',

                css: {
                  backgroundColor: 'transparent',
                  color: '#fff',
                  border: '0'
                },
                overlayCSS: {
                  opacity: 0.5
                }
              });
            })
            .ajaxStop(function () {
              $.unblockUI();
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


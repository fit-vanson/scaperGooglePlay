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
@endsection
@section('page-style')
  {{--   Page Css files--}}
  <link rel="stylesheet" href="{{asset('css/base/pages/ui-feather.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-swiper.css')) }}">
@endsection

@section('content')
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
                  <th>Logo</th>
                  <th style="width: 250px">Banner</th>
                  <th>IAP</th>
                  <th>Ads</th>
                  <th>Installs</th>
                  <th>Votes</th>
                  <th>Reviews</th>
                  <th>Score</th>
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

  <div class="modal fade" id="global-modal" role="dialog">
    <div class="modal-dialog modal-xl">
      <!--Modal Content-->
      <div class="modal-content">
        <section id="component-swiper-coverflow">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Screenshot</h4>
            </div>
            <div class="card-body">
              <div class="swiper-coverflow swiper-container">
                <div class="swiper-wrapper" id="screenshot_img">
                  <div class="swiper-slide" >
                    <img class="img-fluid" src="" alt="banner" />
                  </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>




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

@endsection

@section('page-script')
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  {{--  <script src="{{ asset(('js/scripts/tables/table-datatables-basic.js')) }}"></script>--}}

  <script type="text/javascript">


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var table=$('.datatables-basic').DataTable({
      displayLength: 250,
      lengthMenu: [20,50, 100, 250, 500],
      serverSide: true,
      processing: true,
      ajax: {
        url: "{{route('googleplay-get-index')}}",
        type: "post",
      },
      columns: [
        { data: 'idr' },
        { data: 'appId' },
        { data: 'appId' },
        { data: 'logo' }, // used for sorting so will hide this column
        { data: 'cover' },
        { data: 'offersIAPCost' },
        { data: 'containsAds' },
        { data: 'installs' },
        { data: 'numberVoters' },
        { data: 'numberReviews' },
        { data: 'score' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 2,
          targets: 0
        },
        {
          orderable: false,
          targets: 2,
          visible: false,
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          responsivePriority: 3,
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
          targets: 4,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            // Creates full output for row
            return '<div class="swiper-default swiper-container banner_click">'+
                      '<div class="swiper-wrapper">'+
                        '<div class="swiper-slide">'+
                          '<img class="img-fluid" style="height: 100px;" src="'+full.cover+'" alt="banner" />'+
                        '</div>'+
                      '</div>'+
                      '</div>';
          }
        },
        {
          targets: [5,6],
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            if(data == 1){
              return  '<div class="badge badge-light-success">Có</div>';
            } else {
              return '<div class="badge badge-light-danger">Không</div>';
            }
          }
        },
        {
          responsivePriority: 4,
          targets: 11
        },


      ],
      order: [[7, 'desc']],
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
              text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Print',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8] }
            },
            {
              extend: 'csv',
              text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8] }
            },
            {
              extend: 'excel',
              text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8] }
            },
            {
              extend: 'pdf',
              text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8] }
            },
            {
              extend: 'copy',
              text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 4, 5, 6, 7, 8] }
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

              return 'Details of ' + data['name'];
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
      }
    });

    table.on('click', '.banner_click', e=> {
      e.preventDefault();
      const row = table.row(e.target.closest('tr'));
      const rowData = row.data();
      let a = '';
      rowData.screenshots.forEach(function(item, index, array) {

        a += '<div class="swiper-slide">'+
                        '<img class="img-fluid screenshot_img" style= "max-width: none; height: 550px;padding: 0px 15px; display: none" src="'+item+'" alt="screenshot" />'+
                '</div>';
      })
      document.getElementById("screenshot_img").innerHTML = a;
      $('#global-modal').modal('show');


    });
    $('div.head-label').html('<h6 class="mb-0">Tìm kiếm Ứng dụng</h6>');
    $(document).on('click','.followApp', function (data) {
      const row = table.row(data.target.closest('tr'));
      const rowData = row.data();
      console.log(rowData)
      $.post('{{asset('googleplay/followApp')}}?id='+rowData.appId,function (data)
      {
        $('.modal').modal('hide');
        table.draw();
      })
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
        table.draw();
      })
    }
    var mySwiper9 = new Swiper('.swiper-coverflow', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true
      },
      pagination: {
        el: '.swiper-pagination'
      }
    });


  </script>
@endsection


@extends('layouts/contentLayoutMaster')

@section('title', 'Package')

@section('content')
    <!-- Basic ListGroups start -->
    <section id="basic-list-group">
        <div class="row match-height">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <form id="downloadAppForm" name="downloadAppForm">
                        <div class="card-header">
                            <h4 class="card-title">List Package</h4>
                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Download All</button>
                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-lg">
                                    <ul class="list-group" id="appidChose" >
                                        @foreach($appsChoose as $key=>$appChoose)
                                            <li class="list-group-item" id="{{$key}}">{{$key}} - {{$appChoose}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-lg">
                                    <ul class="list-group" >
                                        @foreach($appsChoose as $key=>$appChoose)
                                            <li class="list-group-item" id="{{$key}}">https://appgallery.cloud.huawei.com/appdl/{{$key}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- Basic ListGroups end -->

@endsection
@section('page-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#downloadAppForm').on('submit',function (event){
            event.preventDefault();
            var values = $('#appidChose li').map(function() {
                return this.id
            });
            var data = values.get().join(',');
            $.ajax({
                data: {'appID':data},
                url: "{{ route('appgallery-download-app')}}",
                type: "post",
                dataType: 'json',
                success: function (data) {
                    data= Object.entries(data)
                    data.forEach(function(item, index, array) {
                        downloadFile(item[1],item[0]);
                    })
                },
            });

            function  downloadFile(url, filename) {
                var link = document.createElement('a');
                link.href = url;
                link.download = filename;
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                link = null;
            }
        });
    </script>
@endsection


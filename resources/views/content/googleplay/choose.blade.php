@extends('layouts/contentLayoutMaster')

@section('title', 'Package')

@section('content')
    <!-- Basic ListGroups start -->
    <section id="basic-list-group">
        <div class="row match-height">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List Package</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($appsChoose as $appChoose)
                            <li class="list-group-item">{{$appChoose}}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Basic ListGroups end -->

@endsection

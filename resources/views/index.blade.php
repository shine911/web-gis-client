@extends('layouts/master_nosidebar')
@section('title', 'Web GIS Client')
@section('content')
    <div class="app-main__inner">
        <!--
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-map icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Bản đồ
                        <div class="page-title-subheading">Bản đồ ĐHCT khu II
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title">{{__("message.map.title")}}</div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="{{route('index')}}" class="active nav-link" data-toggle="tab" href="#default">Bản đồ CTU</a></li>
                            <li class="nav-item"><a href="{{route('sport-view')}}"class="nav-link">Sân Chơi</a></li>
                            <li class="nav-item"><a class="nav-link">Tìm đường đi</a></li>
                        </ul>

                        <div id="app" class="tab-content">
                            <mapglobalview-component url='@json($url)'></mapglobalview-component>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

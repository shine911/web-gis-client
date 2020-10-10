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
                            <li class="nav-item"><a class="active nav-link" data-toggle="tab" href="#default">Bản đồ CTU</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Sân Chơi</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">Tìm đường đi</a></li>
                        </ul>

                        <div id="app" class="tab-content">
                            <div id="default" class="tab-pane fade in show active">
                                <mapglobalview-component url='@json($url)'></mapglobalview-component>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <sports-grounds></sports-grounds>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <h3>Tìm kiếm đường đi</h3>
                                <p>Some content in menu 2.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

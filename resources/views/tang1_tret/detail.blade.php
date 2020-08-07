@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-map icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Sơ đồ phòng
                        <div class="page-title-subheading">{{__('message.map.edit_title', ["name"=>$name])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Bản đồ</h5>
                        <div id="app">
                            <mapeditor-component src="{{$url}}"></mapeditor-component>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin sơ đồ phòng học</h5>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

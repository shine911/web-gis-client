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
                    <div class="page-title-subheading">Sơ đồ phòng học
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                <h5 class="card-title">{{ __('message.room_info_label', ["roomname"=>$room->roomcode]) }}</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            {{__('message.room.name')}} : {{$room->roomcode}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

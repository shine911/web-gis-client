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
                        <div class="col-lg-3">
                            {{__('message.room.id')}}: {{$room->roomid}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.name')}}: {{$room->roomcode}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.buildingcode')}}: {{$room->buildingcode}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.usingpurposecode')}}: {{$room->usingpurposecode}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 mb-2">
                            {{__('message.room.roomnamevi')}}: {{$room->roomnamevi}}
                        </div>
                        <div class="col-lg-12 mb-2">
                            {{__('message.room.roomnameen')}}: {{$room->roomnameen}}
                        </div>
                        <div class="col-lg-12">
                            {{__('message.room.department')}}: {{$room->managementagencycode}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-3">
                            {{__('message.room.block')}}: {{$room->block}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.floor')}}: {{$room->floor}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.zonecode')}}: {{$room->zonecode}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.campuscode')}}: {{$room->campuscode}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-3">
                            {{__('message.room.length')}}: {{$room->length}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.width')}}: {{$room->width}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.area')}}: {{$room->area}}
                        </div>
                        <div class="col-lg-3">
                            {{__('message.room.capacity')}}: {{$room->roomcapacity}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 mb-2">
                            {{__('message.room.other1')}}: {{$room->other1}}
                        </div>
                        <div class="col-lg-12">
                            {{__('message.room.other2')}}: {{$room->other2}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

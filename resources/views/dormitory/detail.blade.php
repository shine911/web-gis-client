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
                    <div class="page-title-subheading">{{__('message.map.edit_title', ["name"=>$data->range])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin phòng học</h5>
                    <!--
                    <form action="/api/room/{{$data->id}}" class="" method="POST">
                        @method('put')
                        @csrf
                        <div class="position-relative row form-group"><label for="id"
                                class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10"><input name="id" id="id" placeholder="Please type id" type="text"
                                    class="form-control" value="{{$data->id}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="roomcode"
                                class="col-sm-2 col-form-label">{{__('message.room.name')}}</label>
                            <div class="col-sm-10"><input name="roomcode" id="roomcode" placeholder="101/B1" type="text"
                                    class="form-control" value="{{$data->roomcode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="roomnamevi"
                                class="col-sm-2 col-form-label">{{__('message.room.roomnamevi')}}</label>
                            <div class="col-sm-10"><input name="roomnamevi" id="roomnamevi" placeholder="Phòng 101/B1"
                                    type="text" class="form-control" value="{{$data->roomnamevi}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="roomnameen"
                                class="col-sm-2 col-form-label">{{__('message.room.roomnameen')}}</label>
                            <div class="col-sm-10"><input name="roomnameen" id="roomnameen" placeholder="Class 101/B1"
                                    type="text" class="form-control" value="{{$data->roomnameen}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="building"
                                class="col-sm-2 col-form-label">{{__('message.room.buildingcode')}}</label>
                            <div class="col-sm-10"><input name="buildingcode" id="buildingcode" placeholder="B1" type="text"
                                    class="form-control" value="{{$data->buildingcode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="block"
                                class="col-sm-2 col-form-label">{{__('message.room.block')}}</label>
                            <div class="col-sm-10"><input name="block" id="block" placeholder="B1" type="text"
                                    class="form-control" value="{{$data->block}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="floor"
                                class="col-sm-2 col-form-label">{{__('message.room.floor')}}</label>
                            <div class="col-sm-10"><input name="floor" id="floor" type="number" class="form-control"
                                    value="{{$data->floor}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="zonecode"
                                class="col-sm-2 col-form-label">{{__('message.room.zonecode')}}</label>
                            <div class="col-sm-10"><input name="zonecode" id="zone" type="text" class="form-control"
                                    value="{{$data->zonecode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="campuscode"
                                class="col-sm-2 col-form-label">{{__('message.room.campuscode')}}</label>
                            <div class="col-sm-10"><input name="campuscode" id="campuscode" type="number"
                                    class="form-control" value="{{$data->campuscode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="usingpurposecode"
                                class="col-sm-2 col-form-label">{{__('message.room.usingpurposecode')}}</label>
                            <div class="col-sm-10"><input name="usingpurposecode" id="usingpurposecode" type="text"
                                    class="form-control" value="{{$data->usingpurposecode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="length"
                                class="col-sm-2 col-form-label">{{__('message.room.length')}}</label>
                            <div class="col-sm-10"><input name="length" id="length" type="number" class="form-control"
                                    value="{{$data->length}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="width"
                                class="col-sm-2 col-form-label">{{__('message.room.width')}}</label>
                            <div class="col-sm-10"><input name="width" id="width" type="number" class="form-control"
                                    value="{{$data->width}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="area"
                                class="col-sm-2 col-form-label">{{__('message.room.area')}}</label>
                            <div class="col-sm-10"><input name="area" id="area" type="number" class="form-control"
                                    value="{{$data->area}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="capacity"
                                class="col-sm-2 col-form-label">{{__('message.room.capacity')}}</label>
                            <div class="col-sm-10"><input name="roomcapacity" id="capacity" type="number"
                                    class="form-control" value="{{$data->roomcapacity}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="managementagencycode"
                                class="col-sm-2 col-form-label">{{__('message.room.department')}}</label>
                            <div class="col-sm-10"><input name="managementagencycode" id="managementagencycode"
                                    type="text" class="form-control" value="{{$data->managementagencycode}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="note"
                                class="col-sm-2 col-form-label">{{__('message.room.note')}}</label>
                            <div class="col-sm-10"><input name="note" id="note"
                                    type="text" class="form-control" value="{{$data->note}}"></div>
                        </div>
                        <div class="position-relative row form-check">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-secondary">{{__('message.button.save')}}</button>
                            </div>
                        </div>
                    </form>
                    -->
                    <div id="app">
                    <dormitory-data :data="{{$data}}" url="{{$url}}"></dormitory-data>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Bản đồ</h5>
                    <div id="app">
                        <mapeditor-component :floor={{$data->floor}} :id={{$data->id}} src="{{$url}}"></mapeditor-component>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
</div>

@endsection
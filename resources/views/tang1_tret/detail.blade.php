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
                    <div class="page-title-subheading">{{__('message.map.edit_title', ["name"=>$data->roomcode])}}
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
                    <form action="/api/tang1_tret/{{$data->id}}" class="" method="POST">
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
                        <div class="position-relative row form-group"><label for="roomVi"
                                class="col-sm-2 col-form-label">{{__('message.room.roomnamevi')}}</label>
                            <div class="col-sm-10"><input name="roomVi" id="roomVi" placeholder="Phòng 101/B1"
                                    type="text" class="form-control" value="{{$data->roomVi}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="roomEn"
                                class="col-sm-2 col-form-label">{{__('message.room.roomnameen')}}</label>
                            <div class="col-sm-10"><input name="roomEn" id="roomEn" placeholder="Class 101/B1"
                                    type="text" class="form-control" value="{{$data->roomEn}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="building"
                                class="col-sm-2 col-form-label">{{__('message.room.buildingcode')}}</label>
                            <div class="col-sm-10"><input name="building" id="building" placeholder="B1" type="text"
                                    class="form-control" value="{{$data->building}}"></div>
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
                            <div class="col-sm-10"><input name="zone" id="zone" type="text" class="form-control"
                                    value="{{$data->zone}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="campuscode"
                                class="col-sm-2 col-form-label">{{__('message.room.campuscode')}}</label>
                            <div class="col-sm-10"><input name="campuscode" id="campuscode" type="number"
                                    class="form-control" value="{{$data['campus Code']}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="using"
                                class="col-sm-2 col-form-label">{{__('message.room.usingpurposecode')}}</label>
                            <div class="col-sm-10"><input name="using" id="using" type="text" class="form-control"
                                    value="{{$data->using}}"></div>
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
                            <div class="col-sm-10"><input name="capacity" id="capacity" type="number"
                                    class="form-control" value="{{$data->capacity}}"></div>
                        </div>
                        <div class="position-relative row form-group"><label for="mAgencyCode"
                                class="col-sm-2 col-form-label">{{__('message.room.department')}}</label>
                            <div class="col-sm-10"><input name="mAgencyCode" id="mAgencyCode" type="text"
                                    class="form-control" value="{{$data['management agency code']}}"></div>
                        </div>
                        <div class="position-relative row form-check">
                            <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-secondary">{{__('message.button.save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Bản đồ</h5>
                    <div id="app">
                        <mapeditor-component :id={{$id}} src="{{$url}}"></mapeditor-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

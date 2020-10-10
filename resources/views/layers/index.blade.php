@extends('layouts.master', ['floors'=>$floors])
@section('title', 'Quan li layer')
@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-map icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Quản lí layer
                        <div class="page-title-subheading">Quản lí các lớp bản đồ
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin các lớp bản đồ</h5>
                        <a href="{{route('layers.create')}}">Create</a>
                        <form class="form-inline mb-4 d-flex flex-row-reverse" method="GET" action="/layer">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control">
                                <button class="ml-4 btn btn-primary">{{__('message.button.search')}}</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Layer</th>
                                    <th>Phân loại</th>
                                    <th>Ẩn</th>
                                    <th>Tác vụ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dataLayer as $item)
                                    <tr>
                                        <th scope="row">{{$item->id}}</th>
                                        <td>{{$item->layer_name}}</td>
                                        <td>{{$item->layer_type}}</td>
                                        <td>{{$item->user_hide ? 'Hide':'Show'}}</td>
                                        <td><a href="{{action('Web\LayersController@detail', ['id'=>$item->id])}}" class="btn btn-primary">{{__('message.button.view_info')}}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{$dataLayer->appends(['search' => $search])->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

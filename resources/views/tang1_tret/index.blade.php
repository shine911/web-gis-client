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
                    <h5 class="card-title">Bản đồ</h5>
                    <div id="app">
                        <mapview-component src="{{$url}}"></mapview-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin sơ đồ phòng học</h5>
                    <form class="form-inline mb-4 d-flex flex-row-reverse" method="GET" action="">
                        <div class="form-group">
                        <input type="text" value="{{$search}}" name="search" class="form-control">
                            <button class="ml-4 btn btn-primary">{{__('message.button.search')}}</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="mb-0 table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Phòng</th>
                                    <th>Khoa trực thuộc</th>
                                    <th>Sức chứa</th>
                                    <th>Toà nhà</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <th scope="row">{{$item->id}}</th>
                                    <td>{{$item->roomcode}}</td>
                                    <td>{{$item['management agency code']}}</td>
                                    <td>{{$item->capacity}}</td>
                                    <td>{{$item->building}}</td>

                                    <td><a href="{{action('Web\Tang1_TretController@detail', ['id'=>$item->id])}}"
                                            class="btn btn-primary">{{__('message.button.view_info')}}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{$data->appends(['search' => $search])->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

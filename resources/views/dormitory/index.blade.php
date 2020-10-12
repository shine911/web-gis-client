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
                <div>Quản lí dữ liệu ký tuc xá
                    <div class="page-title-subheading">Sơ đồ ký túc xá
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
                        <mapview-component src="{{$layerObj->url}}"></mapview-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin sơ đồ phòng ký túc xá</h5>
                    <form class="form-inline mb-4 d-flex flex-row-reverse" method="GET" action="/room">
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
                                    <th>Tên</th>
                                    <th>Khu</th>
                                    <th>Sức chứa</th>
                                    <th>Toà nhà</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <th scope="row">{{$item->id}}</th>
                                    <td>{{$item->range}}</td>
                                    <td>{{$item->block}}</td>
                                    <td>{{$item->roomcapity}}</td>
                                    <td>{{$item->building}}</td>
                                <td>
                                    <a href="{{route('dormitory.detail', ['layerId'=>$layerObj->id, 'floor'=>$layerObj->floor, 'id'=>$item->id])}}"
                                        class="btn btn-primary">{{__('message.button.view_info')}}</a>
                                </td>
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

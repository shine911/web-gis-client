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
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <form method="POST" action="/layers/create">
                                    @csrf
                                    <div class="form-group">
                                        <label for="layer_name">Tên Layer</label>
                                        <input type="text" class="form-control" name="layer_name" id="layer_name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Địa chỉ Layer</label>
                                        <textarea class="form-control" name="url" id="url"></textarea>
                                    </div>
                                    <div class="form-check-inline">
                                        <label for="user_hidden" class="form-check-label">Ẩn phía User </label>
                                        <input type="checkbox" class="form-check-input" name="user_hidden" id="user_hidden" />
                                    </div>
                                    <div class="form-group">
                                        <label for="layer_type">Loại Layer</label>
                                        <input type="text" class="form-control" name="layer_type" id="layer_type" />
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="btnSub" value="Submit" />
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts/master_nosidebar')
@section('title', 'Đăng nhập vào hệ thống')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-map icon-gradient bg-premium-dark">
                    </i>
                </div>
                <div>Đăng nhập
                    <div class="page-title-subheading">Chào mừng bạn đến với hệ thống Web GIS
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="card-title">Đăng nhập vào hệ thống Web GIS</div>
                    <form action="/home" method="GET">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail11" class="">Email</label>
                                    <input name="email" id="email" type="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail11" class="">Mật khẩu</label>
                                    <input name="password" id="password" type="password" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
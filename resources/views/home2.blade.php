@extends('layouts.master', ['floors'=>$floors])
@section('title', 'Web GIS Client')
@section('content')
    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-map icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Bản đồ
                        <div class="page-title-subheading">Bản đồ ĐHCT khu II
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title">Bản đồ ĐHCT</div>
                        <div id="app">
                            <mapglobalview-component :user-hide-logic="false" url-water='@json($waterNetwork)' url-electric='@json($electricNetwork)' url='@json($floors)' url-dormity='@json($dormitories)'></mapglobalview-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')
@section('title', 'Map Editor')
@section('link-style')
<link rel="stylesheet" href="{{$app->make('url')->to('/')}}/assets/openlayer/editor/editor.04a6741d.css">
<script src="https://unpkg.com/elm-pep"></script>
<style>
    .map{
        width: 100%;
        height: 500px;
    }
</style>
@endsection
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
                    <div id="app">
                        <mapeditor-component></mapeditor-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

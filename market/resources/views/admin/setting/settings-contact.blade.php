@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.setting-contact',app()->getLocale())}}">{{__('Contact Settings')}}</a></li>
    </ol>
@endsection
@section('css')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{__('Email')}}</label>
                            <div class="col-sm-10">
                                <input id="email" name="email" type="text" class="form-control"
                                       value="{{setting('contact.email')}}">
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('Russian')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('English')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings-b2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('Armenian')}}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-b2">
                                @foreach($settings as $setting)
                                    @if($setting->name != 'email')
                                        <div class="form-group row">
                                            <label for="{{$setting->name}}" class="col-sm-2 col-form-label">{{$setting->display_name}}</label>
                                            <div class="col-sm-10">
                                                <input id="{{$setting->name}}" name="{{$setting->name}}_ru" type="text" class="form-control"
                                                       value="{{isset($setting->translations['value']['ru'])?$setting->translations['value']['ru']:''}}">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane show" id="profile-b2">
                                @foreach($settings as $setting)
                                    @if($setting->name != 'email')
                                        <div class="form-group row">
                                            <label for="{{$setting->name}}" class="col-sm-2 col-form-label">{{$setting->display_name}}</label>
                                            <div class="col-sm-10">
                                                <input id="{{$setting->name}}" name="{{$setting->name}}_en" type="text" class="form-control"
                                                       value="{{isset($setting->translations['value']['en'])?$setting->translations['value']['en']:''}}">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="settings-b2">
                                @foreach($settings as $setting)
                                    @if($setting->name != 'email')
                                        <div class="form-group row">
                                            <label for="{{$setting->name}}" class="col-sm-2 col-form-label">{{$setting->display_name}}</label>
                                            <div class="col-sm-10">
                                                <input id="{{$setting->name}}" name="{{$setting->name}}_am" type="text" class="form-control"
                                                       value="{{isset($setting->translations['value']['am'])?$setting->translations['value']['am']:''}}">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection

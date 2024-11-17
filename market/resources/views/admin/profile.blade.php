@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('My Profile')}}</li>
    </ol>
@endsection
@section('css')
@endsection
@section('script')
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
                        <div class="row">
                <form method="POST" action="" class="col-12 col-md-6 border pb-3">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-12 col-form-label">{{__('Name')}}</label>
                        <div class="col-sm-10">
                            <input id="name" name="name" type="text" class="form-control" value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-12 col-form-label">{{__('Email')}}</label>
                        <div class="col-sm-10">
                            <input id="email" name="email" type="text" class="form-control" value="{{$user->email}}">
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
                        <form method="POST" autocomplete="off" action="{{route('admin.password',app()->getLocale())}}" class="col-12 col-md-6 border pb-3">
                            @csrf
                            <div class="form-group row">
                                <label for="old_password" class="col-12 col-form-label">{{__('Current Password')}}</label>
                                <div class="col-sm-10">
                                    <input id="old_password" name="current_password" type="password" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-12 col-form-label">{{__('New Password')}}</label>
                                <div class="col-sm-10">
                                    <input id="new_password" name="password" type="password" class="form-control" value="" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-12 col-form-label">{{__('New Password Confirmation')}}</label>
                                <div class="col-sm-10">
                                    <input id="password" name="password_confirmation" type="password" class="form-control"  value="" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Change Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

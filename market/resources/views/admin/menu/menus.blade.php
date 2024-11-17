@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Menus')}}</li>
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
{{--                    <a href="{{route('admin.menu-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>--}}
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
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td>{{$menu->name}}</td>
                            <td>
                            <a href="{{route('admin.menu-builder',['locale'=>app()->getLocale(),'id'=>$menu->id])}}">
                                <button type="button" class="btn btn-success"><i class="fas fa-list"></i> {{__('Builder')}}</button>
                            </a>
                            {{--<a href="{{route('admin.menu',['locale'=>app()->getLocale(),'id'=>$menu->id])}}">
                                <button type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> {{__('Edit')}}</button>
                            </a>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.menu-delete',['locale'=>app()->getLocale(),'id'=>$menu->id])}}">
                                <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i> {{__('Delete')}}</button>
                            </a>--}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

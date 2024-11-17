@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Sliders')}}</li>
    </ol>
@endsection
@section('css')
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.css') }}">
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.js') }}"></script>
@endsection
@section('script')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.slider-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>
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
                            <th scope="col">{{__('Image')}}</th>
                            <th scope="col">{{__('Title')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $slider)
                        <tr>
                            <th scope="row">
                                @if($slider->image_name_resize !='')
                                <a data-fancybox="del" href="{{asset($slider->image_name)}}"><img src="{{asset($slider->image_name_resize)}}" style="width: 40px;border-radius: 4px;"></a>
                                @endif
                            </th>
                            <td>{{$slider->title}}</td>
                            <td>
                                @if($slider->status)
                                    <small class="badge badge-default badge-success form-text text-white">
                                        {{__('Published')}}
                                    </small>
                                @else
                                    <small class="badge badge-default badge-danger form-text text-white">
                                        {{__('Not Published')}}
                                    </small>
                                @endif
                            </td>
                            <td>
                            <a href="{{route('admin.slider',['locale'=>app()->getLocale(),'id'=>$slider->id])}}"><button type="button" class="btn btn-secondary"><i class="ti-pencil-alt"></i></button></a>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.slider-delete',['locale'=>app()->getLocale(),'id'=>$slider->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$sliders->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

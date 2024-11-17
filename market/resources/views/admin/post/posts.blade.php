@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Posts')}}</li>
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
                    <div style="display: flex;justify-content: space-between">
                    <a href="{{route('admin.post-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>
                    <form method="get" action="" class="input-group col-md-4 search-group">
                        <input name="search_term" class="form-control py-2 border-right-0 border" type="search" id="product-search-input" value="{{request()->get('search_term')?request()->get('search_term'):''}}">
                        <span class="input-group-append">
                <button class="btn btn-outline-secondary border-left-0 border" type="submit">
                    <i class="fa fa-search"></i>
                </button>
              </span>
                    </form>
                    </div>
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
                        @foreach($posts as $post)
                        <tr>
                            <th scope="row">
                                @if($post->image_name_resize !='')
                                <a data-fancybox="del" href="{{asset($post->image_name)}}"><img src="{{asset($post->image_name_resize)}}" style="width: 40px;border-radius: 4px;"></a>
                                @endif
                            </th>
                            <td>{{$post->title}}</td>
                            <td>
                                @if($post->status)
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
                            <a href="{{route('admin.post',['locale'=>app()->getLocale(),'id'=>$post->id])}}"><button type="button" class="btn btn-secondary"><i class="ti-pencil-alt"></i></button></a>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.post-delete',['locale'=>app()->getLocale(),'id'=>$post->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?php echo e($posts->appends($_GET)->links()); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
